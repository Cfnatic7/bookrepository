<?php 
    function clearGets() {
        unset($_GET['description']);
        unset($_GET['books']);
        unset($_GET['reviews']);
        unset($_GET['users']);
        unset($_GET['reviews']);
        unset($_GET['get-user-details']);
        unset($_GET['remove-user']);
        unset($_GET['add-author']);
        unset($_GET['get-author-details']);
        unset($_GET['edit-author-details']);
        unset($_GET['add-book']);
        unset($_GET['get-book-details']);
        unset($_GET['book-search']);
    }


?>