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

        <form method='GET' action='search-books.php' id='search-books'> 
            <input type = 'text' placeholder='search books'> 

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
                <input type='hidden' name='description' value='change'> </input>
            </form >
            <hr class='user-hr'>
            <form method='GET' action='user.php'> 
                <button type='submit' class='display-books-button'>Your books</button>
                <input type='hidden' name='books' value='get'> </input>
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
    </main>
    
</body>
</html>