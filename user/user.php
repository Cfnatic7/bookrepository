<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        session_start();
        echo "Witaj ".$_SESSION['user']."!</br>";
        echo "Email: ".$_SESSION['email']."</br>";
        echo "imię: ".$_SESSION['name']."</br>";
        echo "nazwisko: ".$_SESSION['surname']."</br>";
        echo "Opis: ".$_SESSION['description']."</br>";

    ?>
</body>
</html>