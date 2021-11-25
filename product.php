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

    //rating 
    $star1 = 0;
    $star2 = 0;
    $star3 = 0;
    $star4 = 0;
    $star5 = 0;
    $totalRating = 0;
    $totalRatingCount = 0;

    $sql = " SELECT * FROM product where productQuantity > 0";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    $userEmail = $_SESSION["userEmail"];

    $sql2 = "SELECT * FROM cart where userEmail = '$userEmail'";
    $result2 = mysqli_query($conn2, $sql2);
    $resultCheck2 = mysqli_num_rows($result2);
    $b = array("");
    $c = array("");
    if ($resultCheck2 > 0) {

        while ($row2 = mysqli_fetch_assoc($result2)) {
            //if product that exist in cart, store into array with productID
            array_push($b, $row2['productID']);

            //print_r ($b);
            //echo "(from sql) product ID in cart : ".$row2['productID']."<br>";
        }
    }
    //check data from wishlist
    $sql2 = "SELECT * FROM wishlist where userEmail = '$userEmail'";
    $result2 = mysqli_query($conn2, $sql2);
    $resultCheck2 = mysqli_num_rows($result2);
    if ($resultCheck2 > 0) {

        while ($row2 = mysqli_fetch_assoc($result2)) {
            //if product that exist in wishlist, store into array with productID
            array_push($c, $row2['productID']);
        }
    }
    $d = array(""); // array for productID exist in rating
    if ($resultCheck > 0) { //loop product data
        //rating
        $propductID = "";
        while ($row = mysqli_fetch_assoc($result)) { // loop for rating with the productID from product data
            $productID = $row['productID'];// all product ID
            // echo $productID."<br>";
            
            $sql3 = "SELECT * FROM rating WHERE productID = '$productID'";
            $result3 = mysqli_query($conn2, $sql3);
            $resultCheck3 = mysqli_num_rows($result3);
            if ($resultCheck3 > 0) {
                
                while ($row2 = mysqli_fetch_assoc($result3)) {
                    array_push($d,$row["productID"]);
                    //for rating
                    if ($row2["ratingNO"] == "1") {
                        $star1++;
                    } else if ($row2["ratingNO"] == "2") {
                        $star2++;
                    } else if ($row2["ratingNO"] == "3") {
                        $star3++;
                    } else if ($row2["ratingNO"] == "4") {
                        $star4++;
                    } else if ($row2["ratingNO"] == "5") {
                        $star5++;
                    }
                    $totalRating += (float) $row2["ratingNO"];
                    $totalRatingCount++;
                }
            }
            $finalRating = 0;
            if ($totalRating != 0 || $totalRatingCount != 0) {
                $finalRating = $totalRating / $totalRatingCount;
            }  
            
            $arrayRatingProductID = array_values(array_filter(array_unique($d))); 

            if(in_array($row['productID'], $arrayRatingProductID)){ 
                //b = cart, c = wishlist
                if (in_array($row['productID'], $b) && in_array($row['productID'], $c)) {
                    $productdata = "productID=" . $row['productID'] . "&wishlist=exist&cart=exist";
                    $productQuantity = "&productQuantity=" . $row['productQuantity'];
                    echo  "<a href='productDetail.php?" . $productdata . "'>";
                    echo "<div class='card2'>" . "<img " . "src=" . $row['productImage'] . ">";
                    echo "<h1>" . $row['productName'] . "</h1>"; 
                    echo "<p class = 'price'" . ">" . "RM" . number_format((float)$row["productPrice"], 2, '.', '') . "</p>";
                    echo productRatingResult($finalRating);
                    echo "<p>" . "Some text about the jeans. Super slim and comfy lorem ipsum lorem jeansum. Lorem jeamsun denim lorem jeansum" . "</p>";
                    echo "<p>" . "<a href='includes/addToWishlist.inc.php?" . $productdata . $productQuantity . "'>" . "<button disabled class='btnAddToCartDisabled'>Add To Wishlist</button></a>" . "</p>";
                    echo "<p>" . "<a href='includes/addToCart.inc.php?" . $productdata . $productQuantity . "'>" . "<button disabled class='btnAddToCartDisabled'>Add To Cart</button></a>" . "</p>";
                    echo "</div>";
                    echo "</a>";
                } else if (in_array($row['productID'], $b)&&!in_array($row['productID'],$c)) {
                    $productdata = "productID=" . $row['productID'] . "&wishlist=exist&cart=empty";
                    $productQuantity = "&productQuantity=" . $row['productQuantity'];
                    echo  "<a href='productDetail.php?" . $productdata . "'>";
                    echo "<div class='card2'>" . "<img " . "src=" . $row['productImage'] . ">";
                    echo "<h1>" . $row['productName'] . "</h1>";
                    echo "<p class = 'price'" . ">" . "RM" . number_format((float)$row["productPrice"], 2, '.', '') . "</p>";
                    echo productRatingResult($finalRating);
                    echo "<p>" . "Some text about the jeans. Super slim and comfy lorem ipsum lorem jeansum. Lorem jeamsun denim lorem jeansum" . "</p>";
                    echo "<p>" . "<a href='includes/addToWishlist.inc.php?" . $productdata . $productQuantity . "'>" . "<button class='btnAddToWishlist'>Add To Wishlist</button></a>" . "</p>";
                    echo "<p>" . "<a href='includes/addToCart.inc.php?" . $productdata . $productQuantity . "'>" . "<button disabled class='btnAddToCartDisabled'>Add To Cart</button></a>" . "</p>";
                    echo "</div>";
                    echo "</a>";
                    //echo "cart found productID : ".$row['productID']."<br>";
                } else if (in_array($row['productID'], $c)&&!in_array($row['productID'],$b)) {
                    $productdata = "productID=" . $row['productID'] . "&wishlist=empty&cart=exist";
                    $productQuantity = "&productQuantity=" . $row['productQuantity'];
                    echo  "<a href='productDetail.php?" . $productdata . "'>";
                    echo "<div class='card2'>" . "<img " . "src=" . $row['productImage'] . ">";
                    echo "<h1>" . $row['productName'] . "</h1>";
                    echo "<p class = 'price'" . ">" . "RM" . number_format((float)$row["productPrice"], 2, '.', '') . "</p>";
                    echo productRatingResult($finalRating);
                    echo "<p>" . "Some text about the jeans. Super slim and comfy lorem ipsum lorem jeansum. Lorem jeamsun denim lorem jeansum" . "</p>";
                    echo "<p>" . "<a href='includes/addToWishlist.inc.php?" . $productdata . $productQuantity . "'>" . "<button disabled class='btnAddToCartDisabled'>Add To Wishlist</button></a>" . "</p>";
                    echo "<p>" . "<a href='includes/addToCart.inc.php?" . $productdata . $productQuantity . "'>" . "<button class='btnAddToCart'>Add To Cart</button></a>" . "</p>";
                    echo "</div>";
                    echo "</a>";
                } else if(!in_array($row['productID'], $c)&&!in_array($row['productID'],$b)) {
                    $productdata = "productID=" . $row['productID'] . "&wishlist=empty&cart=exist";
                    $productQuantity = "&productQuantity=" . $row['productQuantity'];
                    echo  "<a href='productDetail.php?" . $productdata . "'>";
                    echo "<div class='card2'>" . "<img " . "src=" . $row['productImage'] . ">";
                    echo "<h1>" . $row['productName']  . "</h1>";
                    echo "<p class = 'price'" . ">" . "RM" . number_format((float)$row["productPrice"], 2, '.', '') . "</p>";
                    echo productRatingResult($finalRating);
                    echo "<p>" . "Some text about the jeans. Super slim and comfy lorem ipsum lorem jeansum. Lorem jeamsun denim lorem jeansum" . "</p>";
                    echo "<p>" . "<a href='includes/addToWishlist.inc.php?" . $productdata . $productQuantity . "'>" . "<button class='btnAddToWishlist'>Add To Wishlist</button></a>" . "</p>";
                    echo "<p>" . "<a href='includes/addToCart.inc.php?" . $productdata . $productQuantity . "'>" . "<button class='btnAddToCart'>Add To Cart</button></a>" . "</p>";
                    echo "</div>";
                    echo "</a>";
                    //echo "normal  productID : ".$row['productID']."<br>";
                }
            }else{
                if (in_array($row['productID'], $b) && in_array($row['productID'], $c)) {
                    $productdata = "productID=" . $row['productID'] . "&wishlist=exist&cart=exist";
                    $productQuantity = "&productQuantity=" . $row['productQuantity'];
                    echo  "<a href='productDetail.php?" . $productdata . "'>";
                    echo "<div class='card2'>" . "<img " . "src=" . $row['productImage'] . ">";
                    echo "<h1>" . $row['productName']  . "</h1>";
                    echo "<p class = 'price'" . ">" . "RM" . number_format((float)$row["productPrice"], 2, '.', '') . "</p>";
                    echo productRatingResult(0);
                    echo "<p>" . "Some text about the jeans. Super slim and comfy lorem ipsum lorem jeansum. Lorem jeamsun denim lorem jeansum" . "</p>";
                    echo "<p>" . "<a href='includes/addToWishlist.inc.php?" . $productdata . $productQuantity . "'>" . "<button disabled class='btnAddToCartDisabled'>Add To Wishlist</button></a>" . "</p>";
                    echo "<p>" . "<a href='includes/addToCart.inc.php?" . $productdata . $productQuantity . "'>" . "<button disabled class='btnAddToCartDisabled'>Add To Cart</button></a>" . "</p>";
                    echo "</div>";
                    echo "</a>";
                } else if (in_array($row['productID'], $b)&&!in_array($row['productID'],$c)) {
                    $productdata = "productID=" . $row['productID'] . "&wishlist=exist&cart=empty";
                    $productQuantity = "&productQuantity=" . $row['productQuantity'];
                    echo  "<a href='productDetail.php?" . $productdata . "'>";
                    echo "<div class='card2'>" . "<img " . "src=" . $row['productImage'] . ">";
                    echo "<h1>" . $row['productName'] . "</h1>";
                    echo "<p class = 'price'" . ">" . "RM" . number_format((float)$row["productPrice"], 2, '.', '') . "</p>";
                    echo productRatingResult(0);
                    echo "<p>" . "Some text about the jeans. Super slim and comfy lorem ipsum lorem jeansum. Lorem jeamsun denim lorem jeansum" . "</p>";
                    echo "<p>" . "<a href='includes/addToWishlist.inc.php?" . $productdata . $productQuantity . "'>" . "<button class='btnAddToWishlist'>Add To Wishlist</button></a>" . "</p>";
                    echo "<p>" . "<a href='includes/addToCart.inc.php?" . $productdata . $productQuantity . "'>" . "<button disabled class='btnAddToCartDisabled'>Add To Cart</button></a>" . "</p>";
                    echo "</div>";
                    echo "</a>";
                    //echo "cart found productID : ".$row['productID']."<br>";
                } else if (in_array($row['productID'], $c)&&!in_array($row['productID'],$b)) {
                    $productdata = "productID=" . $row['productID'] . "&wishlist=empty&cart=exist";
                    $productQuantity = "&productQuantity=" . $row['productQuantity'];
                    echo  "<a href='productDetail.php?" . $productdata . "'>";
                    echo "<div class='card2'>" . "<img " . "src=" . $row['productImage'] . ">";
                    echo "<h1>" . $row['productName']  . "</h1>";
                    echo "<p class = 'price'" . ">" . "RM" . number_format((float)$row["productPrice"], 2, '.', '') . "</p>";
                    echo productRatingResult(0);
                    echo "<p>" . "Some text about the jeans. Super slim and comfy lorem ipsum lorem jeansum. Lorem jeamsun denim lorem jeansum" . "</p>";
                    echo "<p>" . "<a href='includes/addToWishlist.inc.php?" . $productdata . $productQuantity . "'>" . "<button disabled class='btnAddToCartDisabled'>Add To Wishlist</button></a>" . "</p>";
                    echo "<p>" . "<a href='includes/addToCart.inc.php?" . $productdata . $productQuantity . "'>" . "<button class='btnAddToCart'>Add To Cart</button></a>" . "</p>";
                    echo "</div>";
                    echo "</a>";
                } else if(!in_array($row['productID'], $c)&&!in_array($row['productID'],$b)) {
                    $productdata = "productID=" . $row['productID'] . "&wishlist=empty&cart=exist";
                    $productQuantity = "&productQuantity=" . $row['productQuantity'];
                    echo  "<a href='productDetail.php?" . $productdata . "'>";
                    echo "<div class='card2'>" . "<img " . "src=" . $row['productImage'] . ">";
                    echo "<h1>" . $row['productName'] . "</h1>";
                    echo "<p class = 'price'" . ">" . "RM" . number_format((float)$row["productPrice"], 2, '.', '') . "</p>";
                    echo productRatingResult(0);
                    echo "<p>" . "Some text about the jeans. Super slim and comfy lorem ipsum lorem jeansum. Lorem jeamsun denim lorem jeansum" . "</p>";
                    echo "<p>" . "<a href='includes/addToWishlist.inc.php?" . $productdata . $productQuantity . "'>" . "<button class='btnAddToWishlist'>Add To Wishlist</button></a>" . "</p>";
                    echo "<p>" . "<a href='includes/addToCart.inc.php?" . $productdata . $productQuantity . "'>" . "<button class='btnAddToCart'>Add To Cart</button></a>" . "</p>";
                    echo "</div>";
                    echo "</a>";
                    //echo "normal  productID : ".$row['productID']."<br>";
                }
            }
            $totalRating=0;
            $totalRatingCount=0;
            
        }
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