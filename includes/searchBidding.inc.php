<?php
session_start();

    $email = $_SESSION["userEmail"];
    $searchData = $_POST["name2"];

    echo "data from input  :   ".$searchData;

    // require_once 'databaseHandler.inc.php';
    // require_once 'functions.inc.php';

    // searchBidding($conn, $searchData);