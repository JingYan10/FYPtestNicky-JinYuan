<?php
include_once 'header.php';
?>

<!--link to css-->
<link rel="stylesheet" href="signUp.css">

<!--content here-->

<section class="singUp-form">
    <div class="center">
        <h1>Sign Up</h1>
        <form action="includes/signUp.inc.php" method="post" enctype="multipart/form-data">
            <div class="txt_field">
                <input type="text" name="firstName" required>
                <span></span>
                <label>First name</label>
            </div>
            <div class="txt_field">
                <input type="text" name="lastName" required>
                <span></span>
                <label>Last name</label>
            </div>
            <div class="txt_field">
                <input type="text" name="email" required>
                <span></span>
                <label>Email</label>
            </div>
            <div class="txt_field">
                <input type="text" name="phoneNumber"  required>
                <span></span>
                <label>Phone number</label>
            </div>
            <div class="txt_field">
                <p>House address</p>
            <textarea rows="4" cols="33" name="houseAddress" class="houseAddress" required></textarea>
            </div>
            <div class="txt_field">
                <input type="password" name="password" required>
                <span></span>
                <label>Password</label>
            </div>
            <div class="txt_field">
                <input type="password" name="confirmPassword" required>
                <span></span>
                <label>Confirm password</label>
            </div>
            <div class="txt_field">
                <p>Profile picture</p>
                <input type="file" name="file" required>
            </div>
            <button class="button" type="submit" name="submit">Sign Up</button>
        </form>

        <?php
        if (isset($_GET["error"])) {
            if ($_GET["error"] == "emptyInput") {
                echo "<div style='text-align:center;color:red;font-weight:600'>fill up the blank space</div>";
            } else if ($_GET["error"] == "invalidName") {
                echo "<div style='text-align:center;color:red;font-weight:600'>firstname / lastname cannot have digit(s)</div>";
            } else if ($_GET["error"] == "invalidEmail") {
                echo "<div style='text-align:center;color:red;font-weight:600'>inccorect email format</div>";
            }else if ($_GET["error"] == "invalidPhoneNumber") {
                echo "<div style='text-align:center;color:red;font-weight:600'>inccorect phone number format</div>";
            }else if ($_GET["error"] == "mismatchPassword") {
                echo "<div style='text-align:center;color:red;font-weight:600'>password and confirm password are not matched</div>";
            } else if ($_GET["error"] == "existingUser") {
                echo "<div style='text-align:center;color:red;font-weight:600'>this email has registered before</div>";
            } else if ($_GET["error"] == "stmtFailed") {
                echo "<div style='text-align:center;color:red;font-weight:600'>something went wrong, please try again later</div>";
            } else if ($_GET["error"] == "imgType") {
                echo "<div style='text-align:center;color:red;font-weight:600'>inccorect image type, please upload  in (jpg/jpeg/png) format</div>";
            } else if ($_GET["error"] == "errorImgSize") {
                echo "<div style='text-align:center;color:red;font-weight:600'> image size too big, <br> please reupload smaller image size</div>";
            } else if ($_GET["error"] == "errorImgUpload") {
                echo "<div style='text-align:center;color:red;font-weight:600'> something went wrong while uploading image, please try again</div>";
            } else if ($_GET["error"] == "none") {
                header("location: login.php");
                exit();
            }
        }
        ?>
    </div>
</section>

<div class="removethis" style="margin-bottom: 900px;"></div>



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