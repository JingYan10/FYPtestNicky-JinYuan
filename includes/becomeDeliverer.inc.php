<?php
session_start();
if(isset($_POST["submit"])){
    
    $email = $_SESSION['userEmail'];
    $IC = $_POST["IC"];
    $fullName = $_POST["fullName"];


    $file = $_FILES['file'];
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];

   

    require_once 'databaseHandler.inc.php';
    require_once 'functions.inc.php';

    if(invalidIC($IC)!=false){
        header("location: ../becomeSeller.php?error=invalidIC");
        exit();
    }
    if(invalidFullName($fullName) != false){
        header("location: ../becomeSeller.php?error=invalidFullName");
        exit();
    }



    /*documents Upload*/

    $fileExt  = explode('.',$fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('pdf');

    if(in_array($fileActualExt,$allowed)){
        if($fileError == 0){
            if($fileSize<500000){
                $fileNameNew = uniqid('',true).".".$fileActualExt;
                $fileDestination = 'documents/'.$fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);
                
                //create
                $documentLocation = "includes/".$fileDestination;
                
                createDelivererDocument($conn,$IC,$fullName,$documentLocation,$email);
                updateUserDelivererStatus($conn,$email);
            }else{
                header("location: ../becomeSeller.php?error=errorFileSize");
                exit();
            }

        }else{
            header("location: ../becomeSeller.php?error=errorFileUpload");
            exit();
        }

    }else{
        header("location: ../becomeSeller.php?error=fileType");
        exit();
    }

    
    



}
else{
    header("location: ../becomeSeller.php");
    exit();
}