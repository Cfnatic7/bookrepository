<?php 
    session_start();
    if (!isset($_SESSION['loggedIn'])) {
        header('Location: ../index.php');
        exit();
    }
    require_once "../utility/clearer.php";
    require_once "../connect.php";
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href = "../normalize.css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./user.css">
    <script src = './user.js' defer></script>
    <script src="https://kit.fontawesome.com/8eaacae2ec.js" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>
    <header>
        <div>
            <h2 class='header-text'>
                    <?php  echo  "Welcome ".$_SESSION['user']."!"; ?>
            </h2>
        </div>

        <form method='GET' action='user.php' id='search-books'> 
            <input type = 'text' name = 'book-search' placeholder='search books'> 

            </input>
            <button type='submit' id='search-books-button'>
                <i class="fa-solid fa-magnifying-glass">
                </i>
            </button>
        </form>
        <div>
            <button type='button' onclick='logoutOnClick()' class='logout-button'>Logout</button>
        </div>
    </header>
    <main>
        <div class='user-display'>
            <i class="fa-solid fa-user"></i>
            <?php
                echo "<p>".$_SESSION['user']."</p>";
            ?>
            <hr class='user-hr'>
            <?php
                if (strlen($_SESSION['description'] > 0)) {
                    echo "<p>".$_SESSION['description']."</p>";
                }
            ?>
            <form method='GET' action='user.php'> 
                <button type='submit' class='change-description-button'>Change description</button>
                <input type='hidden' name='change-description' value='change'> </input>
            </form >
            <hr class='user-hr'>
            <form method='GET' action='user.php'> 
                <button type='submit' class='display-favorite-books-button'>Your books</button>
                <input type='hidden' name='get-favorite-books' value='get'> </input>
            </form >
            <hr class='user-hr'>
            <form method='GET' action='user.php'> 
                <button type='submit' class='display-reviews-button'>Your reviews</button>
                <input type='hidden' name='reviews' value='get'> </input>
            </form >
            <?php
                if (strlen($_SESSION['role'] == 'admin')) {
                    echo "<hr class='user-hr'>";
                    echo "<div class='admin-options'>
                            <form method='GET' action='user.php'> 
                                <button type='submit' class='display-users-button'>users</button>
                                <input type='hidden' name='users' value='get'> </input>
                            </form >
                            <form method='GET' action='user.php'> 
                                <button type='submit' class='display-authors-button'>authors</button>
                                <input type='hidden' name='authors' value='get'> </input>
                            </form >
                            <form method='GET' action='user.php'> 
                                <button type='submit' class='display-books-button'>books</button>
                                <input type='hidden' name='books' value='get'> </input>
                            </form >
                        </div>";
                }
            ?>
        </div>
        <?php 
                if (isset($_GET['users']) && $_GET['users'] == 'get' && $_SESSION['role'] == 'admin') {
                    clearGets();
                    $_GET['users'] = 'get';
                    try {
                        $connection = new mysqli($host, $db_user, $db_password, $db_name);
                        if ($connection->errno != 0) {
                            throw new Exception(mysqli_connect_errno());
                        }
                        else {
                            $result = $connection->query("SELECT email, `name`, surname, `role` FROM `users`");
                        }

                        echo "<table class='user-table'>
                                <thead>
                                    <tr>
                                        <td class='td-head'>
                                            email
                                        </td>
                                        <td class='td-head'>
                                            name
                                        </td>
                                        <td class='td-head'>
                                            surname
                                        </td>
                                        <td class='td-head'>
                                            role
                                        </td>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody>";

                        for ($x = 0; $x < $result->num_rows; $x++) {
                            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                            echo "<tr>
                                    <td>".$row['email']."</td>
                                    <td>".$row['name']."</td>
                                    <td>".$row['surname']."</td>
                                    <td>".$row['role']."</td>
                                    <td>
                                        <form method='GET' action='user.php'> 
                                            <button type='submit' class='display-details-button'>details</button>
                                            <input type='hidden' name='get-user-details' value=".$row['email']."> </input>
                                        </form >
                                    </td>
                                </tr>";
                        }
                        echo "</tbody>";
                        echo "</table>";
                        $result->close();
                        $connection->close();

                    } catch(Exception $e) {
                        echo "Server error. Database is down. Sorry for inconvenience. <br/>";
                        echo "Information for developers: ".$e;
                    }
                }
            
            ?>

            <?php 
                if (isset($_GET['get-user-details'])  && $_SESSION['role'] == 'admin') {
                    $saveValue = $_GET['get-user-details'];
                    clearGets();
                    $_GET['get-user-details'] = $saveValue;
                    try {
                        $connection = new mysqli($host, $db_user, $db_password, $db_name);
                        if ($connection->errno != 0) {
                            throw new Exception(mysqli_connect_errno());
                        }
                        else {
                            $result = $connection->query("SELECT email, `name`, surname, `role`, description FROM `users` WHERE email like '$saveValue'");
                        }

                        echo "<table class='details-table'>
                                <thead>
                                    <tr>
                                        <td class='td-head'>
                                            email
                                        </td>
                                        <td class='td-head'>
                                            name
                                        </td>
                                        <td class='td-head'>
                                            surname
                                        </td>
                                        <td class='td-head'>
                                            role
                                        </td>
                                        <td style='width:10vw;'>description</td>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody>";
                        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                        echo "<tr>
                                <td>".$row['email']."</td>
                                <td>".$row['name']."</td>
                                <td>".$row['surname']."</td>
                                <td>".$row['role']."</td>
                                <td style='overflow:auto;'>
                                    ".$row['description']."
                                </td>
                                <td>
                                    <form method='GET' action='user.php'> 
                                        <button type='submit' class='remove-user-button'>remove user</button>
                                        <input type='hidden' name='remove-user' value=".$row['email']."> </input>
                                    </form >
                                </td>
                            </tr>";
                        echo "</tbody>";
                        echo "</table>";
                        $result->close();
                        $connection->close();

                    } catch(Exception $e) {
                        echo "Server error. Database is down. Sorry for inconvenience. <br/>";
                        echo "Information for developers: ".$e;
                    }
                }
            ?>

            <?php 
                if (isset($_GET['remove-user']) && $_SESSION['role'] == 'admin') {
                    $email = $_GET['remove-user'];
                    clearGets();
                    try {
                        $connection = new mysqli($host, $db_user, $db_password, $db_name);
                        if ($connection->errno != 0) {
                            throw new Exception(mysqli_connect_errno());
                        }
                        else {
                            $connection->query("DELETE FROM `users` WHERE email like '$email'");
                            if ($result == true) {
                                echo "<p style='font-family:Helvetica, Arial, sans-serif; font-size:1.5rem; text-align:center; margin:auto; position:relative; right:-10%;'>User deleted successfully </p>";
                            }
                        }
                        $connection->close();

                    } catch(Exception $e) {
                        echo "Server error. Database is down. Sorry for inconvenience. <br/>";
                        echo "Information for developers: ".$e;
                    }
                }
            ?>

            <?php 
                if (isset($_GET['authors']) && $_GET['authors'] == 'get' && $_SESSION['role'] == 'admin') {
                    clearGets();
                    $_GET['authors'] = 'get';
                    try {
                        $connection = new mysqli($host, $db_user, $db_password, $db_name);
                        if ($connection->errno != 0) {
                            throw new Exception(mysqli_connect_errno());
                        }
                        else {
                            $result = $connection->query("SELECT id, name, surname, date_of_birth FROM `authors`");
                        }

                        echo "<table class='authors-table'>
                                <thead>
                                    <tr>
                                        <td class='td-head'>
                                            name
                                        </td>
                                        <td class='td-head'>
                                            surname
                                        </td>
                                        <td class='td-head'>
                                            date of birth
                                        </td>
                                        <td>
                                            <form method='GET' action='user.php'> 
                                                <button type='submit' class='add-author-button'>add author</button>
                                                <input type='hidden' name='add-author' value='get'></input>
                                            </form >
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>";

                        for ($x = 0; $x < $result->num_rows; $x++) {
                            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                            echo "<tr>
                                    <td>".$row['name']."</td>
                                    <td>".$row['surname']."</td>
                                    <td>".$row['date_of_birth']."</td>
                                    <td>
                                        <form method='GET' action='user.php'> 
                                            <button type='submit' class='display-author-details-button'>details</button>
                                            <input type='hidden' name='get-author-details' value=".$row['id']."> </input>
                                        </form >
                                    </td>
                                </tr>";
                        }
                        echo "</tbody>";
                        echo "</table>";
                        $result->close();
                        $connection->close();

                    } catch(Exception $e) {
                        echo "Server error. Database is down. Sorry for inconvenience. <br/>";
                        echo "Information for developers: ".$e;
                    }
                }
            ?>

            <?php 
                if (isset($_GET['get-author-details']) && $_SESSION['role'] == 'admin') {
                    $save = $_GET['get-author-details'];
                    clearGets();
                    $_GET['get-author-details'] = $save;
                    try {
                        $connection = new mysqli($host, $db_user, $db_password, $db_name);
                        if ($connection->errno != 0) {
                            throw new Exception(mysqli_connect_errno());
                        }
                        $id = $_GET['get-author-details'];
                        $query = "SELECT id, name, surname, date_of_birth, short_biography FROM `authors`
                        WHERE id = '$id'";
                        $result = $connection->query("SELECT id, name, surname, date_of_birth, short_biography FROM `authors`
                        WHERE id = '$id'");
                        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                        echo "<div class = 'author-details'>
                                <p class='author-details-title'>Name</p>
                                <p>".$row['name']."</p>
                                <p class='author-details-title'>Surname</p>
                                <p>".$row['surname']."</p>
                                <p class='author-details-title'>Date of birth</p>
                                <p>".$row['date_of_birth']."</p>
                                <p class='author-details-title'>Short biography</p>
                                <p>".$row['short_biography']."</p>
                                <form method='GET' action='user.php'> 
                                    <button type='submit' class='edit-author-details-button'>edit</button>
                                    <input type='hidden' name='edit-author-details' value=".$row['id']."> </input>
                                </form >
                            </div>";
                        $result->close();
                        $connection->close();

                    } catch(Exception $e) {
                        echo "Server error. Database is down. Sorry for inconvenience. <br/>";
                        echo "Information for developers: ".$e;
                    }
                }
            ?>

            <?php 
                if (isset($_GET['edit-author-details']) && $_SESSION['role'] == 'admin') {
                    $id = $_GET['edit-author-details'];
                    clearGets();
                    $_GET['edit-author-details'] = $id;
                    try {
                        $connection = new mysqli($host, $db_user, $db_password, $db_name);
                        if ($connection->errno != 0) {
                            throw new Exception(mysqli_connect_errno());
                        }
                        $query = "SELECT id, name, surname, date_of_birth, short_biography FROM `authors`
                        WHERE id = '$id'";
                        $result = $connection->query("SELECT id, name, surname, date_of_birth, short_biography FROM `authors`
                        WHERE id = '$id'");
                        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                        echo "<form class='edit-author-form' method='POST' action='edit-author.php'>
                                <div>
                                    <label for='author-name'>Name</label>
                                    <input type='text' id='author-name' name='author-name' value = ".$row['name']."></input>
                                </div>
                                <div>
                                    <label for='author-surname'>Surname</label>
                                    <input type='text' id='author-surname' name='author-surname' value = ".$row['surname']."></input>
                                </div>
                                <div>
                                    <label for='short-biography'>Short biography</label>
                                    <textarea type='text' id='short-biography' name='short-biography'>".$row['short_biography']."</textarea>
                                </div>
                                <div>
                                    <label for='author-birth-date'>Birth date</label>
                                    <input type='date' id='author-birth-date' name='author-birth-date' value = ".$row['date_of_birth']."></input>
                                </div>
                                    <button type='submit'>edit author</button>
                                    <input type='hidden' name='author-id' value = ".$row['id']."></input>
                                </form>";

                        

                        $result->close();
                        $connection->close();
                    } catch (Exception $e) {
                        echo "Server error. Database is down. Sorry for inconvenience. <br/>";
                        echo "Information for developers: ".$e;
                    }

                }
            ?>

            <?php 
                if (isset($_SESSION['author-edit-result']) && $_SESSION['author-edit-result'] == true) {
                    echo "<h3 style='margin-top: 10rem; font-family: Helvetica, Arial, sans-serif; position: relative; right: 20rem;'>Author edited successfully</h3>";
                }
                else if (isset($_SESSION['author-edit-result']) && $_SESSION['author-edit-result'] == false) {
                    echo "<h3 style='margin-top: 10rem; font-family: Helvetica, Arial, sans-serif; position: relative; right: 20rem;'>Couldn't edit author</h3>";
                }
                unset($_SESSION['author-edit-result']);
            ?>

            <?php 
                if (isset($_GET['add-author']) && $_GET['add-author'] == 'get' && $_SESSION['role'] == 'admin') {
                    clearGets();
                    $_GET['add-author'] = 'get';
                    echo "<form class='add-author-form' method='POST' action='add-author.php'>
                            <div>
                                <label for='author-name'>Name</label>
                                <input type='text' id='author-name' name='author-name'></input>
                            </div>
                            <div>
                                <label for='author-surname'>Surname</label>
                                <input type='text' id='author-surname' name='author-surname'></input>
                            </div>
                            <div>
                                <label for='short-biography'>Short biography</label>
                                <textarea type='text' id='short-biography' name='short-biography'></textarea>
                            </div>
                            <div>
                                <label for='author-birth-date'>Birth date</label>
                                <input type='date' id='author-birth-date' name='author-birth-date'></input>
                            </div>
                                <button type='submit'>add author</button>
                        </form>";
                }
            ?>

            <?php 
                if (isset($_SESSION['author-add-result']) && $_SESSION['author-add-result'] == true) {
                    echo "<h3 style='margin-top: 10rem; font-family: Helvetica, Arial, sans-serif; position: relative; right: 20rem;'>Author added successfully</h3>";
                }
                else if (isset($_SESSION['author-add-result']) && $_SESSION['author-add-result'] == false) {
                    echo "<h3 style='margin-top: 10rem; font-family: Helvetica, Arial, sans-serif; position: relative; right: 20rem;'>Couldn't add author</h3>";
                }
                unset($_SESSION['author-add-result']);
            ?>

            <?php 
                if (isset($_GET['books']) && $_GET['books'] == 'get' && $_SESSION['role'] == 'admin') {
                    clearGets();
                    $_GET['books'] = 'get';
                    try {
                        $connection = new mysqli($host, $db_user, $db_password, $db_name);
                        if ($connection->errno != 0) {
                            throw new Exception(mysqli_connect_errno());
                        }
                        else {
                            $result = $connection->query("SELECT id, title, pages, date_of_release, genres
                            FROM `books`");
                        }

                        echo "<table class='books-table'>
                                <thead>
                                    <tr>
                                        <td class='td-head'>
                                            Title
                                        </td>
                                        <td class='td-head'>
                                            Number of pages
                                        </td>
                                        <td class='td-head'>
                                            date of release
                                        </td>
                                        <td class='td-head'>
                                            genres
                                        </td>
                                        <td>
                                            <form method='GET' action='user.php'> 
                                                <button type='submit' class='add-book-button'>add book</button>
                                                <input type='hidden' name='add-book' value='get'></input>
                                            </form >
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>";

                        for ($x = 0; $x < $result->num_rows; $x++) {
                            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                            echo "<tr>
                                    <td>".$row['title']."</td>
                                    <td>".$row['pages']."</td>
                                    <td>".$row['date_of_release']."</td>
                                    <td>".$row['genres']."</td>
                                    <td>
                                        <form method='GET' action='user.php'> 
                                            <button type='submit' class='display-book-details-button'>details</button>
                                            <input type='hidden' name='get-book-details' value=".$row['id']."> </input>
                                        </form >
                                    </td>
                                </tr>";
                        }
                        echo "</tbody>";
                        echo "</table>";
                        $result->close();
                        $connection->close();

                    } catch(Exception $e) {
                        echo "Server error. Database is down. Sorry for inconvenience. <br/>";
                        echo "Information for developers: ".$e;
                    }
                }
            ?>

            <?php 
                if (isset($_GET['add-book']) && $_GET['add-book'] == 'get' && $_SESSION['role'] == 'admin') {
                    clearGets();
                    $_GET['add-book'] = 'get';
                    try {
                        $connection = new mysqli($host, $db_user, $db_password, $db_name);
                        if ($connection->errno != 0) {
                            throw new Exception(mysqli_connect_errno());
                        }
                        $result = $connection->query("SELECT id, surname FROM `authors`");
                        echo "<form class='add-book-form' method='POST' action='add-book.php'>
                                <div>
                                    <label for='book-title'>Title</label>
                                    <input type='text' id='book-title' name='book-title'></input>
                                </div>
                                <div>
                                    <label for='book-pages'>Pages</label>
                                    <input type='number' min='1' max='1000000' id='book-pages' name='book-pages'></input>
                                </div>
                                <div>
                                    <label for='date-of-release'>Date of release</label>
                                    <input type='date' id='date-of-release' name='date-of-release'></input>
                                </div>
                                <div>
                                    <label for='genres'>Genres</label>
                                    <select name='genres[]' id='genres' multiple>
                                        <option value='fantasy'>fantasy</option>
                                        <option value='sci-fi'>sci-fi</option>
                                        <option value='thriller'>thriller</option>
                                        <option value='romance'>romance</option>
                                        <option value='horror'>horror</option>
                                        <option value='contemporary'>contemporary</option>
                                        <option value='dystopian'>dystopian</option>
                                        <option value='historical'>historical</option>
                                        <option value='development'>development</option>
                                        <option value='motivation'>motivation</option>
                                        <option value='art'>art</option>
                                        <option value='cookbook'>cookbook</option>
                                    </select>
                                </div>
                                <div>
                                    <label for='authors'>Authors</label>
                                    <select name = 'authors[]' id = 'authors' multiple>";
                                    for ($i = 0; $i < $result->num_rows; $i++) {
                                        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                                        echo "<option value=".$row['id'].">".$row['surname']."</option>";
                                    }

                            echo "</select>
                                </div>
                                <div>
                                    <label for='description'>Description</label>
                                    <textarea type='text' name='description' id = 'description'></textarea>
                                </div>
                                    <button type='submit'>add book</button>
                            </form>";
                        $connection->close();
                        $result->close();
                    } catch(Exception $e) {
                        echo "Server error. Database is down. Sorry for inconvenience. <br/>";
                        echo "Information for developers: ".$e;
                    }
                }
            ?>

            <?php 
                if (isset($_SESSION['book-add-result']) && $_SESSION['book-add-result'] == true) {
                    echo "<h3 style='margin-top: 10rem; font-family: Helvetica, Arial, sans-serif; position: relative; right: 20rem;'>Book added successfully</h3>";
                }
                else if (isset($_SESSION['book-add-result']) && $_SESSION['book-add-result'] == false) {
                    echo "<h3 style='margin-top: 10rem; font-family: Helvetica, Arial, sans-serif; position: relative; right: 20rem;'>Couldn't add book</h3>";
                }
                unset($_SESSION['book-add-result']);
            ?>

            <?php 
                if (isset($_GET['book-search'])) {
                    $saveBookSearch = $_GET['book-search'];
                    clearGets();
                    $_GET['book-search'] = $saveBookSearch;
                    try {
                        $connection = new mysqli($host, $db_user, $db_password, $db_name);
                        if ($connection->errno != 0) {
                            throw new Exception(mysqli_connect_errno());
                        }
                        else {
                            $result = $connection->query("SELECT id, title, pages, date_of_release, genres
                            FROM `books` WHERE title LIKE '%".$saveBookSearch."%'");
                        }

                        echo "<table class='books-table'>
                                <thead>
                                    <tr>
                                        <td class='td-head'>
                                            Title
                                        </td>
                                        <td class='td-head'>
                                            Number of pages
                                        </td>
                                        <td class='td-head'>
                                            date of release
                                        </td>
                                        <td class='td-head'>
                                            genres
                                        </td>
                                        <td>
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>";

                        for ($x = 0; $x < $result->num_rows; $x++) {
                            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                            echo "<tr>
                                    <td>".$row['title']."</td>
                                    <td>".$row['pages']."</td>
                                    <td>".$row['date_of_release']."</td>
                                    <td>".$row['genres']."</td>
                                    <td>
                                        <form method='GET' action='user.php'> 
                                            <button type='submit' class='display-book-details-button'>details</button>
                                            <input type='hidden' name='get-book-details' value=".$row['id']."> </input>
                                        </form >
                                    </td>
                                </tr>";
                        }
                        echo "</tbody>";
                        echo "</table>";
                        $result->close();
                        $connection->close();

                    } catch(Exception $e) {
                        echo "Server error. Database is down. Sorry for inconvenience. <br/>";
                        echo "Information for developers: ".$e;
                    }
                }
            ?>

            <?php 
                if (isset($_GET['get-book-details'])) {
                    $save = $_GET['get-book-details'];
                    clearGets();
                    $_GET['get-book-details'] = $save;
                    try {
                        $connection = new mysqli($host, $db_user, $db_password, $db_name);
                        if ($connection->errno != 0) {
                            throw new Exception(mysqli_connect_errno());
                        }
                        $id = $_GET['get-book-details'];
                        $query = "SELECT id, title, pages, date_of_release, genres, description FROM `books`
                        WHERE id = '$id'";
                        $result = $connection->query($query);
                        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                        echo "<div class = 'book-details'>
                                <p class='book-details-title'>Title</p>
                                <p>".$row['title']."</p>
                                <p class='book-details-pages'>Pages</p>
                                <p>".$row['pages']."</p>
                                <p class='book-details-date_of_release'>Date of release</p>
                                <p>".$row['date_of_release']."</p>
                                <p class='book-details-genres'>Genres</p>
                                <p>".$row['genres']."</p>
                                <p class='book-details-description'>Description</p>
                                <p>".$row['description']."</p>
                                <div class = 'book-details-buttons'>
                                    <form method='GET' action='user.php'> 
                                        <button type='submit' class='review-book-button'>Write a review</button>
                                        <input type='hidden' name='review-book' value=".$row['id']."> </input>
                                    </form >
                                    <form method='POST' action='add-to-favorites.php'> 
                                        <button type='submit' class='add-book-to-favorites-button'>Add to favorites</button>
                                        <input type='hidden' name='add-book-to-favorites' value=".$row['id']."> </input>
                                    </form >
                                </div>

                            </div>";
                        $result->close();
                        $connection->close();

                    } catch(Exception $e) {
                        echo "Server error. Database is down. Sorry for inconvenience. <br/>";
                        echo "Information for developers: ".$e;
                    }
                }
            ?>

            <?php 
                if (isset($_SESSION['add-to-favorites-result']) && $_SESSION['add-to-favorites-result'] == true) {
                    echo "<h3 style='margin-top: 10rem; font-family: Helvetica, Arial, sans-serif; position: relative; right: 20rem;'>Book added to favorites</h3>";
                }
                else if (isset($_SESSION['add-to-favorites-result']) && $_SESSION['add-to-favorites-result'] == false) {
                    echo "<h3 style='margin-top: 10rem; font-family: Helvetica, Arial, sans-serif; position: relative; right: 20rem;'>Couldn't add book to favorites</h3>";
                }
                unset($_SESSION['add-to-favorites-result']);
            ?>

            <?php 
                if (isset($_GET['review-book'])) {
                    echo $_SESSION['id'];
                    $saveId = $_GET['review-book'];
                    clearGets();
                    $_GET['review-book'] = $saveId;
                    echo "<form class='review-book-form' method='POST' action='review-book.php'>
                            <div>
                                <label for='review-title'>Title</label>
                                <input type='text' id='review-title' name='review-title'
                                minlength='1' maxlength='255'></input>
                            </div>
                            <div>
                                <label for='book-rating'>Rating</label>
                                <input type='number' min='1' max='10' step='0.1' id='book-rating' name='book-rating'></input>
                            </div>
                            <div>
                                <label for='review'>Review</label>
                                <textarea id='review' name='review'></textarea>
                            </div>
                            <input type='hidden' name='book-id' value = ".$saveId."> </input>
                                <button type='submit'>post review</button>
                        </form>";
                    echo $_SESSION['id'];
                }
            ?>

            <?php 
                if (isset($_SESSION['add-review-success']) && $_SESSION['add-review-success'] == true) {
                    echo "<h3 style='margin-top: 10rem; font-family: Helvetica, Arial, sans-serif; position: relative; right: 20rem;'>Review added successfully</h3>";
                }
                else if (isset($_SESSION['add-review-success']) && $_SESSION['add-review-success'] == false) {
                    echo "<h3 style='margin-top: 10rem; font-family: Helvetica, Arial, sans-serif; position: relative; right: 20rem;'>Couldn't add Review</h3>";
                }
                unset($_SESSION['add-review-success']);
            ?>

            <?php 
                if (isset($_GET['reviews'])) {
                    $reviews = $_GET['reviews'];
                    clearGets();
                    $_GET['reviews'] = $reviews;
                    try {
                        $connection = new mysqli($host, $db_user, $db_password, $db_name);
                        if ($connection->errno != 0) {
                            throw new Exception(mysqli_connect_errno());
                        }
                        $result = $connection->query("SELECT `reviews`.id, user_id, book_id, rating, `reviews`.title as review_title, 
                        `books`.title as book_title FROM `reviews` JOIN `books` ON `books`.id = `reviews`.book_id
                        WHERE user_id LIKE ".$_SESSION['id']."");

                        echo "<table class='reviews-table'>
                                <thead>
                                    <tr>
                                        <td class='td-head'>
                                            Title
                                        </td>
                                        <td class='td-head'>
                                            Rating
                                        </td>
                                        <td class='td-head'>
                                            Book title
                                        </td>
                                        <td class='td-head'>
                                        </td>
                                        <td>
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>";

                        for ($x = 0; $x < $result->num_rows; $x++) {
                            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                            echo "<tr>
                                    <td>".$row['review_title']."</td>
                                    <td>".$row['rating']."</td>
                                    <td>".$row['book_title']."</td>
                                    <td>
                                        <form method='GET' action='user.php'> 
                                            <button type='submit' class='display-review-details-button'>details</button>
                                            <input type='hidden' name='get-review-details' value=".$row['id']."> </input>
                                        </form >
                                    </td>
                                </tr>";
                        }
                        echo "</tbody>";
                        echo "</table>";
                        $result->close();
                        $connection->close();

                    } catch(Exception $e) {
                        echo "Server error. Database is down. Sorry for inconvenience. <br/>";
                        echo "Information for developers: ".$e;
                    }
                }
            ?>

            <?php 
                if (isset($_GET['get-review-details'])) {
                    $id = $_GET['get-review-details'];
                    clearGets();
                    $_GET['get-review-details'] = $id;
                    try {
                        $connection = new mysqli($host, $db_user, $db_password, $db_name);
                        if ($connection->errno != 0) {
                            throw new Exception(mysqli_connect_errno());
                        }
                        $id = $_GET['get-review-details'];
                        $result = $connection->query("SELECT `reviews`.id as id, rating, `reviews`.title as review_title, 
                        `books`.title as book_title, review FROM `reviews` JOIN `books` ON `books`.id = `reviews`.book_id
                        WHERE `reviews`.id LIKE ".$id."");
                        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                        echo "<div class = 'review-details'>
                                <p class='review-details-title'>Book</p>
                                <p>".$row['book_title']."</p>
                                <p class='review-details-title'>Title</p>
                                <p>".$row['review_title']."</p>
                                <p class='review-details-title'>Rating</p>
                                <p>".$row['rating']."</p>
                                <p class='review-details-title'>Review</p>
                                <p>".$row['review']."</p>
                                <form method='GET' action='user.php'> 
                                    <button type='submit' class='edit-review-details-button'>edit review</button>
                                    <input type='hidden' name='edit-review-details' value=".$row['id']."> </input>
                                </form >
                            </div>";
                        $result->close();
                        $connection->close();

                    } catch(Exception $e) {
                        echo "Server error. Database is down. Sorry for inconvenience. <br/>";
                        echo "Information for developers: ".$e;
                    }
                }
            ?>

            <?php 
                if (isset($_GET['edit-review-details']) && $_SESSION['role'] == 'admin') {
                    $id = $_GET['edit-review-details'];
                    clearGets();
                    $_GET['edit-review-details'] = $id;
                    try {
                        $connection = new mysqli($host, $db_user, $db_password, $db_name);
                        if ($connection->errno != 0) {
                            throw new Exception(mysqli_connect_errno());
                        }
                        $result = $connection->query("SELECT rating, title, review FROM `reviews`
                        WHERE id LIKE ".$id."");
                        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                        echo "<form class='edit-review-form' method='POST' action='edit-review.php'>
                                <div>
                                    <label for='review-title'>Title</label>
                                    <input type='text' id='review-title' name='review-title' value = ".$row['title']."></input>
                                </div>
                                <div>
                                    <label for='review-rating'>Rating</label>
                                    <input type='number' step='0.1' min = '1' max = '10' id='review-rating' name='review-rating' value = ".$row['rating']."></input>
                                </div>
                                <div>
                                    <label for='review'>Review</label>
                                    <textarea type='text' id='review' name='review'>".$row['review']."</textarea>
                                </div>
                                    <button type='submit'>edit review</button>
                                    <input type='hidden' name='review-id' value = ".$id."></input>
                                </form>";

                        

                        $result->close();
                        $connection->close();
                    } catch (Exception $e) {
                        echo "Server error. Database is down. Sorry for inconvenience. <br/>";
                        echo "Information for developers: ".$e;
                    }

                }
            ?>

            <?php 
                if (isset($_SESSION['review-edit-result']) && $_SESSION['review-edit-result'] == true) {
                    echo "<h3 style='margin-top: 10rem; font-family: Helvetica, Arial, sans-serif; position: relative; right: 20rem;'>Review edited successfully</h3>";
                }
                else if (isset($_SESSION['review-edit-result']) && $_SESSION['review-edit-result'] == false) {
                    echo "<h3 style='margin-top: 10rem; font-family: Helvetica, Arial, sans-serif; position: relative; right: 20rem;'>Couldn't edit review</h3>";
                }
                unset($_SESSION['review-edit-result']);
            ?>

            <?php 
                if (isset($_GET['change-description']) && $_GET['change-description'] == 'change') {
                    clearGets();
                    $_GET['change-description'] = 'change';
                    try {
                        $connection = new mysqli($host, $db_user, $db_password, $db_name);
                        if ($connection->errno != 0) {
                            throw new Exception(mysqli_connect_errno());
                        }
                        $query = "SELECT description FROM `users` WHERE id = ".$_SESSION['id']."";
                        $result = $connection->query($query);
                        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                        echo "<form class='edit-description-form' method='POST' action='edit-description.php'>
                                <div>
                                    <label for='new-description'>New description</label>
                                    <textarea type='text' id='new-description' name='new-description'>".$row['description']."</textarea>
                                </div>
                                    <button type='submit'>edit description</button>
                                </form>";
                        $result->close();
                        $connection->close();
                    } catch (Exception $e) {
                        echo "Server error. Database is down. Sorry for inconvenience. <br/>";
                        echo "Information for developers: ".$e;
                    }

                }
            ?>

            <?php 
                if (isset($_SESSION['description-edit-result']) && $_SESSION['description-edit-result'] == true) {
                    echo "<h3 style='margin-top: 10rem; font-family: Helvetica, Arial, sans-serif; position: relative; right: 20rem;'>Description edited successfully</h3>";
                }
                else if (isset($_SESSION['description-edit-result']) && $_SESSION['description-edit-result'] == false) {
                    echo "<h3 style='margin-top: 10rem; font-family: Helvetica, Arial, sans-serif; position: relative; right: 20rem;'>Couldn't edit description</h3>";
                }
                unset($_SESSION['description-edit-result']);
            ?>

            <?php 
                if (isset($_GET['get-favorite-books']) && $_GET['get-favorite-books'] == 'get') {
                    clearGets();
                    $_GET['get-favorite-books'] = 'get';
                    try {
                        $connection = new mysqli($host, $db_user, $db_password, $db_name);
                        if ($connection->errno != 0) {
                            throw new Exception(mysqli_connect_errno());
                        }
                        else {
                            $result = $connection->query("SELECT `favorite_books`.book_id as book_id, `books`.title as title, 
                            `books`.pages as pages, `books`.date_of_release as date_of_release, `books`.genres as genres, `favorite_books`.user_id as user_id
                            FROM `favorite_books` JOIN `books` ON `favorite_books`.book_id = `books`.id 
                            WHERE user_id = ".$_SESSION['id']."");
                        }

                        echo "<table class='books-table'>
                                <thead>
                                    <tr>
                                        <td class='td-head'>
                                            Title
                                        </td>
                                        <td class='td-head'>
                                            Number of pages
                                        </td>
                                        <td class='td-head'>
                                            Date of release
                                        </td>
                                        <td class='td-head'>
                                            genres
                                        </td>
                                        <td>
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>";

                        for ($x = 0; $x < $result->num_rows; $x++) {
                            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                            echo "<tr>
                                    <td>".$row['title']."</td>
                                    <td>".$row['pages']."</td>
                                    <td>".$row['date_of_release']."</td>
                                    <td>".$row['genres']."</td>
                                    <td>
                                        <form method='GET' action='user.php'> 
                                            <button type='submit' class='display-book-details-button'>details</button>
                                            <input type='hidden' name='get-book-details' value=".$row['book_id']."> </input>
                                        </form >
                                    </td>
                                </tr>";
                        }
                        echo "</tbody>";
                        echo "</table>";
                        $result->close();
                        $connection->close();

                    } catch(Exception $e) {
                        echo "Server error. Database is down. Sorry for inconvenience. <br/>";
                        echo "Information for developers: ".$e;
                    }
                }
            ?>

    </main>
    
</body>
</html>