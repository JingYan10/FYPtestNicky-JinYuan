<?php
session_start();

    $productID = $_GET["productID"]; 
    $productQuantity = $_GET["productQuantity"];
    $userEmail = $_SESSION["userEmail"];

    require_once 'databaseHandler.inc.php';
    require_once 'functions.inc.php';


    if(isset($_GET["wishlist"])){
        print_r(isProductIDExistCart($conn,$productID));
        if(isProductIDExistCart($conn,$productID)==true){
            echo "true";
            removeFromWishlist($conn,$userEmail,$productID);
        }else{
            echo "false";
            addToCart($conn, $productID, $productQuantity, $userEmail);
            removeFromWishlist($conn,$userEmail,$productID);
        }
        
    }
    addToCart($conn, $productID, $productQuantity, $userEmail);