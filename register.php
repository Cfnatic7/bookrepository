<?php
    session_start();

    if (isset($_POST['email'])) {
        $formOk = true;
        $userName = $_POST['username'];
        if (strlen($userName) < 8 || strlen($userName) > 20) {
            $formOk = false;
            $_SESSION['e_username'] = 'User name\'s length must be between 8 and 20 letters';
        }

        if (ctype_alnum($userName) == false) {
            $formOk = false;
            $_SESSION['e_username'] = 'User name must be alphanumeric';
        }

        $email = $_POST['email'];
        $emailSanitized = filter_var($email, FILTER_SANITIZE_EMAIL);
        if (filter_var($emailSanitized, FILTER_VALIDATE_EMAIL) == false || $email != $emailSanitized) {
            $formOk = false;
            $_SESSION['e_email'] = 'Incorrect email address';
        }

        $pwd = $_POST['password'];
        $pwd2 = $_POST['password2'];

        if (strlen($pwd) < 8 || strlen($pwd) > 20) {
            $formOk = false;
            $_SESSION['e_password'] = 'Password\'s length must be between 8 and 20 letters';
        }

        if ($pwd != $pwd2) {
            $formOk = false;
            $_SESSION['e_password2'] = 'Password doesn\'t match';
        }

        $hashedPassword = password_hash($pwd, PASSWORD_DEFAULT);

        require_once "connect.php";
        mysqli_report(MYSQLI_REPORT_STRICT);
        

        try {
            $connection = new mysqli($host, $db_user, $db_password, $db_name);
            if ($connection->errno != 0) {
                throw new Exception(mysqli_connect_errno());
            }
            else {
                $name = $_POST['name'];
                $nameSanitized = htmlentities($name, ENT_QUOTES, 'UTF-8');

                if (strlen($name) < 2 || strlen($name) > 20) {
                    $formOk = false;
                    $_SESSION['e_name'] = 'Name\'s length has to be between 2 and 20 letters';
                }
        
                if ($name != $nameSanitized) {
                    $formOk = false;
                    $_SESSION['e_name'] = 'Name is incorrect';
                }
        
                $nameSanitized = mysqli_real_escape_string($connection, $nameSanitized);
                if ($nameSanitized != $name) {
                    $formOk = false;
                    $_SESSION['e_name'] = 'Name is incorrect';
                }

                $surname = $_POST['surname'];
                $surnameSanitized = htmlentities($surname, ENT_QUOTES, 'UTF-8');

                if (strlen($surname) < 2 || strlen($surname) > 20) {
                    $formOk = false;
                    $_SESSION['e_surname'] = 'Surname\'s length has to be between 2 and 20 letters';
                }
        
                if ($surname != $surnameSanitized) {
                    $formOk = false;
                    $_SESSION['e_surname'] = 'Surname is incorrect';
                }
        
                $surnameSanitized = mysqli_real_escape_string($connection, $surnameSanitized);
                if ($surnameSanitized != $surname) {
                    $formOk = false;
                    $_SESSION['e_surname'] = 'Surname is incorrect';
                }


                $result = $connection->query("SELECT id FROM `users` WHERE email='$email'");

                if (!$result) throw new Exception($connection->error);

                $how_many_mails = $result->num_rows;

                if ($how_many_mails > 0) {
                    $formOk = false;
                    $_SESSION['e_email'] = 'Email address is already in use';
                }

                $result->close();

                $result = $connection->query("SELECT id FROM `users` WHERE login='$userName'");

                if (!$result) throw new Exception($connection->error);

                $how_many_logins = $result->num_rows;

                if ($how_many_logins > 0) {
                    $formOk = false;
                    $_SESSION['e_username'] = 'User name is already in use';
                }

                if ($formOk == true) {
                    unset($_SESSION['error']);

                    if ($connection->query("INSERT INTO `users` VALUES(NULL, '$userName', '$hashedPassword', 
                    '$email', '$name', '$surname', NULL, NULL)")) {
                        $_SESSION['registered']=true;
                    }
                    else {
                        $_SESSION['registered'] = false;
                        throw new Exception($connection->error);
                    }
                }
                else {
                    unset($_SESSION['registered']);
                    $_SESSION['error'] = 'Registration Failed';
                    header('location: index.php');
                }

                $result->close();

                $connection->close();
            }
        } catch(Exception $e) {
            echo "Server error. Database is down. Sorry for inconvenience. <br/>";
            echo "Information for developers: ".$e;
        }
    }


?>