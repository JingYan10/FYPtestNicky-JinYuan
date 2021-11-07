<?php
session_start();

    $email = $_SESSION["userEmail"];
    $searchData = $_POST["name"];


    require_once 'databaseHandler.inc.php';
    require_once 'functions.inc.php';

    searchProduct($conn, $email,$searchData);