<?php
session_start();
require_once 'databaseHandler.inc.php';
require_once 'functions.inc.php';

//echo "total result ".findSoldProductID2($conn);

//echo testing2($conn);
$userEmail=$_SESSION["userEmail"];

// increaseProductQuantityBidding($conn, 4);
// refundBiddingCoin($conn, 2);

//echo checkCoinBalance($conn,$userEmail);

// echo  testing2($conn)['shiftNO'][0]."<br>";
//echo testing2($conn);

print_r(searchFriendByFriendCode($conn,2));
