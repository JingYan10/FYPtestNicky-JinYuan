<?php
session_start();

if (isset($_POST["submit"])) {


    $email = $_SESSION['recoveryUserEmail'];
    $newPassword = $_POST["newPassword"];
    $confirmPassword = $_POST["confirmPassword"];


    require_once 'databaseHandler.inc.php';
    require_once 'functions.inc.php';



    if (matchingPassword($newPassword, $confirmPassword) != false) {
        header("location: ../pinChangePassword.php?error=mismatchPassword");
        exit();
    }

    pinChangePassword($conn, $email, $newPassword);


} else {
    header("location: ../pinChangePassword.php");
    exit();
}
