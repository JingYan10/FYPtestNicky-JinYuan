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
    $_SESSION["productName"];
    $_SESSION["productImage"];

    $_SESSION["userEmail"];
    $_SESSION["userFirstName"];
    $_SESSION["userLastName"];
    $_SESSION["userPhoneNumber"];
    $_SESSION["userHouseAddress"];
} else {


    if (isset($_GET["shipmentID"])) {

        $_SESSION["shipmentID"] = $_GET["shipmentID"];
        $_SESSION["soldProductID"] = $_GET["shipmentID"];
        $_SESSION["soldProductQuantity"] = $_GET["shipmentID"];
        $_SESSION["shipmentDate"] = $_GET["shipmentDate"];

        $shipmentID = $_SESSION["shipmentID"];
        $shipmentSoldProductID = $_SESSION["soldProductID"];



        $sql = "SELECT * FROM soldProduct where soldProductID='$shipmentSoldProductID'";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        if ($resultCheck > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $_SESSION["soldProductProductID"] = $row['productID'];
                $_SESSION["soldProductProductQuantity"] = $row['productQuantity'];
                $_SESSION["soldProductPaymentID"] = $row['paymentID'];
                $_SESSION["soldProductUserEmail"] = $row['userEmail'];
                $_SESSION["soldProductShipmentID"] = $row['shipmentID'];
                $_SESSION["soldProductUserEmail"] = $row['userEmail'];
            }
        } else {
            header("location: ../login.php?error=noUserProfile");
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
            header("location: ../login.php?error=noUserProfile");
            exit();
        }
    }
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
                    <textarea type="text" rows="4" cols="33" name="userHouseAddress" disabled> <?php echo  $_SESSION["userHouseAddress"]; ?></textarea>
                </div>

            </div>
        </details>

        <details class="style4">
            <summary>Deliver Product</summary>
            <div class="content">
                <?php
                if (isset($_SESSION["soldProductProductID"])) {
                    $soldProductProductID = $_SESSION["soldProductProductID"];
                    $sql = "SELECT * FROM product where productID='$soldProductProductID'";
                    $result = mysqli_query($conn, $sql);
                    $resultCheck = mysqli_num_rows($result);
                    if ($resultCheck > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "Product name : ".$row['productName']."<br>";
                            echo "Product quantity :".$_SESSION['soldProductProductQuantity']."<br>";
                            echo "Product image : ".$row['productImage']."<br>";
                        }
                    } else {
                        header("location: ../user_profile.php?error=noProductInfo");
                        exit();
                    }
                } else {
                    header("location: ../bidding.php?error=noSoldProductID");
                    exit();
                }
                ?>
            </div>
        </details>

    </div>



</section>

<div class="removethis" style="margin-bottom: 700px;"></div>

<!--footer-->
<?php
include_once 'footer.php';
?>
</body>

</html>