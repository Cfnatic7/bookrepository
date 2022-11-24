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
        $reviewTitle = sanitizeInput($_POST['review-title'], $connection);
        $reviewRating = sanitizeInput($_POST['review-rating'], $connection);
        $review = sanitizeInput($_POST['review'], $connection);
        $reviewId = sanitizeInput($_POST['review-id'], $connection);
        $query = "UPDATE `reviews` SET title = '$reviewTitle', review = '$review', 
        rating = '$reviewRating' WHERE id = '$reviewId'";
        $_SESSION['review-edit-result'] = $connection->query($query);
        $connection->close();
        unset($_POST['review-title']);
        unset($_POST['review-rating']);
        unset($_POST['review']);
        unset($_POST['review-id']);
        header('Location: ../index.php');
    } catch (Exception $e) {
        echo "Server error. Database is down. Sorry for inconvenience. <br/>";
        echo "Information for developers: ".$e;
    }

?>