<?php
    session_start();

    $productID = "5";
    $productQuantity = "1";
    $paymentID = "1";
    $email = $_SESSION["userEmail"];

    date_default_timezone_set("Asia/Kuala_Lumpur");
    $shipmentDate = date('d/m/y h:i:s',strtotime('+1 day'));
    

    echo $shipmentDate;

    require_once 'databaseHandler.inc.php';
    require_once 'functions.inc.php';

    // createSoldProduct($conn,$productID,$productQuantity,$paymentID,$email);
    
    // createShipment($conn,findSoldProductID($conn),$productQuantity,$shipmentDate,$email);

    createBoughtProductData($conn, $productID, $productQuantity, $paymentID, $email);

    
    
    
