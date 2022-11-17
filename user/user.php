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
                                <button type='submit' class='display-reviews-button'>books</button>
                                <input type='hidden' name='reviews' value='get'> </input>
                            </form >
                        </div>";
                }
            ?>
        </div>
        <?php 
                if (isset($_GET['users']) && $_GET['users'] == 'get') {
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
                                            <input type='hidden' name='get-details' value=".$row['email']."> </input>
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
                if (isset($_GET['get-details'])) {
                    $saveValue = $_GET['get-details'];
                    clearGets();
                    $_GET['get-details'] = $saveValue;
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
    </main>
    
</body>
</html>