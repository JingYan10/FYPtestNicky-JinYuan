<?php

if(isset($_POST["submit"])){
    
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];

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
                header("location: ../signUp.php?error=errorImgSize");
                exit();
            }

        }else{
            header("location: ../signUp.php?error=errorImgUpload");
            exit();
        }

    }else{
        header("location: ../signUp.php?error=imgType");
        exit();
    }

    $userImage = "includes/".$fileDestination;

    require_once 'databaseHandler.inc.php';
    require_once 'functions.inc.php';

    if(emptyInputSignUp($firstName,$lastName,$email,$password,$confirmPassword) != false){
        header("location: ../signUp.php?error=emptyInput");
        exit();
    }
    if(invalidName($firstName,$lastName) != false){
        header("location: ../signUp.php?error=invalidName");
        exit();
    }
    if(invalidEmail($email) != false){
        header("location: ../signUp.php?error=invalidEmail");
        exit();
    }
    if(matchingPassword($password,$confirmPassword) != false){
        header("location: ../signUp.php?error=mismatchPassword");
        exit();
    }
    if(isExistUser($conn, $email) != false){
        header("location: ../signUp.php?error=existingUser");
        exit();
    }

    
        

    createUser($conn,$firstName,$lastName,$email,$password,$userImage);

}
else{
    header("location: ../signUp.php");
    exit();
}