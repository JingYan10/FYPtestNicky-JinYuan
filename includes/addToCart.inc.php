<?php
session_start();

    $productName = $_GET["productName"]; 
    $productImage = $_GET["productImage"]; 
    $productPrice = $_GET["productPrice"]; 
    $productQuantity = $_GET["productQuantity"];

    require_once 'databaseHandler.inc.php';
    require_once 'functions.inc.php';

    addToCart($conn, $cartID, $productName, $productimage, $productPrice, $productQuantity);