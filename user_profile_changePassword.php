<?php
session_start();
?>

<?php
include_once 'header.php';
include_once 'includes/databaseHandler.inc.php';
?>

<link rel="stylesheet" href="user_profile_changePassword.css" />

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
    }
} else {
    header("location: ../login.php?error=noUserProfile");
    exit();
}


?>
<!--content here-->
<section class="edit-form">
    <div class="main-container">

        <div class="userImage">
            <p>
            <form action="includes/profileEditPicture.inc.php" method="post" enctype="multipart/form-data">
                <img src="<?php echo $_SESSION['userImage']; ?>" alt=""> 
            </form>
            </p>
        </div>

        <div class="userInfocard">
            <div class="userInfo">
                <form action="includes/profileEditPassword.inc.php" method="post">
                    <div class="userData">
                        <label>Old password</label>
                        <input type="password" name="oldPassword" required>
                        <?php
                            if(isset($_GET["error"])){
                                if ($_GET["error"] == "invalidEmail") {
                                    echo "<div style='margin-left:175px;color:red;font-weight:600'>inccorect email format</div>";
                                }
                            }
                        ?>
                    </div>
                    <div class="userData">
                        <label>New password</label>
                        <input type="password" name="newPassword" required>
                    </div>
                    <div class="userData">
                        <label>Confirm password</label>
                        <input type="password" name="confirmPassword" required>
                    </div>
                    <input type="submit" name="submit" class="btnConfirm" value="Confirm">
                </form>
            </div>
        </div>
    </div>
</section>



<?php
include_once 'footer.php';
?>



</body>

</html>