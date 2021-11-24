<?php
session_start();

$paymentAmount = $_POST["paymentAmount"]; 
$userEmail = $_SESSION["userEmail"];
$paymentStatus = $_POST["paymentStatus"];

date_default_timezone_set("Asia/Kuala_Lumpur");
$paymentDate = date("d/m/y h:i:s");


require_once 'databaseHandler.inc.php';
require_once 'functions.inc.php';

makePayment($conn, $paymentAmount, $userEmail, $paymentStatus, $paymentDate);



