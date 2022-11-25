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
        if (isset($_SESSION['error']) && $_SESSION['error'] == 'Incorrect login or password') {
            echo "<script src='./error-login-index.js' defer></script>";
        }
        else if (isset($_SESSION['error'])) {
            echo "<script src='./error-register-index.js' defer></script>";
        }
        else if (isset($_SESSION['goToLogin']) && $_SESSION['goToLogin'] == true) {
            echo "<script src='./error-login-index.js' defer></script>";
            unset($_SESSION['goToLogin']);
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
        <span id="welcome-text" class='welcome-text'>Home for all your books
        <svg class = 'sexy-underline' aria-hidden="true" viewBox="0 0 418 42" class="absolute top-2/3 left-0 h-[0.58em] w-full fill-blue-300/70" preserveAspectRatio="none"><path d="M203.371.916c-26.013-2.078-76.686 1.963-124.73 9.946L67.3 12.749C35.421 18.062 18.2 21.766 6.004 25.934 1.244 27.561.828 27.778.874 28.61c.07 1.214.828 1.121 9.595-1.176 9.072-2.377 17.15-3.92 39.246-7.496C123.565 7.986 157.869 4.492 195.942 5.046c7.461.108 19.25 1.696 19.17 2.582-.107 1.183-7.874 4.31-25.75 10.366-21.992 7.45-35.43 12.534-36.701 13.884-2.173 2.308-.202 4.407 4.442 4.734 2.654.187 3.263.157 15.593-.78 35.401-2.686 57.944-3.488 88.365-3.143 46.327.526 75.721 2.23 130.788 7.584 19.787 1.924 20.814 1.98 24.557 1.332l.066-.011c1.201-.203 1.53-1.825.399-2.335-2.911-1.31-4.893-1.604-22.048-3.261-57.509-5.556-87.871-7.36-132.059-7.842-23.239-.254-33.617-.116-50.627.674-11.629.54-42.371 2.494-46.696 2.967-2.359.259 8.133-3.625 26.504-9.81 23.239-7.825 27.934-10.149 28.304-14.005.417-4.348-3.529-6-16.878-7.066Z"></path></svg>
        </span>
        <form class = 'login-form' id = 'login-form' action="login.php" method="POST"> 
            <div> 
                <span>Username</span>
                <input type="text" name="login" value = "<?php 
                    if (isset($_SESSION['lfUserName'])) {
                        echo $_SESSION['lfUserName'];
                        unset($_SESSION['lfUserName']);
                    }
                ?>"
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
                if (isset($_SESSION['error']) && $_SESSION['error'] == 'Incorrect login or password') {
                    echo "<p style='color:red; font-family: Arial, Helvetica, sans-serif; text-align: center; width:100%'>"
                    .$_SESSION['error']."</p>";
                }
            ?>
        </form>
        <form class = 'register-form' id = 'register-form' method='POST' action='register.php'> 
            <div> 
                <span>Name</span>
                <input type='text' name='name' value = "<?php if(isset($_SESSION['rfName'])) {
                    echo $_SESSION['rfName'];
                    unset($_SESSION['rfName']);
                }?>"
                minlength='2' maxlength='20' required>
            </div>
            <?php
                    if (isset($_SESSION['e_name'])) {
                        echo "<p style='margin:0;padding-right:7%;color:red; font-family: Arial, Helvetica, sans-serif; text-align: right; width:100%'>"
                        .$_SESSION['e_name']."</p>";
                    }
                ?>
            <div> 
                <span>Surname</span>
                <input type='text' name='surname' value = "<?php if(isset($_SESSION['rfSurname'])) {
                    echo $_SESSION['rfSurname'];
                    unset($_SESSION['rfSurname']);
                }?>"
                minlength='2' maxlength='20' required>

            </div>
            <?php
                    if (isset($_SESSION['e_surname'])) {
                        echo "<p style='margin:0;padding-right:7%;color:red; font-family: Arial, Helvetica, sans-serif; text-align: right; width:100%'>"
                        .$_SESSION['e_surname']."</p>";
                    }
                ?>
            <div> 
                <span>Email</span>
                <input type='email' name='email' value = "<?php if(isset($_SESSION['rfEmail'])) {
                    echo $_SESSION['rfEmail'];
                    unset($_SESSION['rfEmail']);
                }?>"
                maxlength='40'
                required>
            </div>
            <?php
                    if (isset($_SESSION['e_email'])) {
                        echo "<p style='margin:0;padding-right:7%;color:red; font-family: Arial, Helvetica, sans-serif; text-align: right; width:100%'>"
                        .$_SESSION['e_email']."</p>";
                    }
                ?>
            <div> 
                <span>Username</span>
                <input type='text' name='username' value = "<?php if(isset($_SESSION['rfUserName'])) {
                    echo $_SESSION['rfUserName'];
                    unset($_SESSION['rfUserName']);
                }?>"
                minlength='8' maxlength='20' required>
            </div>
            <?php
                    if (isset($_SESSION['e_username'])) {
                        echo "<p style='margin:0;padding-right:7%;color:red; font-family: Arial, Helvetica, sans-serif; text-align: right; width:100%'>"
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
                        echo "<p style='margin:0;padding-right:7%;color:red; font-family: Arial, Helvetica, sans-serif; text-align: right; width:100%'>"
                        .$_SESSION['e_password']."</p>";
                    }
                ?>
            <div>
                <span>Repeat password</span>
                <input type='password' name='password2' 
                minlength='8' maxlength='20' required>
            </div>
            <?php
                    if (isset($_SESSION['e_password'])) {
                        echo "<p style='margin:0;padding-right:7%;color:red; font-family: Arial, Helvetica, sans-serif; text-align: right; width:100%'>"
                        .$_SESSION['e_password']."</p>";
                    }
                ?>
            <div>
                <button type='submit' id='register'>Register</button>
            </div>
        </form>
        <div class="watermark">
            <!-- Watermark container -->
            <div class="watermark__inner">
                <!-- The watermark -->
                <div class="watermark__body">Book repository</div>
            </div>

            <!-- Other content -->
        </div>
    </main>
    <footer>
        Copyright &copy; Book repository 2022. All rights reserved.
    </footer>
</body>
</html>