<?php 
    session_start();
    if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] != true) {
        header('Location: ../index.php');
        exit();
    }
    require_once "../connect.php";
    require_once "../utility/sanitizers.php";
    try {
        $connection = new mysqli($host, $db_user, $db_password, $db_name);
        $reviewTitle = sanitizeInput($_POST['review-title'], $connection);
        $bookRating = sanitizeInput($_POST['book-rating'], $connection);
        $review = sanitizeInput($_POST['review'], $connection);
        $bookId = sanitizeInput($_POST['book-id'], $connection);
        $userId = $_SESSION['id'];
        if ($connection->errno != 0) {
            throw new Exception(mysqli_connect_errno());
        }
        $query = "INSERT INTO `reviews` VALUES(NULL, '$userId', '$bookId', '$bookRating', '$reviewTitle', '$review')";
        $connection->query($query);
        $connection->close();
        unset($_POST['review-title']);
        unset($_POST['book-rating']);
        unset($_POST['review']);
        unset($_POST['book-id']);
        $_SESSION['add-review-success'] = true;
        header('Location: ../index.php');
    } catch (Exception $e) {
        echo "Server error. Database is down. Sorry for inconvenience. <br/>";
        echo "Information for developers: ".$e."<br/>";
        echo $_SESSION['id'];
    }

?>