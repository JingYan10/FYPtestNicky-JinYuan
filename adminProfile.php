<?php
// Start the session
session_start();
?>
<?php
include_once 'header.php';
include_once 'includes/databaseHandler.inc.php';
?>

<!--link to css-->
<link rel="stylesheet" href="adminProfile.css">

<?php
$sql = "SELECT * FROM users where userEmail='$_SESSION[userEmail]'";
$result = mysqli_query($conn, $sql);
$resultCheck = mysqli_num_rows($result);
if ($resultCheck > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $_SESSION["userFirstName"] = $row['userFirstName'];
        $_SESSION["userLastName"] = $row['userLastName'];
        $_SESSION["userImage"] = $row['userImage'];
    }
} else {
    header("location: ../login.php?error=noUserProfile");
    exit();
}
?>

<!--Content Here-->

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

            <a href="user_profile_changePassword.php"><input type="button" value="Change Passsword" class="btnEditPassword"></a>
            <a href="user_profile_edit.php"><input type="button" class="btnEdit" value="Edit"></a>
            <a href="user_profile_ban.php"><input type="button" class="btnBan" value="Ban Users"></a>

            <br>
        </div>
    </div>
</div>

<!--footer-->
<?php
include_once 'footer.php';
?>

<!--javascript-->

<!--for backtotop()-->
<script>
    var btn = $('#button');

    $(window).scroll(function() {
        if ($(window).scrollTop() > 300) {
            btn.addClass('show');
        } else {
            btn.removeClass('show');
        }
    });

    btn.on('click', function(e) {
        e.preventDefault();
        $('html, body').animate({
            scrollTop: 0
        }, '300');
    });
</script>

<!--for toggleMenu()-->
<script>
    $(document).ready(function() {
        $(".menu-icon").click(function() {
            $("#Menuitems").fadeToggle(200);
        });

        var w = $(".container > .box-container > .box:first-child").width()
        $(".box:last-child").css({
            width: "" + w,
            flex: "none"
        })

    });

    $(window).bind("resize", function() {
        if ($(window).width() > 800)
            $("#Menuitems").css("display", "block");
        else
            $("#Menuitems").css("display", "none");
    });
</script>
</body>

</html>