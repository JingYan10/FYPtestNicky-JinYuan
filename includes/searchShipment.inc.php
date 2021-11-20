<?php
session_start();

    $email = $_SESSION["userEmail"];
    $searchData = $_POST["name2"];


    require_once 'databaseHandler.inc.php';
    require_once 'functions.inc.php';

    searchShipment($conn, $email, $searchData);