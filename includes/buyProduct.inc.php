<?php
session_start();

$productID = "5";
$productQuantity = "1";
$paymentID = "1";
$email = $_SESSION["userEmail"];

date_default_timezone_set("Asia/Kuala_Lumpur");
$shipmentDate = date('d/m/y h:i:s', strtotime('+1 day'));


echo $shipmentDate;

require_once 'databaseHandler.inc.php';
require_once 'functions.inc.php';


$buyProductTestingArray = array(
    array('productID' => '2', 'productQuantity' => 1, 'paymentID' => 1),
    array('productID' => '3', 'productQuantity' => 2, 'paymentID' => 1),
    array('productID' => '4', 'productQuantity' => 4, 'paymentID' => 1),
);


$newArrangementNo = generateNewShipmentArrangementNo($conn);
$previousShiftNo = generatenewShiftNo($conn);

$assignedDelivererEmail = decideDeliverer($conn,$previousShiftNo)[0];
$newShiftNo = decideDeliverer($conn,$previousShiftNo)[1];


// echo "<br>new shift :   ".$newShiftNo;
// echo "<br>new deliverer email :   ",$assignedDelivererEmail;
// echo "newArrangementNo".$newArrangementNo."<br>";
// echo "newShiftNo".$newShiftNo."<br>";



for ($i = 0; $i < sizeof($buyProductTestingArray); $i++) {
    // echo "<br>".$buyProductTestingArray[$i]['productID'];
    // echo "<br>".$buyProductTestingArray[$i]['productQuantity'];
    createSoldProductData($conn, $buyProductTestingArray[$i]['productID'], $buyProductTestingArray[$i]['productQuantity'], $paymentID, $email, $newArrangementNo);
    createShipmentData($conn, $buyProductTestingArray[$i]['productID'], $buyProductTestingArray[$i]['productQuantity'], $paymentID, $email, $newArrangementNo, $newShiftNo,$assignedDelivererEmail);
}
updateTaskDoneDeliverer($conn,$assignedDelivererEmail);
