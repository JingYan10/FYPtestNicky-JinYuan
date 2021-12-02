<?php
// Start the session
session_start();
?>
<?php
include_once 'header.php';
?>
<?php
include_once 'header.php';
include_once 'includes/databaseHandler.inc.php';
?>
<!--link to css-->
<link rel="stylesheet" href="viewShipmentDetail.css">

<?php

if (isset($_GET["error"])) {

    $_SESSION["shipmentID"];
    $_SESSION["soldProductID"];
    $_SESSION["soldProductQuantity"];
    $_SESSION["shipmentDate"];
    $_SESSION["soldProductProductID"];
    $_SESSION["soldProductProductQuantity"];
    $_SESSION["soldProductPaymentID"];
    $_SESSION["soldProductUserEmail"];
    $_SESSION["soldProductShipmentID"];
    $_SESSION["shipmentArrangementNo"];
    $_SESSION["shipmentStatus"];


    $_SESSION["userEmail"];
    $_SESSION["userFirstName"];
    $_SESSION["userLastName"];
    $_SESSION["userPhoneNumber"];
    $_SESSION["userHouseAddress"];
} else {

    $_SESSION["shipmentID"] = $_GET["shipmentID"];
    $_SESSION["soldProductID"] = $_GET["soldProductID"];
    $_SESSION["soldProductQuantity"] = $_GET["soldProductQuantity"];
    $_SESSION["shipmentDate"] = $_GET["shipmentDate"];
    $_SESSION["shipmentArrangementNo"] = $_GET["shipmentArrangementNo"];
    $_SESSION["shipmentStatus"] = $_GET["shipmentStatus"];


    // echo "shipment status = ".$_SESSION["shipmentStatus"];
    $shipmentID = $_SESSION["shipmentID"];
    $shipmentSoldProductID = $_SESSION["soldProductID"];





}
$shipmentArrangementNo = $_SESSION["shipmentArrangementNo"];

// echo "<br> shipmentArrangementNo : ".$shipmentArrangementNo;

$sql = "SELECT * FROM soldProduct where shipmentArrangementNo='$shipmentArrangementNo'";
$result = mysqli_query($conn, $sql);
$resultCheck = mysqli_num_rows($result);

$arraySoldProduct = array();

$arraySoldProductProductID = array(); // store for notification purpose

if ($resultCheck > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $_SESSION["soldProductProductID"] = $row['productID'];
        $_SESSION["soldProductProductQuantity"] = $row['productQuantity'];
        $_SESSION["soldProductPaymentID"] = $row['paymentID'];
        $_SESSION["soldProductUserEmail"] = $row['userEmail'];
        $_SESSION["soldProductShipmentID"] = $row['shipmentID'];
        $_SESSION["soldProductUserEmail"] = $row['userEmail'];
        $arraySoldProduct['soldProductProductID'][] = $row['productID'];
        $arraySoldProduct['soldProductProductQuantity'][] = $row['productQuantity'];
        $arraySoldProductProductID[] +=$row['productID'];
    }
    $_SESSION["arraySoldProductProductID"] = $arraySoldProductProductID;
} else {
    header("location: ../login.php?error=noUserProfile1");
    exit();
}

$userEmail = $_SESSION["soldProductUserEmail"];

$sql = "SELECT * FROM users where userEmail='$userEmail'";
$result = mysqli_query($conn, $sql);
$resultCheck = mysqli_num_rows($result);

if ($resultCheck > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $_SESSION["userFirstName"] = $row['userFirstName'];
        $_SESSION["userLastName"] = $row['userLastName'];
        $_SESSION["userPhoneNumber"] = $row['userPhoneNumber'];
        $_SESSION["userHouseAddress"] = $row['userHouseAddress'];
    }
} else {
    header("location: ../login.php?error=noUserProfile6");
    exit();
}

?>



