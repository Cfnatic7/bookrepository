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
        if ($connection->errno != 0) {
            throw new Exception(mysqli_connect_errno());
        }
        $bookTitle = sanitizeInput($_POST['book-title'], $connection);
        $bookPages = sanitizeInput($_POST['book-pages'], $connection);
        $dateOfRelease = sanitizeInput($_POST['date-of-release'], $connection);
        $description = sanitizeInput($_POST['description'], $connection);
        $genres = '';

        foreach($_POST['genres'] as $genre) {
            $genre = sanitizeInput($genre, $connection);
            $genres .= $genre.", ";
        }
        $genres = rtrim($genres, ", ");
        $query = "INSERT INTO `books` VALUES(NULL, '$bookTitle', '$bookPages', '$dateOfRelease', '$genres', '$description')";
        $_SESSION['book-add-result'] = $connection->query($query);
        if ($_SESSION['book-add-result'] == false) {
            $connection->close();
            exit();
        }
        $insertedBookId = $connection->insert_id;
        echo $insertedBookId."</br>";
        foreach($_POST['authors'] as $author) {
            $author = sanitizeInput($author, $connection);
            $_SESSION['book-add-result'] = $connection->query("INSERT INTO `books_and_authors` VALUES(NULL, '$author', '$insertedBookId')");
            if ($_SESSION['book-add-result'] == false) {
                $connection->close();
                exit();
            }
        }
        $connection->close();
        unset($_POST['book-title']);
        unset($_POST['book-pages']);
        unset($_POST['genres']);
        unset($_POST['authors']);
        unset($_POST['date-of-release']);
        unset($_POST['description']);
        header('Location: ../index.php');
    } catch (Exception $e) {
        echo "Server error. Database is down. Sorry for inconvenience. <br/>";
        echo "Information for developers: ".$e;
    }

?>