<?php
session_start();


require_once 'databaseHandler.inc.php';
require_once 'functions.inc.php';


$paypalId = $_POST["paypalId"];
$paypalStatus = $_POST["paypalStatus"];
$paypalAmount = $_POST["paypalAmount"];

$userEmail = $_SESSION["userEmail"];

date_default_timezone_set("Asia/Kuala_Lumpur");
$paymentDate = date("d/m/y h:i:s");

if ($paypalStatus == "COMPLETED") {
    $paymentStatus = "success";
    $paymentAmount = $paypalAmount;
    makePaymentOnSuccess($conn, $paymentAmount, $userEmail, $paymentStatus, $paymentDate);
}
