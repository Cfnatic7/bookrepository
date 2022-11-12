<?php 
    session_start();
    if (!isset($_SESSION['loggedIn'])) {
        header('Location: ../index.php');
        exit();
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href = "../normalize.css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./user.css">
    <script src = './user.js' defer></script>
    <title>Document</title>
</head>
<body>
    <?php
        echo"<header>
                <div>
                    <h2 class='header-text'>
                        Welcome ".$_SESSION['user']."!
                    </h2>
                </div>
                <div>
                    <button type='button' onclick='logoutOnClick()' class='logout-button'>Logout</button>
                </div>
            </header>";
    ?>
</body>
</html>