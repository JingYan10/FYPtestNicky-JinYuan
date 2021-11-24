<?php
session_start();
    // print_r($_POST);
    // die();

    $email = $_SESSION["userEmail"];
    $productID = $_POST['productID'];
    $productQuantity = $_POST['qty'];
    

    require_once 'databaseHandler.inc.php';
    require_once 'functions.inc.php';

    updateProduct($conn, $email, $productID, $productQuantity);

    