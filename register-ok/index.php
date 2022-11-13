<?php 
    session_start();

    if (isset($_SESSION['registered']) && $_SESSION['registered'] == true) {
        unset($_SESSION['registered']);
    }
    else {
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
    <link rel="stylesheet" href = "./index.css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat&display=swap" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <header>
        <div>
            <h2 class="header-text">
                Welcome to the book repository!
            </h2>
        </div>
    </header>
    <main> 
        <form class = 'form' id = 'form' method='POST' action='go-to-login.php'>
            <span class = 'account-ready'>Your account is ready!</span>

            <div>
                <button type='submit' id='form-button'>Go to login page</button>
            </div>
        </form>
    </main>
    <footer>
        Copyright &copy; Book repository 2022. All rights reserved.
    </footer>
</body>
</html>