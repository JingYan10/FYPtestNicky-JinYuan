<?php
// Start the session
session_start();
?>
<?php
include_once 'header.php';
?>
<!--link to css-->
<link rel="stylesheet" href="forgetPassword.css">
<!--content here-->
<section class="forgetPassword-form">

    <div class="center">
        <h1>Password recovery</h1>
        <form action="includes/forgetPassword.inc.php" method="post">

            <div class="txt_field">
                <input type="text" name="email" required>
                <span></span>
                <label>Email</label>
            </div>

            <button class="button" type="submit" name="submit">Submit</button>



        </form>



        <?php
        if (isset($_GET["error"])) {
            if ($_GET["error"] == "invalidExistUser") {
                echo "<div style='text-align:center;color:red;font-weight:600'>user doesn't exist</div>";
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