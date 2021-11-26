<?php
session_start();
?>

<?php
include_once 'header.php';
?>

<!--link to css-->
<link rel="stylesheet" href="createPromotion.css">

<!--content here-->

<?php
if (isset($_GET["error"])) {
    $_SESSION["productID"];
    $_SESSION["productName"];
    $_SESSION["productImage"];
    $_SESSION["productQuantity"];
    $_SESSION["productPrice"];
} else {
    $_SESSION["productID"] = $_GET["productID"];
    $_SESSION["productName"] = $_GET["productName"];
    $_SESSION["productImage"] = $_GET["productImage"];
    $_SESSION["productQuantity"] = $_GET["productQuantity"];
    $_SESSION["productPrice"] = $_GET["productPrice"];
}
//dateTime validation
date_default_timezone_set("Asia/Kuala_Lumpur");
$mindate = date("Y-m-d");
$mintime = date("h:i");
$min = $mindate . "T" . $mintime;
$maxdate = date("Y-m-d", strtotime("+10 Days"));
$maxtime = date("h:i");
$max = $maxdate . "T" . $maxtime;

?>


<section class="createPromotion-form">
    <div class="center">
        <h1>Create Promotion</h1>
        <form action="includes/createPromotion.inc.php" method="post" enctype="multipart/form-data">

            <div class="txt_field">
                <p>Product ID : <?php echo "P00" . $_SESSION['productID']; ?></p>
            </div>
            <div class="txt_field">
                <p>Product name : <?php echo $_SESSION['productName']; ?></p>
            </div>
            <div class="txt_field">
                <p>Product picture</p>
                <img style="width:140px;height:140px;" src="<?php echo $_SESSION['productImage']; ?>" alt="">
            </div>
            <div class="txt_field">
                <p>promotion ending time</p>
                <input type="datetime-local" name="promotionEndingTime" min=<?php echo"$min"?> max=<?php echo"$max"?> required>
            </div>
            <div class="txt_field">
                <input type="text" name="promotionRate" required>
                <span></span>
                <label>promotion rate</label>
            </div>
            <button class="button" type="submit" name="submit">Create Promotion</button>
        </form>

        <?php
        if (isset($_GET["error"])) {
            if ($_GET["error"] == "invalidPromotionStartingPrice") {
                echo "<div style='text-align:center;color:red;font-weight:600'>Promotion starting price should only have digits</div>";
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