<?php
session_start();
// print_r($_POST);
// die();

// print_r($_POST);
// die();
include_once 'databaseHandler.inc.php';

$products = json_decode($_POST['product'], true);


foreach ($products['cart'] as $key => $product) {
    // print_r($product['id']);
    // die();

    
    $email = $_SESSION["userEmail"];
    $productID = $product['id'];
    $productQuantity = $product['qty'];
    
    $sql = "UPDATE product set productQuantity = productQuantity - $productQuantity where productID = '$productID'";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return false;
        exit();
    }
    
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
} 

// include_once 'makePaymentOnSuccess.inc.php';
include_once 'buyProduct.inc.php';
   
