<?php 
    session_start();
    if (!isset($_SESSION['loggedIn']) || !isset($_seSSION['role']) || $_SESSION['role'] != 'admin') {
        header('Location: ../index.php');
        exit();
    }
    require_once "../connect.php";
    require_once "../utility/sanitizers.php";
    try {
        $connection = new mysqli($host, $db_user, $db_password, $db_name);
        if ($connection->errno != 0) {
            throw new Exception(mysqli_connect_errno());
        }
        $bookId = sanitizeInput($_POST['add-book-to-favorites'], $connection);
        $userId = $_SESSION['id'];
        $query = "INSERT INTO `favorite_books` VALUES(NULL, '$userId', '$bookId')";
        $_SESSION['add-to-favorites-result'] = $connection->query($query);
        $connection->close();
        unset($_POST['add-book-to-favorites']);
        header('Location: ../index.php');
    } catch (Exception $e) {
        echo "Server error. Database is down. Sorry for inconvenience. <br/>";
        echo "Information for developers: ".$e;
    }

?>