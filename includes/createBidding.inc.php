<?php
session_start();
if(isset($_POST["submit"])){


    $productID = $_SESSION['productID'];
    $biddingEndingTime = $_POST['biddingEndingTime'];
    $biddingStartingPrice = $_POST["biddingStartingPrice"];
    $biddingEndingPrice = $biddingStartingPrice;
    $totalBidder = 0;


    require_once 'databaseHandler.inc.php';
    require_once 'functions.inc.php';


    if(invalidProductPrice($biddingStartingPrice)){
        header("location: ../createBidding.php?error=invalidBiddingStartingPrice");
        exit();
    }
    


    createBidding($conn,$productID,$biddingEndingTime,$biddingStartingPrice,$biddingEndingPrice,$totalBidder);

                
             
        
       

    
        

    

}
else{
    header("location: ../signUp.php");
    exit();
}