<?php 
    function sanitizeInput($input, $connection) {
        return mysqli_real_escape_string($connection, htmlentities($input, ENT_QUOTES, 'UTF-8'));
    }

?>