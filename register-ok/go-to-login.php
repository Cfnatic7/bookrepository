<?php
    session_start();
    $_SESSION['goToLogin'] = true;

    header("Location: ../index.php");

?>