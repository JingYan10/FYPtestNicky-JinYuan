<?php
session_start();
$_SESSION["userFirstName"];
$_SESSION["userLastName"];
$_SESSION["userRole"]
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
    }
} else {
    header("location: ../login.php?error=noUserProfile");
    exit();
}


?>

<div class="main-container">
    <div class="userImage">
        <p>
            <img src="<?php echo $_SESSION['userImage'];?>" alt="">
        </p>
    </div>
    <div class="userInfocard">
        <div class="userInfo">
            <div class="userData">
                <label>First name</label>
                <input type="text" name="firstName"  value="<?php echo $_SESSION['userFirstName'];?>"  >
            </div>
            <div class="userData">
                <label>Last name</label>
                <input type="text" name="lastName"  value="<?php echo $_SESSION['userLastName'];?>"  >
            </div>
            <div class="userData">
                <label>Email</label>
                <input type="text" value="<?php echo $_SESSION['userEmail'];?>">
                
            </div>
            <div class="userData">
                <label>User Image</label>
                <input type="text" value="<?php echo $_SESSION['userImage'];?>">
            </div>
            <input type="text">
        </div>
    </div>
</div>



<?php
include_once 'footer.php';
?>



</body>

</html>