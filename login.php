<?php
    require_once "connect.php";

    $connection = @new mysqli($host, $db_user, $db_password, $db_name);

    if ($connection->connect_errno != 0) {
        echo "Error: ".$connection->connect_errno."Description: ".$connection->connect_error;
    }
    else {
        $userName = $_POST['username'];
        $password = $_POST['password'];
        $query = "SELECT * FROM `users` WHERE login='$userName' AND `password`='$password'";

        if ($result = $connection->query($sql)) {
            $users = $result->num_rows;
            if ($users > 0) {
                $row = $result->fetch_assoc();
                $user = $row['login'];
                $result->close();
                echo $user;
            } else {

            }
        }

        $connection->close();
    }

?>