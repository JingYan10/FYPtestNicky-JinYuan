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
            <button class="btnShowProductListing" onclick="toggleProductListing()">show product listing</button>
            <div id="product-listing" style="display:none;" class="product-listing">

                
                        <?php
                        $sql = "SELECT * FROM product where userEmail='tete1234@gmail.com' AND deleteStatus IS NULL ";
                        $result = mysqli_query($conn, $sql);
                        $resultCheck = mysqli_num_rows($result);
                       
                        if ($resultCheck > 0) {
                            echo '<table>
                            <caption>Products</caption>
                            <thead>
                                <tr>
                                    <th scope="col">Product ID</th>
                                    <th scope="col">Product name</th>
                                    <th scope="col">product image</th>
                                    <th scope="col">product quantity</th>
                                    <th scope="col">product price</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead><tbody>';
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . "P00" . $row['productID'] . "</td>";
                                echo "<td>" . $row['productName'] . "</td>";
                                echo "<td>" . "<img style='height:140px;width:140px;' src=" . $row['productImage'] . ">" . "</td>";
                                echo "<td>" . $row['productQuantity'] . "</td>";
                                echo "<td>" . $row['productPrice'] . "</td>";
                                echo "<td>";
                                $productData = "productID=" . $row['productID'] . "&productName=" . $row['productName'] . "&productImage=" . $row['productImage'] . "&productQuantity=" . $row['productQuantity'] . "&productPrice=" . $row['productPrice'];
                                echo "<a href='editProduct.php?" . $productData . "'>" . "<button class='btnEditProduct'>edit</button></a>";
                                echo "<a href='deleteProduct.php?".$productData."'>"."<button class='btnDeleteProduct'>delete</button></a>";
                                echo "</td>";
                                echo "</tr>";
                            }
                            echo ' </tbody></table>';
                        } else {
                            echo 'there is no product created';
                        }
                        ?>
                <div style="margin-bottom:50px;"></div>

                



            </div>
        </div>
    </div>
</div>

<script>
    function toggleProductListing() {
        targetDiv = document.getElementById("product-listing");
        if (targetDiv.style.display != "none") {
            targetDiv.style.display = "none";
        } else {
            targetDiv.style.display = "block";
        }
    }
</script>

<?php
include_once 'footer.php';
?>



</body>

</html>