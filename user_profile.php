<?php
session_start();
?>

<?php
include_once 'header.php';
include_once 'includes/databaseHandler.inc.php';
?>

<link rel="stylesheet" href="user_profile.css" />

<!--content here-->


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
                ?>

            </div>
            <a href="user_profile_changePassword.php"><input type="button" value="Change Passsword" class="btnEditPassword"></a>
            <a href="user_profile_edit.php"><input type="button" class="btnEdit" value="Edit"></a>
            <br>
            <?php
            if ($_SESSION["sellerStatus"] == null) {
                echo '<a href="becomeSeller.php"><input type="button" class="btnUpgradeSeller" value="Become a seller"></a>';
                echo '<a href="user_profile_edit.php"><input type="button" class="btnUpgradeDeliverer" value="Become a deliverer"></a> ';
            } else {
                echo '<a href="user_profile_edit.php"><input type="button" style="margin-left:170px;" class="btnUpgradeDeliverer" value="Become a deliverer"></a>';
            }
            ?>

        </div>
    </div>
</div>

<div class="seller-container">
    <div class="product-container">
        <div class="productInfo">
           <a href="createProduct.php"><input type="button" class="btnCreateProduct" value="createProduct"></a> 
        </div>
    </div>
</div>


<?php
include_once 'footer.php';
?>



</body>

</html>