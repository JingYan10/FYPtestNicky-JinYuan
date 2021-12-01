<?php
session_start();

    $email = $_SESSION["userEmail"];
    $friendCode = $_POST["name"];


    require_once 'databaseHandler.inc.php';
    require_once 'functions.inc.php';

    echo json_encode(searchFriendByFriendCode($conn, $friendCode));
    