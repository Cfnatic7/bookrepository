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
    <script src="https://kit.fontawesome.com/8eaacae2ec.js" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>
    <header>
        <div>
            <h2 class='header-text'>
                    <?php  echo  "Welcome ".$_SESSION['user']."!"; ?>
            </h2>
        </div>

        <form method='GET' action='search-books.php' id='search-books'> 
            <input type = 'text' placeholder='search books'> 

            </input>
            <button type='submit' id='search-books-button'>
                <i class="fa-solid fa-magnifying-glass">
                </i>
            </button>
        </form>
        <div>
            <button type='button' onclick='logoutOnClick()' class='logout-button'>Logout</button>
        </div>
    </header>
    <main>
        <div class='user-display'>
            <i class="fa-solid fa-user"></i>
            <?php
                echo "<p>".$_SESSION['user']."</p>";
            ?>
            <hr class='user-hr'>
            <?php
                if (strlen($_SESSION['description'] > 0)) {
                    echo "<p>".$_SESSION['description']."</p>";
                }
            ?>
            <form method='GET' action='user.php'> 
                <button type='submit' class='change-description-button'>Change description</button>
                <input type='hidden' name='description' value='change'> </input>
            </form >
            <hr class='user-hr'>
            <form method='GET' action='user.php'> 
                <button type='submit' class='display-books-button'>Your books</button>
                <input type='hidden' name='books' value='get'> </input>
            </form >
            <hr class='user-hr'>
            <form method='GET' action='user.php'> 
                <button type='submit' class='display-reviews-button'>Your reviews</button>
                <input type='hidden' name='reviews' value='get'> </input>
            </form >
        </div>
    </main>
    
</body>
</html>