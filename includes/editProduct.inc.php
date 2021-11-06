<?php
session_start();
?>
<?php

if (isset($_POST["submit"])) {


    $productID = $_SESSION['productID'];
    $productName = $_POST["productName"];
    $productQuantity = $_POST["productQuantity"];
    $productPrice = $_POST["productPrice"];
    $email = $_SESSION['userEmail'];
    $oriProductImage = $_SESSION['productImage'];

    $file = $_FILES['file'];
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];

    $fileExt  = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg', 'jpeg', 'png');





    require_once 'databaseHandler.inc.php';
    require_once 'functions.inc.php';

    if (invalidProductName($productName)) {
        header("location: ../editProduct.php?error=invalidProductName");
        exit();
    }
    if (invalidProductQuantity($productQuantity)) {
        header("location: ../editProduct.php?error=invalidProductQuantity");
        exit();
    }
    if (invalidProductPrice($productPrice)) {
        header("location: ../editProduct.php?error=invalidProductPrice");
        exit();
    }

    if ($fileError == 0) {
        if (in_array($fileActualExt, $allowed)) {
            if ($fileError == 0) {
                if ($fileSize < 500000) {
                    $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                    $fileDestination = 'products/' . $fileNameNew;
                    move_uploaded_file($fileTmpName, $fileDestination);

                    $productImage = "includes/" . $fileDestination;
                    editProduct($conn, $productID, $productName, $productImage, $productQuantity, $productPrice, $email);
                } else {
                    header("location: ../editProduct.php?error=errorImgSize");
                    exit();
                }
            } else {
                header("location: ../editProduct.php?error=errorImgUpload");
                exit();
            }
        } else {
            header("location: ../editProduct.php?error=imgType");
            exit();
        }  
    }else{
        editProduct($conn, $productID, $productName, $oriProductImage, $productQuantity, $productPrice, $email);
    }
} else {
    header("location: ../editProduct.php");
    exit();
}
