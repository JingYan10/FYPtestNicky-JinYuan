<?php
session_start();

$shipmentID = $_POST["shipmentID"];

$finalShipmentID = substr($shipmentID, 8);


require_once 'databaseHandler.inc.php';
require_once 'functions.inc.php';


if(!empty(trackShipmentStatus($conn, $finalShipmentID))){
    echo trackShipmentStatus($conn, $finalShipmentID);
}else{
    echo "noData";
}