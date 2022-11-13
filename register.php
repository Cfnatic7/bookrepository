<?php
    session_start();

    if (isset($_POST['email'])) {
        $formOk = true;
        $userName = $_POST['username'];
        if (strlen($userName) < 8 || strlen($userName) > 20) {
            $formOk = false;
            $_SESSION['e_username'] = 'Nazwa użytkownika musi posiadać od 8 do 20 znaków';
        }

        if ($formOk == true) {

        }
        else {
            header('location: index.php');
        }
    }


?>