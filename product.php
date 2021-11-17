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
    $resultCheck = mysqli_num_rows($result);

    $userEmail = $_SESSION["userEmail"];

    $sql2 = "SELECT * FROM cart where userEmail = '$userEmail'";
    $result2 = mysqli_query($conn2, $sql2);
    $resultCheck2 = mysqli_num_rows($result2);
    $b = array("");
    if ($resultCheck2 > 0) {

        while ($row2 = mysqli_fetch_assoc($result2)) {
           //if product that exist in cart, store into array with productID
            array_push($b, $row2['productID']);

            //print_r ($b);
            //echo "(from sql) product ID in cart : ".$row2['productID']."<br>";
        }
    } 
        if ($resultCheck > 0) {

                while ($row = mysqli_fetch_assoc($result)) {
                    if (in_array($row['productID'], $b)) {
                        echo "<div class='card2'>" . "<img style='width:100%'" . "src=" . $row['productImage'] . ">";
                        echo "<h1>" . $row['productName'] . "</h1>";
                        echo "<p class = 'price'" . ">" . "RM" . $row['productPrice'] . "</p>";
                        echo "<p>" . "Some text about the jeans. Super slim and comfy lorem ipsum lorem jeansum. Lorem jeamsun denim lorem jeansum" . "</p>";
                        $productdata = "productID=" . $row['productID'];
                        $productQuantity = "&productQuantity=" . $row['productQuantity'];
                        echo "<p>" . "<a href='includes/addToCart.inc.php?" . $productdata . $productQuantity . "'>" . "<button disabled class='btnAddToCartDisabled'>Add To Cart</button></a>" . "</p>";
                        echo "</div>";
                        //echo "cart found productID : ".$row['productID']."<br>";
                    } else {
                        echo "<div class='card2'>" . "<img style='width:100%'" . "src=" . $row['productImage'] . ">";
                        echo "<h1>" . $row['productName'] . "</h1>";
                        echo "<p class = 'price'" . ">" . "RM" . $row['productPrice'] . "</p>";
                        echo "<p>" . "Some text about the jeans. Super slim and comfy lorem ipsum lorem jeansum. Lorem jeamsun denim lorem jeansum" . "</p>";
                        $productdata = "productID=" . $row['productID'];
                        $productQuantity = "&productQuantity=" . $row['productQuantity'];
                        echo "<p>" . "<a href='includes/addToCart.inc.php?" . $productdata . $productQuantity . "'>" . "<button class='btnAddToCart'>Add To Cart</button></a>" . "</p>";
                        echo "</div>";
                        //echo "normal  productID : ".$row['productID']."<br>";
                    }
                }
            } else {
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