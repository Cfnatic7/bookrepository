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
        if ($connection->errno != 0) {
            throw new Exception(mysqli_connect_errno());
        }
        $bookId = sanitizeInput($_POST['remove-from-favorites'], $connection);
        $userId = $_SESSION['id'];
        $query = "DELETE FROM `favorite_books` WHERE book_id = '$bookId' AND user_id = '$userId'";
        $_SESSION['remove-from-favorites-result'] = $connection->query($query);
        $connection->close();
        unset($_POST['remove-from-favorites']);
        header('Location: ../index.php');
    } catch (Exception $e) {
        echo "Server error. Database is down. Sorry for inconvenience. <br/>";
        echo "Information for developers: ".$e."<br/>";
        echo $bookId."book <br/>";
        echo $userId."user <br/>";
    }

?>