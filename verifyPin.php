<?php
// Start the session
session_start();
?>
<?php
include_once 'header.php';
?>
<!--link to css-->
<link rel="stylesheet" href="verifyPin.css">
<!--content here-->
<section class="forgetPassword-form">

    <div class="center">
        <h1>Password recovery</h1>

        <form action="includes/verifyPin.inc.php" method="post">

            <div class="txt_field">
            <p style="margin-left: 4px;color:green;">pin code has sent to your email</p>
            </div>
            <div class="txt_field">
                
                <input type="text" name="pinCode" required>
                <span></span>
                <label>Pin Code</label>
            </div>

            <button class="button" type="submit" name="submit">Submit</button>

        </form>



        <?php
        if (isset($_GET["error"])) {
            if ($_GET["error"] == "pinNotMatch") {
                echo "<div style='text-align:center;color:red;font-weight:600'>incorrect pin</div>";
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