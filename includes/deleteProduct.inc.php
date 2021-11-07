<?php
session_start();

if (isset($_POST["submit"])) {


    $productID = $_SESSION["productID"];
    $email = $_SESSION["userEmail"];
    


    require_once 'databaseHandler.inc.php';
    require_once 'functions.inc.php';

    deleteProduct($conn,$productID,$email);
    
} else {
    header("location: ../user_profile.php");
    exit();
}
