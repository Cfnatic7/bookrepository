<?php
    require_once "connect.php";
    session_start();

    $connection = @new mysqli($host, $db_user, $db_password, $db_name);

    if ($connection->connect_errno != 0) {
        echo "Error: ".$connection->connect_errno."Description: ".$connection->connect_error;
    }
    else {
        $userName = $_POST['username'];
        $password = $_POST['password'];
        $query = "SELECT * FROM `users` WHERE login='$userName' AND `password`='$password'";

        if ($result = $connection->query($query)) {
            $users = $result->num_rows;
            if ($users > 0) {
                $row = $result->fetch_assoc();
                $_SESSION['user'] = $row['login'];
                $_SESSION['description'] = $row['description'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['surname'] = $row['surname'];
                $result->close();
                header('Location: ./user/user.php');
            } else {
                $_SESSION['error'] = 'Nieprawidłowy login lub hasło';
                header('Location: index.php');
            }
        }

        $connection->close();
    }

?>