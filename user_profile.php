<?php
session_start();
?>

<?php
include_once 'header.php';
include_once 'includes/databaseHandler.inc.php';
?>

<link rel="stylesheet" href="user_profile.css" />

<!--content here-->


<!--how you get data-->
<?php
$sql = "SELECT * FROM users where userEmail='$_SESSION[userEmail]'";
$result = mysqli_query($conn, $sql);
$resultCheck = mysqli_num_rows($result);
if ($resultCheck > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $_SESSION["userFirstName"] = $row['userFirstName'];
        $_SESSION["userLastName"] = $row['userLastName'];
        $_SESSION["userRole"] = $row['userRole'];
        $_SESSION["userImage"] = $row['userImage'];
        $_SESSION["sellerStatus"] = $row['sellerStatus'];
        $_SESSION["delivererStatus"] = $row['delivererStatus'];
        $_SESSION["deliveryPin"] = $row['deliveryPin'];
    }
} else {
    header("location: ../login.php?error=noUserProfile");
    exit();
}
?>



<div class="main-container">
    <div class="userImage">
        <p>
            <img src="<?php echo $_SESSION['userImage']; ?>" alt=""> <br>
            <a href="user_profile_edit.php"><input type="button" class="btnEditImage" value="Edit"></a>
        </p>
    </div>

    <div class="userInfocard">
        <div class="userInfo">
            <div class="userData">
                <label>First name</label>
                <input type="text" name="firstName" value="<?php echo $_SESSION['userFirstName']; ?>" disabled>
            </div>
            <div class="userData">
                <label>Last name</label>
                <input type="text" name="lastName" value="<?php echo $_SESSION['userLastName']; ?>" disabled>
            </div>
            <div class="userData">
                <label>Email</label>
                <input type="text" name="email" value="<?php echo $_SESSION['userEmail']; ?>" disabled>

            </div>
            <div class="userData">
                <label>User role</label>
                <input type="text" value="<?php echo $_SESSION['userRole']; ?>" disabled>
            </div>
            <div class="userData">

                <?php
                if ($_SESSION["sellerStatus"] == "pending") {
                    echo '<label>Seller request</label><label style="margin-left:5px;">pending</label>';
                }
                if ($_SESSION["delivererStatus"] == "pending") {
                    echo '<br><label>Deliverer request</label><label style="margin-left:5px;margin-top:5px;">pending</label>';
                }
                ?>

            </div>
            <a href="user_profile_changePassword.php"><input type="button" value="Change Passsword" class="btnEditPassword"></a>
            <a href="user_profile_edit.php"><input type="button" class="btnEdit" value="Edit"></a>

            <input type="text" class="searchTerm" placeholder="Enter friend code">
            <button type="submit" class="searchButton">
                <i class="fa fa-search"></i>
            </button>
            
            <br>
            <?php
            if ($_SESSION["sellerStatus"] == null && $_SESSION["delivererStatus"] == null) {
                echo '<a href="becomeSeller.php"><input type="button" class="btnUpgradeSeller" value="Become a seller"></a>';
                echo '<a href="becomeDeliverer.php"><input type="button" class="btnUpgradeDeliverer" value="Become a deliverer"></a> ';
            }
            ?>
            <?php
            if ($_SESSION["deliveryPin"] != null) {
                $deliveryPin = $_SESSION["deliveryPin"];
                echo "
                <div class='userData'>
                <input type='button' class='btnDeliveryPin' onclick='toggleDeliveryPin()' value='Show delivery pin'>
                <input type='text' class='deliveryPin' id='deliveryPin' value='$deliveryPin' disabled>
            </div>
                ";
            }
            ?>

        </div>

    </div>
</div>

<?php
if ($_SESSION["userRole"] == "seller") {
    include_once 'sellerContainer.php';
} else if ($_SESSION["userRole"] == "deliverer") {
    include_once 'delivererContainer.php';
}

?>


<script>
    function toggleProductListing() {
        targetDiv = document.getElementById("product-listing");
        if (targetDiv.style.display != "none") {
            targetDiv.style.display = "none";
        } else {
            targetDiv.style.display = "block";
        }
    }

    function toggleDeliveryPin() {
        targetDiv = document.getElementById("deliveryPin");

        targetDiv.style.display = "inline";
    }
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $("#search").keyup(function() {
            $.ajax({
                type: 'POST',
                url: 'includes/searchProduct.inc.php',
                data: {
                    name: $("#search").val(),
                },
                success: function(data) {
                    $("#output").html(data);

                }
            });
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#search2").keyup(function() {
            $.ajax({
                type: 'POST',
                url: 'includes/searchShipment.inc.php',
                data: {
                    name2: $("#search2").val(),
                },
                success: function(data) {
                    $("#output2").html(data);
                }
            });
        });
    });
</script>

<?php
include_once 'footer.php';
?>



</body>

</html>