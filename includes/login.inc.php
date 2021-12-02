<?php

if(isset($_POST["submit"])){

    $email = $_POST["email"];
    $password = $_POST["password"];

    require_once 'databaseHandler.inc.php';
    require_once 'functions.inc.php';
    

    if(emptyInputLogin($email,$password) != false){
        header("location: ../login.php?error=emptyInput");
        exit();
    }
    updateBiddingWinner($conn);
    getAllWishlistData($conn,$conn2,$email);
    loginUser($conn,$email,$password);
    
}
else{
    header("location: ../login.php?error=emptyInput");
    exit();
}