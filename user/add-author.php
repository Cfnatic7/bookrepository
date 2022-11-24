<?php 
    session_start();
    if (!isset($_SESSION['loggedIn']) || !isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
        header('Location: ../index.php');
        exit();
    }
    require_once "../connect.php";
    require_once "../utility/sanitizers.php";
    try {
        $connection = new mysqli($host, $db_user, $db_password, $db_name);
        $authorName = sanitizeInput($_POST['author-name'], $connection);
        $authorSurname = sanitizeInput($_POST['author-surname'], $connection);
        $shortBiography = sanitizeInput($_POST['short-biography'], $connection);
        $dateOfBirth = sanitizeInput($_POST['author-birth-date'], $connection);
        if ($connection->errno != 0) {
            throw new Exception(mysqli_connect_errno());
        }
        $query = "INSERT INTO `authors` VALUES(NULL, '$authorName', '$authorSurname', '$dateOfBirth', '$shortBiography')";
        $_SESSION['author-add-result'] = $connection->query($query);
        $connection->close();
        unset($_POST['author-name']);
        unset($_POST['author-surname']);
        unset($_POST['short-biography']);
        unset($_POST['author-birth-date']);
        header('Location: ../index.php');
    } catch (Exception $e) {
        echo "Server error. Database is down. Sorry for inconvenience. <br/>";
        echo "Information for developers: ".$e;
    }

?>