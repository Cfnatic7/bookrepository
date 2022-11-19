<?php 
    session_start();
    if (!isset($_SESSION['loggedIn'])) {
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
        $authorId = sanitizeInput($_POST['author-id'], $connection);
        if ($connection->errno != 0) {
            throw new Exception(mysqli_connect_errno());
        }
        $query = "UPDATE `authors` SET name = '$authorName', surname = '$authorSurname', 
        short_biography = '$shortBiography', date_of_birth = '$dateOfBirth' WHERE id = '$authorId'";
        $_SESSION['author-edit-result'] = $connection->query($query);
        $connection->close();
        header('Location: ../index.php');
    } catch (Exception $e) {
        echo "Server error. Database is down. Sorry for inconvenience. <br/>";
        echo "Information for developers: ".$e;
    }

?>