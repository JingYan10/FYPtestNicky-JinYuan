<?php
// Start the session
session_start();
?>
<?php
include_once 'header.php';
include_once 'includes/databaseHandler.inc.php';
include_once 'includes/functions.inc.php';
?>

<!--link to css-->
<link rel="stylesheet" href="wishlist.css">






<!--content here-->
<div class="Main-Container">

    <div class="CartContainer">
        <div class="column-labels">

        </div>

        <?php

        $a = array("");
        $userEmail = $_SESSION["userEmail"];

        $sql = "SELECT * FROM wishlist where userEmail = '$userEmail'";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);

        $sql2 = " SELECT * FROM product";
        $result2 = mysqli_query($conn2, $sql2);
        $resultCheck2 = mysqli_num_rows($result2);

        if ($resultCheck > 0) { //wishlist loop
            while ($row = mysqli_fetch_assoc($result)) {
                array_push($a, $row['productID']);
                // $productID = $row['productID'];
            }
        }else {
            header("location: product.php?error=noWishList");
            exit();
        }
        if ($resultCheck2 > 0) { //product loop
            while ($row2 = mysqli_fetch_assoc($result2)) {
                if (in_array($row2['productID'], $a)) {
                    $productImage = $row2['productImage'];
                    $productName = $row2['productName'];
                    $productPrice = $row2['productPrice'];
                    $twoDecimalPrice = number_format((float)$productPrice, 2, '.', '');;
                    echo "<div class='product'>";
                    echo "<div class='product-image'>";
                    echo "<img src='$productImage'>";
                    echo "</div>";
                    echo "<div class='product-details'>";
                    echo "<div class='product-title'> $productName </div>";
                    echo "</div>";
                    echo "<div class='product-price' id='price'>$twoDecimalPrice </div>";
                    echo "<div class='product-removal'>";
                    $productData = "productID=" . $row2['productID'] . "&productQuantity=1&wishlist=yes";
                    echo "<a href='includes/wishlistAddtoCart.inc.php?$productData'><button>Add to cart</button></a>";
                    echo "</div>";
                    echo "</div>";
                }
            }
        } 

        ?>


    </div>

    <!-- <div id="paypal-button-container"></div> -->

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