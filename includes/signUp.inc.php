<?php

if(isset($_POST["submit"])){
    
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];

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

    createUser($conn,$firstName,$lastName,$email,$password);

}
else{
    header("location: ../signUp.php");
    exit();
}