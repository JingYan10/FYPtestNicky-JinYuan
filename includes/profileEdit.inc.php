<?php
session_start();

if(isset($_POST["submit"])){
    
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $email = $_SESSION['userEmail'];



    require_once 'databaseHandler.inc.php';
    require_once 'functions.inc.php';

    if(invalidName($firstName,$lastName) != false){
        header("location: ../user_profile_edit.php?error=invalidName");
        exit();
    }
    if(invalidEmail($email) != false){
        header("location: ../user_profile_edit.php?error=invalidEmail");
        exit();
    }
    

    updateUser($conn,$firstName,$lastName,$email);

}
else{
    header("location: ../user_profile_edit.php");
    exit();
}