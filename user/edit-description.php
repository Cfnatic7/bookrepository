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
        $description = sanitizeInput($_POST['new-description'], $connection);
        $id = $_SESSION['id'];
        $query = "UPDATE `users` SET description = '$description' WHERE id = '$id'";
        $_SESSION['description-edit-result'] = $connection->query($query);
        $connection->close();
        $_SESSION['description'] = $description;
        unset($_POST['new-description']);
        header('Location: ../index.php');
    } catch (Exception $e) {
        echo "Server error. Database is down. Sorry for inconvenience. <br/>";
        echo "Information for developers: ".$e;
    }

?>