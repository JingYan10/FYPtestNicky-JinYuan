<?php
session_start();
include_once 'header.php';
?>

<!--link to css-->
<link rel="stylesheet" href="signUp.css">

<!--content here-->

<section class="singUp-form">
    <div class="center">
        <h1>New product</h1>
        <form action="includes/createProduct.inc.php" method="post" enctype="multipart/form-data">
            <div class="txt_field">
                <input type="text" name="productName" required>
                <span></span>
                <label>Product name</label>
            </div>
            <div class="txt_field">
                <input type="text" name="productQuantity" required>
                <span></span>
                <label>Product quantity</label>
            </div>
            <div class="txt_field">
                <input type="text" name="productPrice" required>
                <span></span>
                <label>Product price</label>
            </div>
            <div class="txt_field">
                <p>Product Image</p>
                <input type="file" name="file" required>
            </div>
            <button class="button" type="submit" name="submit">Create</button>
        </form>

        <?php
        if (isset($_GET["error"])) {
            if ($_GET["error"] == "invalidProductName") {
                echo "<div style='text-align:center;color:red;font-weight:600'>product name cannot have numbers</div>";
            } else if ($_GET["error"] == "invalidProductQuantity") {
                echo "<div style='text-align:center;color:red;font-weight:600'>product quantity cannot have alphabets or decimals</div>";
            } else if ($_GET["error"] == "invalidProductPrice") {
                echo "<div style='text-align:center;color:red;font-weight:600'>product price cannot have alphabets</div>";
            } else if ($_GET["error"] == "stmtFailed") {
                echo "<div style='text-align:center;color:red;font-weight:600'>something went wrong, please try again later</div>";
            } else if ($_GET["error"] == "imgType") {
                echo "<div style='text-align:center;color:red;font-weight:600'>inccorect image type, please upload  in (jpg/jpeg/png) format</div>";
            } else if ($_GET["error"] == "errorImgSize") {
                echo "<div style='text-align:center;color:red;font-weight:600'> image size too big, <br> please reupload smaller image size</div>";
            } else if ($_GET["error"] == "errorImgUpload") {
                echo "<div style='text-align:center;color:red;font-weight:600'> something went wrong while uploading image, please try again</div>";
            } else if ($_GET["error"] == "none") {
                echo "<div style='text-align:center;color:green;font-weight:600'>new product is created</div>";
            }
        }
        ?>
    </div>
</section>

<div class="removethis" style="margin-bottom: 700px;"></div>



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