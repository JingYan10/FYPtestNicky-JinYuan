<?php
session_start();

if(isset($_POST["submit"])){
    
    $biddingPrice = $_POST["biddingPrice"];
    $biddingID = $_POST["biddingID"];
    $email = $_SESSION["userEmail"];
    $biddingEndingTime = $_POST["biddingEndingTime"];
    $biddingEndingPrice = $_POST["biddingEndingPrice"];
    $totalBidder = $_POST["totalBidder"];

    $newTotalBidder = (int) $totalBidder + 1;

    date_default_timezone_set("Asia/Kuala_Lumpur");
    $currentTime = date("d/m/y h:i:s");
    $timeBiddingEndingTime = strtotime($biddingEndingTime);
    $dateBiddingEndingTime = date('d/m/y h:i:s',$timeBiddingEndingTime);


    // echo "bidding price = ".$biddingPrice."<br>";
    // echo "bidding ID = ".$biddingID."<br>";
    // echo $biddingEndingTime."<br>";
    // echo $currentTime."<br>";
    // echo $dateBiddingEndingTime;
    // echo "totalBidder : ".$totalBidder;

    require_once 'databaseHandler.inc.php';
    require_once 'functions.inc.php';

 
    
    

    if (invalidProductPrice($biddingPrice)) {
        header("location: ../biddingDetail.php?error=invalidBiddingPrice");
        exit();
    }
    if($currentTime > $dateBiddingEndingTime){
        header("location: ../biddingDetail.php?error=invalidBiddingTime");
        exit();
    }
    if($biddingPrice<=$biddingEndingPrice){
        header("location: ../biddingDetail.php?error=higherBiddingPrice");
        exit();
    }
    
    

    createBiddingParticipant($conn,$biddingID,$biddingPrice,$email,$totalBidder,$currentTime);
    updateBidding($conn,$biddingPrice,$totalBidder,$biddingID);
    deductCoin($conn,$biddingPrice,$email,$biddingID);

}
else{
    header("location: ../biddingDetail.php");
    exit();
}