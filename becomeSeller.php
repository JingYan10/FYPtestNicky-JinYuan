<?php
session_start();
if($_SESSION["sellerStatus"]=="pending"){
    header("location: ../user_profile.php");
    exit();
}
?>
<?php
include_once 'header.php';
?>

<!--link to css-->
<link rel="stylesheet" href="becomeSeller.css">

<!--content here-->

<section class="singUp-form">
    <div class="center">
        <h1>Become Seller</h1>
        <form action="includes/becomeSeller.inc.php" method="post" enctype="multipart/form-data">
            <div class="txt_field">
                <input type="text" name="IC" required>
                <span></span>
                <label>IC</label>
            </div>
            <div class="txt_field">
                <input type="text" name="fullName" required>
                <span></span>
                <label>Full name as per IC</label>
            </div>
            <div class="txt_field">
                <p>SSM document (only accept in .pdf format)</p>
                <input type="file" name="file" required>
            </div>
            <button class="button" type="submit" name="submit">Confirm</button>
        </form>

        <?php
        if (isset($_GET["error"])) {
            if ($_GET["error"] == "invalidIC") {
                echo "<div style='text-align:center;color:red;font-weight:600'>invalid IC</div>";
            } else if ($_GET["error"] == "invalidFullName") {
                echo "<div style='text-align:center;color:red;font-weight:600'>full name should not have spacing or numbers</div>";
            } else if ($_GET["error"] == "fileType") {
                echo "<div style='text-align:center;color:red;font-weight:600'>inccorect file type, please upload in pdf format only</div>";
            } else if ($_GET["error"] == "errorFileSize") {
                echo "<div style='text-align:center;color:red;font-weight:600'> file size too big, <br> please reupload the file with smaller size</div>";
            } else if ($_GET["error"] == "errorFileUpload") {
                echo "<div style='text-align:center;color:red;font-weight:600'> something went wrong while uploading file, please try again</div>";
            } else if ($_GET["error"] == "none") {
                header("location: user_profile.php");
                exit();
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