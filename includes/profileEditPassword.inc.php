<?php
session_start();

if (isset($_POST["submit"])) {


    $email = $_SESSION['userEmail'];
    $oldPassword = $_POST["oldPassword"];
    $newPassword = $_POST["newPassword"];
    $confirmPassword = $_POST["confirmPassword"];



    require_once 'databaseHandler.inc.php';
    require_once 'functions.inc.php';

    

    if (matchingPassword($newPassword, $confirmPassword) != false) {
        header("location: ../user_profile_changePassword.php?error=mismatchPassword");
        exit();
    }
    if (checkOldPassword($conn, $email, $oldPassword) == false) {
        header("location: ../user_profile_changePassword.php?error=oldPassword");
        exit();
    } else if (checkOldPassword($conn, $email, $oldPassword) == true) {
        changePassword($conn, $email, $newPassword);
    }
    
} else {
    header("location: ../user_profile_edit.php");
    exit();
}
