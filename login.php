<?php
    require_once "connect.php";
    session_start();

    $connection = @new mysqli($host, $db_user, $db_password, $db_name);

    if ($connection->connect_errno != 0) {
        echo "Error: ".$connection->connect_errno."Description: ".$connection->connect_error;
    }
    else {

        if (!isset($_POST['login']) || !isset($_POST['password'])) {
            header('Location: index.php');
            exit();
        }
        $userName = $_POST['login'];
        $password = $_POST['password'];

        $userName = htmlentities($userName, ENT_QUOTES, 'UTF-8');

        if ($result = $connection->query(sprintf("SELECT * FROM `users` 
        WHERE login='%s'", mysqli_real_escape_string($connection, $userName)))) {
            $users = $result->num_rows;
            if ($users > 0) {
                $row = $result->fetch_assoc();
                if (password_verify($password, $row['password']) == true) {
                    $_SESSION['loggedIn'] = true;
                    $_SESSION['id'] = $row->id;
                    $_SESSION['user'] = $row['login'];
                    $_SESSION['description'] = $row['description'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['name'] = $row['name'];
                    $_SESSION['surname'] = $row['surname'];
                    unset($_SESSION['error']);
                    $result->close();
                    header('Location: ./user/user.php');
                }
                else {
                    $_SESSION['error'] = 'Incorrect login or password';
                    $_SESSION['lfUserName'] = $userName;
                    header('Location: index.php');
                }
            } else {
                $_SESSION['error'] = 'Incorrect login or password';
                $_SESSION['lfUserName'] = $userName;
                header('Location: index.php');
            }
        }

        $connection->close();
    }

?>