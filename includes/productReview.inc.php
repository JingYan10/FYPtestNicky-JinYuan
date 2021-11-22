<?php
session_start();

if (isset($_POST["submit"])) {

    $userEmail = $_SESSION["userEmail"];
    $productID = $_POST["productID"];
    $productRating = (int) $_POST["rating"] + 1;
    $productComment = $_POST["productComment"];

    // echo "product ID : ". $productID."<br>";
    // echo "product rating : ". $productRating."<br>";
    // echo "product comment : ". $productComment."<br>";

    require_once 'databaseHandler.inc.php';
    require_once 'functions.inc.php';

    createProductRating($conn, $productID, $productRating, $userEmail);
    createProductComment($conn, $productID, $productComment, $userEmail);
    deleteProductReviewNotification($conn, $productID, $userEmail);
}
