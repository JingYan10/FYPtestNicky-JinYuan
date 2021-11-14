<?php
// Start the session
session_start();
?>
<?php
include_once 'header.php';
?>
<!--link to css-->
<link rel="stylesheet" href="login.css">
<!--content here-->
<section class="login-form">

    <div class="center">
        <h1>Login</h1>
        <form action="includes/testing2.inc.php" method="post">

            <div class="txt_field">
                <input type="text" name="email" required>
                <span></span>
                <label>Email</label>
            </div>


            <select name="cars" id="cars">
                <option value="volvo">Volvo</option>
                <option value="saab">Saab</option>
                <option value="opel">Opel</option>
                <option value="audi">Audi</option>
            </select>

            <button class="button" type="submit" name="submit">Login</button>
            <div class="signUpLink">
                <p>Be our member, <a href="signUp.php">Sign Up</a> now !</p>
            </div>



        </form>



        <?php
        if (isset($_GET["error"])) {
            if ($_GET["error"] == "emptyInput") {
                echo "<div style='text-align:center;color:red;font-weight:600'>fill up the blank space</div>";
            } else if ($_GET["error"] == "wrongLogin") {
                echo "<div style='text-align:center;color:red;font-weight:600'>inccorect login</div>";
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