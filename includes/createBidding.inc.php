<?php
session_start();
if (isset($_POST["submit"])) {


    $productID = $_SESSION['productID'];
    $biddingEndingTime = $_POST['biddingEndingTime'];
    $biddingStartingPrice = $_POST["biddingStartingPrice"];
    $biddingEndingPrice = $biddingStartingPrice;
    $totalBidder = 0;


    require_once 'databaseHandler.inc.php';
    require_once 'functions.inc.php';


    if (invalidProductPrice($biddingStartingPrice)) {
        header("location: ../createBidding.php?error=invalidBiddingStartingPrice");
        exit();
    }


    $sql = "SELECT * FROM product where productID='$productID'";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $_SESSION["productQuantity"] = $row['productQuantity'];           
        }
    } 
    $productQuantity = $_SESSION["productQuantity"];

    // deduct product quantity by one for bidding
    decreaseProductQuantityForBidding($conn,$productID,$productQuantity);

    createBidding($conn,$productID,$biddingEndingTime,$biddingStartingPrice,$biddingEndingPrice,$totalBidder);


    








} else {
    header("location: ../signUp.php");
    exit();
}
