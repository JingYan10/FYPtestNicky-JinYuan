<?php
session_start();
if (isset($_POST["submit"])) {


    $email = $_SESSION['userEmail'];
    $workingShift = $_POST['workingShift'];



    // echo "email : ".$email."<br>";
    // echo "working shift : ".$workingShift."<br>";

    require_once 'databaseHandler.inc.php';
    require_once 'functions.inc.php';


    if (checkWorkingShiftAvailability($conn, $workingShift) == false) {
        header("location: ../selectWorkingShift.php?error=shiftAvailability");
        exit();
    }
    else{
        createWorkingShift($conn,$workingShift,$email);
    }
    // if(invalidProductPrice($biddingStartingPrice)){
    //     header("location: ../createBidding.php?error=invalidBiddingStartingPrice");
    //     exit();
    // }



    // createBidding($conn,$productID,$biddingEndingTime,$biddingStartingPrice,$biddingEndingPrice,$totalBidder);











} else {
    header("location: ../signUp.php");
    exit();
}
