<?php
session_start();
require_once 'databaseHandler.inc.php';
require_once 'functions.inc.php';


if (isset($_GET["shipmentArrangementNo"])) {

    $_SESSION["shipmentArrangementNo"] = $_GET["shipmentArrangementNo"];
    $shipmentArrangementNo = $_SESSION["shipmentArrangementNo"];

    $_SESSION["clientEmail"] = $_GET["clientEmail"];
    $clientEmail = $_SESSION["clientEmail"];


    // update status to delivering
    updateShipmentStatus($conn, $shipmentArrangementNo);
    // generate pin to the client
    generateDeliveryPin($conn, $clientEmail);
}
