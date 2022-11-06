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
    <script src="./index.js"></script>
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
    </main>
    <footer>
        Copyright &copy; Book repository 2022. All rights reserved.
    </footer>
</body>
</html>