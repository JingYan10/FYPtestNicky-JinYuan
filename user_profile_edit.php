<?php
session_start();
?>

<?php
include_once 'header.php';
include_once 'includes/databaseHandler.inc.php';
?>

<link rel="stylesheet" href="user_profile_edit.css" />

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
                <img src="<?php echo $_SESSION['userImage']; ?>" alt=""> <br>
                <input type="file" name="file" class="btnEditImage" required> <br>
                <?php
                    if(isset($_GET["error"])){
                        if ($_GET["error"] == "imgType") {
                            echo "<div style='margin-left:45px;color:red;font-weight:600'> upload image in (jpg/jpeg/png) format</div>";
                        }else if ($_GET["error"] == "errorImgSize") {
                            echo "<div style='margin-left:75px;color:red;font-weight:600'> reupload smaller image size</div>";
                        }else if ($_GET["error"] == "errorImgUpload") {
                            echo "<div style='margin-left:140px;color:red;font-weight:600'> try again</div>";
                        }
                    }
                ?>
                <input type="submit" name="submit" class="btnConfirm2" value="Confirm">
            </form>
            </p>
        </div>

        <div class="userInfocard">
            <div class="userInfo">
                <form action="includes/profileEdit.inc.php" method="post">
                    <div class="userData">
                        <label>First name</label>
                        <input type="text" name="firstName" value="<?php echo $_SESSION['userFirstName']; ?>" required>
                        <?php
                            if(isset($_GET["error"])){
                                if ($_GET["error"] == "invalidName") {
                                    echo "<div style='margin-left:50px;color:red;font-weight:600'>firstname / lastname cannot have digit(s)</div>";
                                }
                            }
                        ?>
                    </div>
                    <div class="userData">
                        <label>Last name</label>
                        <input type="text" name="lastName" value="<?php echo $_SESSION['userLastName']; ?>" required>
                        <?php
                            if(isset($_GET["error"])){
                                if ($_GET["error"] == "invalidName") {
                                    echo "<div style='margin-left:50px;color:red;font-weight:600'>firstname / lastname cannot have digit(s)</div>";
                                }
                            }
                        ?>
                    </div>
                    <div class="userData">
                        <label>Email</label>
                        <input type="text" name="email" value="<?php echo $_SESSION['userEmail']; ?>" disabled>
                        <?php
                            if(isset($_GET["error"])){
                                if ($_GET["error"] == "invalidEmail") {
                                    echo "<div style='margin-left:175px;color:red;font-weight:600'>inccorect email format</div>";
                                }
                            }
                        ?>
                    </div>
                    <div class="userData">
                        <label>User Role</label>
                        <input type="text" value="<?php echo $_SESSION['userRole']; ?>" disabled>
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