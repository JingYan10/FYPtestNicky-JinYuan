<?php
// Start the session
session_start();
?>
<?php
include_once 'header.php';
include_once 'includes/databaseHandler.inc.php';
?>

<!--link to css-->
<link rel="stylesheet" href="product.css">

<?php
$sql = "SELECT * FROM product where productQuantity > 0";
$result = mysqli_query($conn, $sql);
$resultCheck = mysqli_num_rows($result);
if ($resultCheck > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $_SESSION["productName"] = $row['productName'];
        $_SESSION["productImage"] = $row['productImage'];
        $_SESSION["productQuantity"] = $row['productQuantity'];
        $_SESSION["productPrice"] = $row['productPrice'];
    }
} else {
    header("location: ../product.php?error=noProductProfile");
    exit();
}
?>

<!--content here-->
<h1>Product Page</h1>
<div class="new-product-container2">

    <?php
            $sql = " SELECT * FROM product where productQuantity > 0";
            $result = mysqli_query($conn, $sql);
            $reultCheck = mysqli_num_rows($result);
            
            if ($resultCheck > 0) {

                while ($row = mysqli_fetch_assoc($result)) {

                    echo "<div class='card2'>" . "<img style='width:100%'" . "src=" . $row['productImage'] . ">";
                    echo "<h1>" . $row['productName'] . "</h1>";
                    echo "<p class = 'price'". ">" ."RM" . $row['productPrice'] . "</p>";
                    echo "<p>" . "Some text about the jeans. Super slim and comfy lorem ipsum lorem jeansum. Lorem jeamsun denim lorem jeansum" ."</p>";
                    echo "<p>" . "<a href='includes/addToCart.inc.php?".$userData."'>". "<button class='btnAddToCart'>Add To Cart</button></a>". "</p>";
                    echo "</div>";
                }
            } else {
                echo "No product is found!";
            }
            ?>
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