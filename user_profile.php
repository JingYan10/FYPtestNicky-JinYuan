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
            <form class="search_bar small" action="POST">
                <input type="text" name="searchFriendCode" id="searchFriendCode" placeholder="Search for users" />
                <button type="button" id="btnFriendCode" onclick="searchFriends()">Search</button>
                <div id="resultForFriend"></div>
            </form>

            <a href="user_profile_changePassword.php"><input type="button" value="Change Passsword" class="btnEditPassword"></a>
            <a href="user_profile_edit.php"><input type="button" class="btnEdit" value="Edit"></a>
            <a href="paymentHistory.php"><input type="button" class="btnPaymentHistory" value="Payment History"></a>
            <a href="friendlist.php"><input type="button" class="btnFriendlist" value="Friendlist"></a>



            <br>
            <?php
            if ($_SESSION["sellerStatus"] == null && $_SESSION["delivererStatus"] == null) {
                echo '<a href="becomeSeller.php"><input type="button" class="btnUpgradeSeller" value="Become a seller"></a>';
                echo '<a href="becomeDeliverer.php"><input type="button" class="btnUpgradeDeliverer" value="Become a deliverer"></a> ';
            }
            ?>
            <?php
            if ($_SESSION["sellerStatus"] == 'disable' && $_SESSION["delivererStatus"] == null) {
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


<div class="friend-container">
    <div class="friend-container2">
        <table class="table1">
            <caption>Add friend table</caption>
            <thead>
                <tr>
                    <th scope="col">userFirstName</th>
                    <th scope="col">userLastName</th>
                    <th scope="col">userImage</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td data-label="Account">Visa - 3412</td>
                    <td data-label="Due Date">04/01/2016</td>
                    <td data-label="Amount">$1,190</td>
                    <td data-label="Action" a href="addFriend.inc.php"><input type="button" class="btnAddFriend" value="Add Friend"></a></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<?php
if ($_SESSION["userRole"] == "seller" && $_SESSION["sellerStatus"] == "approved") {
    include_once 'sellerContainer.php';
} else if ($_SESSION["userRole"] == "deliverer") {
    include_once 'delivererContainer.php';
} else if ($_SESSION["sellerStatus"] == "disable") {
    echo '<script>alert("Seller Status had been disabled")</script>';
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
    // $(document).ready(function() {
    // $("#btnFriendCode").onclick(function() {
    //     $.ajax({
    //         type: 'POST',
    //         url: 'includes/searchFriendByFriendCode.inc.php',
    //         data: {
    //             name: $("#searchFriendCode").val(),
    //         },
    //         success: function(data) {
    //             // $("#resultForFriend").html(data);
    //         }
    //     });
    // });
    // });

    function searchFriends() {
        $.ajax({
            type: 'POST',
            url: 'includes/searchFriendByFriendCode.inc.php',
            data: {
                name: $("#searchFriendCode").val(),
            },
            success: function(data) {
                // $("#resultForFriend").html(data);
            }
        });
    }
</script>
<script>

</script>
<?php
include_once 'footer.php';
?>



</body>

</html>