<?php
session_start();
if (isset($_POST["submit"])) {


    $productID = $_SESSION['productID'];
    $promotionRate = $_POST['promotionRate'];
    $promotionEndingDate = $_POST['promotionEndingTime'];
   
    require_once 'databaseHandler.inc.php';
    require_once 'functions.inc.php';

    $promotionPrice =0.00;

    $productPrice = (double) getProductPrice($conn, $productID);
    $promotionRate = ((double) $promotionRate)/100;

    $promotionPrice = $productPrice - ($productPrice * $promotionRate);


    // echo "productPrice = ".$productPrice."<br>";
    // echo "promotionRate = ".$promotionRate."<br>";
    // echo "promotionPrice = ".$promotionPrice."<br>";


    addPromotionPriceProduct($conn, $productID, $promotionPrice);
    createPromotion($conn, $productID, $promotionRate, $promotionEndingDate);
 

//     if (invalidProductPrice($promotionRate)) {
//         header("location: ../createPromotion.php?error=invalidPromotionRate");
//         exit();
//     }


//     $sql = "SELECT * FROM product where productID='$productID'";
//     $result = mysqli_query($conn, $sql);
//     $resultCheck = mysqli_num_rows($result);
//     if ($resultCheck > 0) {
//         while ($row = mysqli_fetch_assoc($result)) {
//             $_SESSION["productQuantity"] = $row['productQuantity'];           
//         }
//     } 
//     $productQuantity = $_SESSION["productQuantity"];

//     createPromotion($conn, $productID, $promotionRate, $promotionEndingDate);


// } else {
//     header("location: ../signUp.php");
//     exit();
// }
}
