<?php
session_start();
if(isset($_POST["submit"])){


    $productName = $_POST["productName"];
    $productQuantity = $_POST["productQuantity"];
    $productPrice = $_POST["productPrice"];
    $email = $_SESSION['userEmail'];


    $file = $_FILES['file'];
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];

    $fileExt  = explode('.',$fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg','jpeg','png');

    

    require_once 'databaseHandler.inc.php';
    require_once 'functions.inc.php';


    if(invalidProductName($productName)){
        header("location: ../createProduct.php?error=invalidProductName");
        exit();
    }
    if(invalidProductQuantity($productQuantity)){
        header("location: ../createProduct.php?error=invalidProductQuantity");
        exit();
    }
    if(invalidProductPrice($productPrice)){
        header("location: ../createProduct.php?error=invalidProductPrice");
        exit();
    }
  

    if(in_array($fileActualExt,$allowed)){
        if($fileError == 0){
            if($fileSize<500000){
                $fileNameNew = uniqid('',true).".".$fileActualExt;
                $fileDestination = 'products/'.$fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);

                $productImage = "includes/".$fileDestination;
                createProduct($conn,$productName, $productImage, $productQuantity,$productPrice, $email);
                
             
        
            }else{
                header("location: ../createProduct.php?error=errorImgSize");
                exit();
            }

        }else{
            header("location: ../createProduct.php?error=errorImgUpload");
            exit();
        }

    }else{
        header("location: ../createProduct.php?error=imgType");
        exit();
    }

    
        

    

}
else{
    header("location: ../signUp.php");
    exit();
}