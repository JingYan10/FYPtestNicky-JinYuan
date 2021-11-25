<?php
// session_start();

require_once 'databaseHandler.inc.php';
require_once 'functions.inc.php';

$products = json_decode($_POST['product'], true);

// print_r ($products);
// die();

$sql = "SELECT * FROM payment";

$stmt = mysqli_stmt_init($conn);
$result = mysqli_query($conn, $sql);
$resultCheck = mysqli_num_rows($result);
$paymentID = "";


$databaseShiftNo = "";
if ($resultCheck > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $paymentID = $row['paymentID'];
    }
}


// echo '<pre>';
// print_r($products);
// echo '</pre>';
// die();


$email = $_SESSION["userEmail"];

date_default_timezone_set("Asia/Kuala_Lumpur");
$shipmentDate = date('d/m/y h:i:s', strtotime('+1 day'));


//remove sold products from user cart


// echo $shipmentDate;

$buyProductTestingArray = [];

foreach ($products['cart'] as $key => $product) {

    $row = [
        'productID' => $product['id'],
        'productQuantity' => $product['qty'],
        'paymentID' => $paymentID
    ];

    array_push($buyProductTestingArray, $row);
}
// print_r ($buyProductArr);

// $buyProductTestingArray = array(
//     array('productID' => '2', 'productQuantity' => 1, 'paymentID' => 1),
//     array('productID' => '3', 'productQuantity' => 2, 'paymentID' => 1),
//     array('productID' => '4', 'productQuantity' => 4, 'paymentID' => 1),
// );

// print_r($buyProductTestingArray); echo "<br>";
// print_r($buyProductTestingArray2); echo "<br>";

$newArrangementNo = generateNewShipmentArrangementNo($conn);
$previousShiftNo = generatenewShiftNo($conn);

$assignedDelivererEmail = decideDeliverer($conn, $previousShiftNo)[0];
$newShiftNo = decideDeliverer($conn, $previousShiftNo)[1];


// echo "<br>new shift :   ".$newShiftNo;
// echo "<br>new deliverer email :   ",$assignedDelivererEmail;
// echo "newArrangementNo".$newArrangementNo."<br>";
// echo "newShiftNo".$newShiftNo."<br>";



for ($i = 0; $i < sizeof($buyProductTestingArray); $i++) {
    // echo "<br>".$buyProductTestingArray[$i]['productID'];
    // echo "<br>".$buyProductTestingArray[$i]['productQuantity'];
    createSoldProductData($conn, $buyProductTestingArray[$i]['productID'], $buyProductTestingArray[$i]['productQuantity'],  $buyProductTestingArray[$i]['paymentID'], $email, $newArrangementNo);
    createShipmentData($conn, $buyProductTestingArray[$i]['productID'], $buyProductTestingArray[$i]['productQuantity'],  $buyProductTestingArray[$i]['paymentID'], $email, $newArrangementNo, $newShiftNo, $assignedDelivererEmail);
}
updateTaskDoneDeliverer($conn, $assignedDelivererEmail);


$sql = "DELETE FROM cart WHERE userEmail = '$email';";
$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt, $sql)) {
    return false;
    exit();
}

mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);