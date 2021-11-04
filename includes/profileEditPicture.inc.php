<?php
session_start();

if(isset($_POST["submit"])){
    

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

    if(in_array($fileActualExt,$allowed)){
        if($fileError == 0){
            if($fileSize<500000){
                $fileNameNew = uniqid('',true).".".$fileActualExt;
                $fileDestination = 'uploads/'.$fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);
             
        
            }else{
                header("location: ../user_profile_edit.php?error=errorImgSize");
                exit();
            }

        }else{
            header("location: ../user_profile_edit.php?error=errorImgUpload");
            exit();
        }

    }else{
        header("location: ../user_profile_edit.php?error=imgType");
        exit();
    }

    $userImage = "includes/".$fileDestination;


    require_once 'databaseHandler.inc.php';
    require_once 'functions.inc.php';


    updateUserImage($conn,$email,$userImage);

}
else{
    header("location: ../user_profile_edit.php");
    exit();
}