<!--content here-->
<section class="client-profile">

    <div class="outterContainer">

        <details>
            <summary>Shipment</summary>
        </details>
        <details class="style4">
            <summary>Client Data</summary>
            <div class="content">
                <div class="clientData">
                    <label>First name : </label>
                    <input type="text" name="userFirstName" value="<?php echo  $_SESSION["userFirstName"]; ?>" disabled>
                </div>
                <div class="clientData">
                    <label>Last name : </label>
                    <input type="text" name="userLastName" value="<?php echo  $_SESSION["userLastName"]; ?>" disabled>
                </div>
                <div class="clientData">
                    <label>Phone number : </label>
                    <input type="text" name="userPhoneNumber" value="<?php echo  $_SESSION["userPhoneNumber"]; ?>" disabled>
                </div>
                <div class="clientData">
                    <label>House address : </label>
                    <iframe width="100%" height="500" src="https://maps.google.com/maps?q=<?php echo $_SESSION["userHouseAddress"]; ?>&output=embed"></iframe>
                </div>

            </div>
        </details>

        <details class="style4">
            <summary>Deliver Product</summary>
            <div class="content">
                <?php


                if (isset($_SESSION["soldProductProductID"])) {
                    //$soldProductProductID = $_SESSION["soldProductProductID"];
                    echo '<table>
                            <thead>
                                <tr>
                                    <th scope="col">Product name</th>
                                    <th scope="col">Product quantity</th>
                                    <th scope="col">Product image</th>
                                </tr>
                            </thead><tbody id="output">';

                    for ($i = 0; $i < sizeOf($arraySoldProduct['soldProductProductID']); $i++) {
                        $soldProductProductID = $arraySoldProduct['soldProductProductID'][$i];

                        $sql = "SELECT * FROM product where productID='$soldProductProductID'";
                        $result = mysqli_query($conn, $sql);
                        $resultCheck = mysqli_num_rows($result);
                        if ($resultCheck > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $row['productName'] . "</td>";
                                echo "<td>" . $arraySoldProduct['soldProductProductQuantity'][$i] . "</td>";
                                echo "<td>" . "<img style='height:140px;width:140px;' src=" . $row['productImage'] . ">" . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            header("location: ../user_profile.php?error=noProductInfo");
                            exit();
                        }
                    }
                    echo ' </tbody></table>';
                } else {
                    header("location: ../bidding.php?error=noSoldProductID");
                    exit();
                }

                ?>
            </div>
        </details>

    

        <?php
        if (isset($_GET["error"])) {
            if ($_GET["error"] == "noneDelivering") {
                echo "<form action='includes/verifyDeliveryPin.inc.php' method='post'>";
                echo "<details>";
                echo "<summary> <input type='hidden' name='clientEmail' value='$userEmail'> <input type='hidden' name='shipmentArrangementNo' value='$shipmentArrangementNo'> <input type='text' name='deliveryPin' class='inputDeliveryPin' style='height:40px;' placeholder='deliver pin'><input class='btnDeliver' style='margin-left: 150px;' type='submit' name='submit'></summary>";
                echo "</details>";
                echo "</form>";
            } else if ($_GET["error"] == "mismatchDeliveryPin") {
                echo "<form action='includes/verifyDeliveryPin.inc.php' method='post'>";
                echo "<details>";
                echo "<summary> <input type='hidden' name='clientEmail' value='$userEmail'> <input type='hidden' name='shipmentArrangementNo' value='$shipmentArrangementNo'> <input type='text' name='deliveryPin' class='inputDeliveryPin' style='height:40px;' placeholder='deliver pin'><input class='btnDeliver' style='margin-left: 150px;' type='submit' name='submit'>";
                echo "<p style='text-align:center;color:white;font-weight:600'>error delivery pin</p>";
                echo "</summary>";
                echo "</details>";
                echo "</form>";
            }
        } else {

            if ($_SESSION["shipmentStatus"] == "taskAssigned") {
                echo "<details>";
                $shipmentData = "shipmentArrangementNo=" . $shipmentArrangementNo . "&clientEmail=" . $userEmail;
                echo "<summary> <a href='includes/updateShipmentStatus.inc.php?$shipmentData'><input class='btnDeliver' style='margin-left: 310px;' type='button' value='deliver'></a></summary>";
                echo "</details>";
            } else if ($_SESSION["shipmentStatus"] == "delivering") {
                echo "<form action='includes/verifyDeliveryPin.inc.php' method='post'>";
                echo "<details>";
                echo "<summary>  <input type='hidden' name='clientEmail' value='$userEmail'> <input type='hidden' name='shipmentArrangementNo' value='$shipmentArrangementNo'> <input type='text' name='deliveryPin' class='inputDeliveryPin' style='height:40px;' placeholder='deliver pin'><input class='btnDeliver' style='margin-left: 150px;' type='submit' name='submit'></summary>";
                echo "</details>";
                echo "</form>";
            } else if ($_SESSION["shipmentStatus"] == "delivered") {
            }
        }
        ?>


        

    </div>



</section>

<div class="removethis" style="margin-bottom: 700px;"></div>

<!--footer-->
<?php
include_once 'footer.php';
?>
</body>

</html>