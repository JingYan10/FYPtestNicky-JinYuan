<?php

if (isset($_POST["submit"])) {

    $email = $_POST["email"];

    require_once 'databaseHandler.inc.php';
    require_once 'functions.inc.php';
    require_once 'email.inc.php';


    if (isExistUser($conn, $email) == false) {
        header("location: ../forgetPassword.php?error=invalidExistUser");
        exit();
    }

    forgetPassword($conn, $email);
    
    header("location: ../verifyPin.php");
    exit();
} else {
    header("location: ../forgetPassword.php");
    exit();
}
