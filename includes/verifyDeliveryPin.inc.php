<?php
session_start();
require_once 'databaseHandler.inc.php';
require_once 'functions.inc.php';


if (isset($_POST["submit"])) {

    $deliveryPin = $_POST["deliveryPin"];
    $clientEmail = $_POST["clientEmail"];
    $shipmentArrangementNo = $_POST["shipmentArrangementNo"];
    // echo "<br>delivery pin : ".$deliveryPin;
    // echo "<br>client email : ".$clientEmail;
    //echo "<br>arrangement no : ".$shipmentArrangementNo;

    if (verifyDeliveryPin($conn, $deliveryPin, $clientEmail) == true) {
        updateDeliveryDeliveredStatus($conn, $shipmentArrangementNo);
        header("location: ../user_profile.php");
        exit();
    } else {
        header("location: ../viewShipmentDetail.php?error=mismatchDeliveryPin");
        exit();
    }
}
