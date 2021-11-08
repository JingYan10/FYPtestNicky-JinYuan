<?php
session_start();

    $productID = $_GET["productID"]; 
    $productQuantity = $_GET["productQuantity"];
    $userEmail = $_SESSION["userEmail"];

    require_once 'databaseHandler.inc.php';
    require_once 'functions.inc.php';

    addToCart($conn, $productID, $productQuantity, $userEmail);