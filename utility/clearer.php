<?php 
    function clearGets() {
        unset($_SESSION['initiate-view']);
        unset($_GET['change-description']);
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
        unset($_GET['review']);
        unset($_GET['review-book']);
        unset($_GET['get-review-details']);
        unset($_GET['reviews']);
        unset($_GET['edit-review-details']);
        unset($_GET['add-book-to-favorites']);
        unset($_GET['get-favorite-books']);
        unset($_GET['get-book-reviews']);
    }


?>