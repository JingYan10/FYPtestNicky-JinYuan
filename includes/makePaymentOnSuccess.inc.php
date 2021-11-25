<?php
session_start();

$paymentAmount = $_SESSION['price'];
$userEmail = $_SESSION["userEmail"];
$paymentStatus = "success";

date_default_timezone_set("Asia/Kuala_Lumpur");
$paymentDate = date("d/m/y h:i:s");


require_once 'databaseHandler.inc.php';
require_once 'functions.inc.php';

makePaymentOnSuccess($conn, $paymentAmount, $userEmail, $paymentStatus, $paymentDate);



