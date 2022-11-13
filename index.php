<?php
    session_start();
    if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true) {
        header('Location: ./user/user.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./normalize.css">
    <link rel="stylesheet" href="./index.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat&display=swap" rel="stylesheet">
    <?php
        if (isset($_SESSION['error']) && $_SESSION['error'] == 'Nieprawidłowy login lub hasło') {
            echo "<script src='./error-login-index.js' defer></script>";
        }
        else if (isset($_SESSION['error'])) {
            echo "<script src='./error-register-index.js' defer></script>";
        }
        else echo "<script src='./index.js' defer></script>";
    ?>
    
    <title>Book repository</title>
</head>
<body>
    <header>
        <div>
            <h2 class="header-text">
                Welcome to the book repository!
            </h2>
        </div>
        <div>
            <button type="button" onclick="chooseLoginOnCLick()" class="login-button">Login</button>
            <button type="button" onclick="chooseRegisterOnClick()" class="register-button">Register</button>
        </div>
    </header>

    <main id="main">
        <span id="welcome-text">Home for all your books</span>
        <form class = 'login-form' id = 'login-form' action="login.php" method="POST"> 
            <div> 
                <span>Username</span>
                <input type="text" name="login"
                minlength="8" maxlength="20" required>
            </div>
            <div>
                <span>Password</span>
                <input type="password" name="password" 
                minlength="8" maxlength="20" required>
            </div>
            <div>
                <button type="submit" id="login">Login</button>
            </div>
            <?php
                if (isset($_SESSION['error'])) {
                    echo "<p style='color:red; font-family: Arial, Helvetica, sans-serif; text-align: center; width:100%'>"
                    .$_SESSION['error']."</p>";
                }
            ?>
        </form>
        <form class = 'register-form' id = 'register-form' method='POST' action='register.php'> 
            <div> 
                <span>Name</span>
                <input type='text' name='name'
                minlength='2' maxlength='20' required>
            </div>
            <?php
                    if (isset($_SESSION['e_name'])) {
                        echo "<p style='padding-right:7%;color:red; font-family: Arial, Helvetica, sans-serif; text-align: right; width:100%'>"
                        .$_SESSION['e_name']."</p>";
                    }
                ?>
            <div> 
                <span>Surname</span>
                <input type='text' name='surname'
                minlength='2' maxlength='20' required>

            </div>
            <?php
                    if (isset($_SESSION['e_surname'])) {
                        echo "<p style='padding-right:7%;color:red; font-family: Arial, Helvetica, sans-serif; text-align: right; width:100%'>"
                        .$_SESSION['e_surname']."</p>";
                    }
                ?>
            <div> 
                <span>email</span>
                <input type='email' name='email'
                maxlength='40'
                required>
            </div>
            <?php
                    if (isset($_SESSION['e_email'])) {
                        echo "<p style='padding-right:7%;color:red; font-family: Arial, Helvetica, sans-serif; text-align: right; width:100%'>"
                        .$_SESSION['e_email']."</p>";
                    }
                ?>
            <div> 
                <span>Username</span>
                <input type='text' name='username'
                minlength='8' maxlength='20' required>
            </div>
            <?php
                    if (isset($_SESSION['e_username'])) {
                        echo "<p style='padding-right:7%;color:red; font-family: Arial, Helvetica, sans-serif; text-align: right; width:100%'>"
                        .$_SESSION['e_username']."</p>";
                    }
                ?>
            <div>
                <span>Password</span>
                <input type='password' name='password' 
                minlength='8' maxlength='20' required>
            </div>
            <?php
                    if (isset($_SESSION['e_password'])) {
                        echo "<p style='padding-right:7%;color:red; font-family: Arial, Helvetica, sans-serif; text-align: right; width:100%'>"
                        .$_SESSION['e_password']."</p>";
                    }
                ?>
            <div>
                <button type='submit' id='register'>Register</button>
            </div>
        </form>

    </main>
    <footer>
        Copyright &copy; Book repository 2022. All rights reserved.
    </footer>
</body>
</html>