<?php
session_start();

    $productID = $_POST["productID"];
    $email = $_SESSION["userEmail"];
   


    require_once 'databaseHandler.inc.php';
    require_once 'functions.inc.php';

    deleteProduct($conn,$productID,$email);
    
