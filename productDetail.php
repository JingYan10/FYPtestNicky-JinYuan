<?php
// Start the session
session_start();
?>

<?php
include_once 'header.php';
require_once 'includes/functions.inc.php';
?>

<link rel="stylesheet" href="productDetail.css">
<!--FAQ content-->

<?php
if (isset($_GET["productID"])) {
    $productID  = $_GET["productID"];
    $wishlist = $_GET["wishlist"];
    $cart = $_GET["cart"];
    $sql = "SELECT * FROM rating where productID='$productID'";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    $totalRating = 0;
    $totalRatingCount = 0;
    $star1 = 0;
    $star2 = 0;
    $star3 = 0;
    $star4 = 0;
    $star5 = 0;
    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {

            //for rating
            if ($row["ratingNO"] == "1") {
                $star1++;
            } else if ($row["ratingNO"] == "2") {
                $star2++;
            } else if ($row["ratingNO"] == "3") {
                $star3++;
            } else if ($row["ratingNO"] == "4") {
                $star4++;
            } else if ($row["ratingNO"] == "5") {
                $star5++;
            }
            $totalRating += (int) $row["ratingNO"];
            $totalRatingCount++;
        }
    }
    $finalRating = 0;
    if ($totalRating != 0 || $totalRatingCount != 0) {
        $finalRating = round($totalRating / $totalRatingCount);
    }

    // echo "total rating = " . $totalRating . "<br>";
    // echo "total rating count = " . $totalRatingCount . "<br>";
    // echo "final rating result = " . $finalRating . "<br>";
    // echo "star1 result = " . $star1 . "<br>";
    // echo "star2 result = " . $star2 . "<br>";
    // echo "star3 result = " . $star3 . "<br>";
    // echo "star4 result = " . $star4 . "<br>";
    // echo "star5 result = " . $star5 . "<br>";

    $dataPoints = array(
        array("y" => $star1, "label" => "1 star"),
        array("y" => $star2, "label" => "2 star"),
        array("y" => $star3, "label" => "3 star"),
        array("y" => $star4, "label" => "4 star"),
        array("y" => $star5, "label" => "5 star")
    );

    $sql = "SELECT * FROM product where productID='$productID'";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $_SESSION["productName"] = $row['productName'];
            $_SESSION["productImage"] = $row['productImage'];
            $_SESSION["productQuantity"] = $row['productQuantity'];
            $_SESSION["productPrice"] = $row['productPrice'];
        }
        $productName = $_SESSION["productName"];
        $productImage = $_SESSION["productImage"];
        $productQuantity = $_SESSION["productQuantity"];
        $productPrice = $_SESSION["productPrice"];
    }
}


?>

<div class="container">



    <div class="spacing-top" style="height:1500px;"></div>

    <div class="card">
        <nav>
            <a href="product.php">
                <svg class="arrow" version="1.1" viewBox="0 0 512 512" width="512px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <polygon points="352,115.4 331.3,96 160,256 331.3,416 352,396.7 201.5,256 " stroke="#727272" />
                </svg>
                <p style="float: left;">Back to products</p>
            </a>
        </nav>
        <div class="photo">
            <?php echo "<img " . "src=" . $productImage . ">"; ?>
        </div>
        <div class="description">
            <h2><?php echo $productName ?></h2>
            <h1>RM <?php echo $productPrice ?></h2>
                <?php
                echo productRatingResult($finalRating);
                ?>
                <p>Classic Peace Lily is a spathiphyllum floor plant arranged in a bamboo planter with a blue & red ribbom and butterfly pick.</p>
                <?php
                $productdata = "productID=" . $productID;
                if($wishlist == "exist"&&$cart == "exist"){
                    echo  "<a href='includes/addToWishlist.inc.php?" . $productdata . $productQuantity . "'>" . "<button disabled class='btnAddToWishlist'>Add To Wishlist</button></a>" ;
                    echo  "<a href='includes/addToCart.inc.php?" . $productdata . $productQuantity . "'>" . "<button disabled class='btnAddToCart'>Add To Cart</button></a>";
                } else if ($wishlist == "empty"&&$cart == "exist"){
                    echo  "<a href='includes/addToWishlist.inc.php?" . $productdata . $productQuantity . "'>" . "<button class='btnAddToWishlist'>Add To Wishlist</button></a>" ;
                    echo  "<a href='includes/addToCart.inc.php?" . $productdata . $productQuantity . "'>" . "<button disabled class='btnAddToCart'>Add To Cart</button></a>";
                } else if ($wishlist == "exist" && $cart == "empty"){
                    echo  "<a href='includes/addToWishlist.inc.php?" . $productdata . $productQuantity . "'>" . "<button disabled class='btnAddToWishlist'>Add To Wishlist</button></a>" ;
                    echo  "<a href='includes/addToCart.inc.php?" . $productdata . $productQuantity . "'>" . "<button class='btnAddToCart'>Add To Cart</button></a>";
                } else if ($wishlist == "empty" && $cart == "empty"){
                    echo  "<a href='includes/addToWishlist.inc.php?" . $productdata . $productQuantity . "'>" . "<button class='btnAddToWishlist'>Add To Wishlist</button></a>" ;
                    echo  "<a href='includes/addToCart.inc.php?" . $productdata . $productQuantity . "'>" . "<button class='btnAddToCart'>Add To Cart</button></a>";
                }
               
                ?>
        </div>

        <hr>

        <div id="chartContainer" style="margin-top: 20px;height: 350px; width: 100%;"></div>
        <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

        <hr>
        <input type="hidden" name="productID" id="productID" value="<?php echo $productID ?>">


        <div class="comments" id="comments">
            <?php
            $sql = "SELECT * FROM comments where productID='$productID' LIMIT 2";
            $result = mysqli_query($conn, $sql);
            $resultCheck = mysqli_num_rows($result);
            if ($resultCheck > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='balloon balloon--primary'>";
                    echo "<div class='balloon__inner'>";
                    echo $row['userEmail'];
                    echo "<br>";
                    echo $row['productComment'];
                    echo "</div>";
                    echo "</div>";
                }
            }
            ?>


        </div>

        <button class="btnViewMore">view more</button>

    </div>


</div>
<?php
include_once 'footer.php';
?>

<!--for faq()-->
<script>
    var acc = document.getElementsByClassName("accordion");
    var i;

    for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var panel = this.nextElementSibling;
            if (panel.style.display === "block") {
                panel.style.display = "none";
            } else {
                panel.style.display = "block";
            }
        });
    }
</script>
<script>
    window.onload = function() {

        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            title: {
                text: "User rating"
            },
            axisY: {
                includeZero: true,
            },
            data: [{
                type: "bar",
                yValueFormatString: "",
                indexLabel: "{y}",
                indexLabelPlacement: "inside",
                indexLabelFontWeight: "bolder",
                indexLabelFontColor: "white",
                dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();

    }
</script>
<script>
    $(document).ready(function() {
        var commentCount = 2;
        $("button").click(function() {
            commentCount += 2;
            $("#comments").load("includes/loadComments.inc.php", {
                commentNewCount: commentCount,
                productID: $('#productID').val()
            });
        });
    });
</script>

</body>

</html>