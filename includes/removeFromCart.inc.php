<?php
session_start();

    $productID = $_GET["productID"]; 

    $userEmail = $_SESSION["userEmail"];
  

    require_once 'databaseHandler.inc.php';
    require_once 'functions.inc.php';

   

    removeFromCart($conn, $productID, $userEmail);