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


        if ($formOk == true) {

        }
        else {
            header('location: index.php');
        }
    }


?>