<?php
session_start();
require_once 'databaseHandler.inc.php';
require_once 'functions.inc.php';

//echo "total result ".findSoldProductID2($conn);

//echo testing2($conn);
// $userEmail=$_SESSION["userEmail"];

// increaseProductQuantityBidding($conn, 4);
// refundBiddingCoin($conn, 2);

//echo checkCoinBalance($conn,$userEmail);

// echo  testing2($conn)['shiftNO'][0]."<br>";
//echo testing2($conn);

// print_r(searchFriendByFriendCode($conn,2));


// deduct coin testing, for whenever the user place bid at any bidding
//deductCoin($conn, '$20',"tete1234@gmail.com" ,"3");
// add coin testing, for topup
//addCoin($conn, "50", "testing1234@gmail.com", "10");
// testing createproductComment
// createProductComment($conn, "testing", "testing", "testing1234@gmail.com");

//print_r(getAllWishlistData($conn));
// print_r((checkWishlistData($conn)["productID"]);

// getAllWishlistData($conn,$conn2);

//addPromotionPriceProduct($conn, "2", "20");

echo "hello". checkPromotionPrice($conn, "3");

// if(empty(checkPromotionPrice($conn, "2"))){
//     echo "promotion is empty";
// }
echo "price".getProductPrice ($conn, "2");


// echo generateFriendCode($conn);
