<?php
// Start the session
session_start();
?>
<?php
include_once 'header.php';
include_once 'includes/databaseHandler.inc.php';
?>

<!--link to css-->
<link rel="stylesheet" href="cart.css">

<!--content here-->
<div class="Main-Container">
    <div class="CartContainer">
        <div class="Header">
            <h3 class="Heading">Shopping Cart</h3>
            <h5 class="Action">Remove all</h5>
        </div>

    <?php


        $sql = " SELECT * FROM product ";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);

        $userEmail = $_SESSION["userEmail"];

        $sql2 = "SELECT * FROM cart where userEmail = '$userEmail'";
        $result2 = mysqli_query($conn2, $sql2);
        $resultCheck2 = mysqli_num_rows($result2);
        $c = array("");

        if ($resultCheck2 > 0) {

            while ($row2 = mysqli_fetch_assoc($result2)) {
               //if product that exist in cart, store into array with productID
                array_push($c, $row2['productID']);
    
                //print_r ($b);
                //echo "(from sql) product ID in cart : ".$row2['productID']."<br>";
            }
        } else {
            echo "No product is found!";
        }

         if ($resultCheck > 0) {
             
         }while($row = mysqli_fetch_assoc($result)){

            if (in_array($row['productID'], $c)){ 
                echo "<div class = 'Cart-Items'>";
                echo "<div class = 'image-box'>". "<img src = " . $row['productImage'] . ">";
                echo "</div>";
                echo "<div class = 'about'>";
                echo "<h1 class = 'title'>" . $row['productName']. "</h1>";
                // echo "<h3 class = 'subtitle'>" . 
                echo "</div>";
                echo "<div class = 'counter'>"; 
                echo "<div class = 'btnSub'>-</div>";
                echo "<div class = 'count'>" . $row['productQuantity'] . "</div>";
                echo "<div class = 'btnAdd'>+</div>";
                echo "</div>";
                echo "<div class = prices'>";
                echo "<div class = 'amount'>" . $row['productPrice'] . "</div>";
                echo "<div class = 'remove'><u>Remove</u></div>";
                echo "</div>";
                echo "</div>";
            } else{

            }
        }

    ?>


        <!-- <div class="Cart-Items">
            <div class="image-box">
                <img src="images/products/noodles3.jpg" height="120px" }} />
            </div>
            <div class="about">
                <h1 class="title">Noodles</h1>
                <h3 class="subtitle">250ml</h3>

            </div>
            <div class="counter">
                <div class="btn">+</div>
                <div class="count">2</div>
                <div class="btn">-</div>
            </div>
            <div class="prices">
                <div class="amount">$2.99</div>
                <div class="save"><u>Save for later</u></div>
                <div class="remove"><u>Remove</u></div>
            </div>
        </div> -->

        <hr>
        <div class="checkout">
            <div class="total">
                <div>
                    <div class="Subtotal">Sub-Total</div>
                    <div class="items">2 items</div>
                </div>
                <div class="total-amount">$6.18</div>
            </div>
            <button class="button">Checkout</button>
        </div>
    </div>
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