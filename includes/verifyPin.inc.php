<?php
session_start();
if (isset($_POST["submit"])) {


    $pinCode = $_POST['pinCode'];
    $oriPinCode = $_SESSION["pinCode"];

    require_once 'databaseHandler.inc.php';
    require_once 'functions.inc.php';
    require_once 'email.inc.php';

    if($pinCode!=$oriPinCode){
        header("location: ../verifyPin.php?error=pinNotMatch");
        exit();
    }

    header("location: ../pinChangePassword.php");
    exit();
} else {
    header("location: ../forgetPassword.php");
    exit();
}
