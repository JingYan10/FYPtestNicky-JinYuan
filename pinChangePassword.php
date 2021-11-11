<?php
// Start the session
session_start();
?>
<?php
include_once 'header.php';
?>
<!--link to css-->
<link rel="stylesheet" href="pinChangePassword.css">
<!--content here-->
<section class="forgetPassword-form">

    <div class="center">
        <h1>Password recovery</h1>
        <form action="includes/pinChangePassword.inc.php" method="post">

            <div class="txt_field">
                <input type="password" name="newPassword" required>
                <span></span>
                <label>New Password</label>
            </div>
            <div class="txt_field">
            <input type="password" name="confirmPassword" required>
                <span></span>
                <label>ConfirmPassword</label>
            </div>
            <button class="button" type="submit" name="submit">Submit</button>

        </form>



        <?php
        if (isset($_GET["error"])) {
            if ($_GET["error"] == "mismatchPassword") {
                echo "<div style='text-align:center;color:red;font-weight:600'>password and confirm password are not match</div>";
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