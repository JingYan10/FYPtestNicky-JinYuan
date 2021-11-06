<?php
session_start();
?>

<?php
include_once 'header.php';
?>

<!--link to css-->
<link rel="stylesheet" href="editProduct.css">

<!--content here-->

<?php
    if(isset($_GET["error"])){
        $_SESSION["productID"];
        $_SESSION["productName"];
        $_SESSION["productImage"];
        $_SESSION["productQuantity"];
        $_SESSION["productPrice"];
    }else{
        $_SESSION["productID"] = $_GET["productID"];
        $_SESSION["productName"] = $_GET["productName"];
        $_SESSION["productImage"] = $_GET["productImage"];
        $_SESSION["productQuantity"] = $_GET["productQuantity"];
        $_SESSION["productPrice"] = $_GET["productPrice"];
    }
    
?>


<section class="deleteProduct-form">
    <div class="center">
        <h1>Delete product</h1>
        <form action="includes/deleteProduct.inc.php" method="post" enctype="multipart/form-data">
            <div class="txt_field">
                <p>Product ID : <?php echo "P00".$_SESSION['productID']; ?></p>
            </div>
            <div class="txt_field">
                <p>Product Name : <?php echo $_SESSION['productName']; ?></p>
            </div>
            <div class="txt_field">
                <p>Product picture</p>
                <img style="width:140px;height:140px;" src="<?php echo $_SESSION['productImage']; ?>" alt="">
            </div>
            <div class="txt_field">
                <p>Product quantity : <?php echo $_SESSION['productQuantity']; ?></p>
            </div>
            <div class="txt_field">
                <p>Product price : <?php echo $_SESSION['productPrice']; ?></p>
            </div>
            <button class="button" type="submit" name="submit">Delete</button>
        </form>

        <?php
        // if (isset($_GET["error"])) {
        //     if ($_GET["error"] == "emptyInput") {
        //         echo "<div style='text-align:center;color:red;font-weight:600'>fill up the blank space</div>";
        //     } else if ($_GET["error"] == "invalidName") {
        //         echo "<div style='text-align:center;color:red;font-weight:600'>firstname / lastname cannot have digit(s)</div>";
        //     } else if ($_GET["error"] == "invalidEmail") {
        //         echo "<div style='text-align:center;color:red;font-weight:600'>inccorect email format</div>";
        //     } else if ($_GET["error"] == "mismatchPassword") {
        //         echo "<div style='text-align:center;color:red;font-weight:600'>password and confirm password are not matched</div>";
        //     } else if ($_GET["error"] == "existingUser") {
        //         echo "<div style='text-align:center;color:red;font-weight:600'>this email has registered before</div>";
        //     } else if ($_GET["error"] == "stmtFailed") {
        //         echo "<div style='text-align:center;color:red;font-weight:600'>something went wrong, please try again later</div>";
        //     } else if ($_GET["error"] == "imgType") {
        //         echo "<div style='text-align:center;color:red;font-weight:600'>inccorect image type, please upload  in (jpg/jpeg/png) format</div>";
        //     } else if ($_GET["error"] == "errorImgSize") {
        //         echo "<div style='text-align:center;color:red;font-weight:600'> image size too big, <br> please reupload smaller image size</div>";
        //     } else if ($_GET["error"] == "errorImgUpload") {
        //         echo "<div style='text-align:center;color:red;font-weight:600'> something went wrong while uploading image, please try again</div>";
        //     } else if ($_GET["error"] == "none") {
        //         header("location: login.php");
        //         exit();
        //     }
        // }
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