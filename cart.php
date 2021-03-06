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
<link rel="stylesheet" href="cart.css">

<!-- <script src="https://www.paypal.com/sdk/js?client-id=AeVGLPsUt-ACbymXZlhlEgDq1yWTka3VFj5pEX5QrsSJX5bHf1rjSA88SbI2YKWImMRpgPouhAjnJCwF">
    // Required. Replace YOUR_CLIENT_ID with your sandbox client ID.
</script> -->






<!--content here-->
<div class="Main-Container">
    <form method="POST" action="payment.php" autocomplete="off" id="cartForm">
        <div class="CartContainer">
            <div class="column-labels">
                <label class="product-image">Image</label>
                <label class="product-details">Product</label>
                <label class="product-price">Price</label>
                <label class="product-quantity">Quantity</label>
                <label class="product-removal">Remove</label>
                <label class="product-line-price">Total</label>
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

            $arrayPaymentData = array();

            if ($resultCheck2 > 0) {

                while ($row2 = mysqli_fetch_assoc($result2)) {
                    //if product that exist in cart, store into array with productID
                    array_push($c, $row2['productID']);

                    //print_r ($b);
                    //echo "(from sql) product ID in cart : ".$row2['productID']."<br>";
                }
            } else {
                echo "<script> alert('There is no item in cart!'); window.location.href = \"http://localhost/testing-fyp-2/product.php\"; </script>";
            }

            if ($resultCheck > 0) {
            }

            $totalPrice = 0;
            while ($row = mysqli_fetch_assoc($result)) {

                $productQuantity = $row['productQuantity'];
                $productPrice = $row['productPrice'];
                $promotionPrice = $row['promotionPrice'];
                $productID = $row['productID'];

                //problem : the buttons 
                if (in_array($row['productID'], $c)) {

                    if (!empty($row['promotionPrice'])) {

                        $totalPrice += $row['promotionPrice'];

                    } else {

                        $totalPrice += $row['productPrice'];
                        
                    }
            ?>
                    <div class='product'>
                        <div class='product-image'>
                            <img src="<?= $row['productImage'] ?>">
                            <input type="hidden" name="cart[<?= $productID ?>][id]" value="<?= $productID ?>">
                        </div>
                        <div class='product-details'>
                            <div class='product-title'><?= $row['productName'] ?></div>
                        </div>
                        <?php
                        if (!empty($row['promotionPrice'])) {
                            echo "<div class='product-price' id='pprice'>" . $row['promotionPrice'];
                        } else {
                            echo "<div class='product-price' id='pprice'>" . $row['productPrice'];
                        }
                        ?>



                        <?php
                        if (!empty($row['promotionPrice'])) {
                            echo "<input type='hidden' class=\"hiddenLinePrice\" name=\"cart[$productID][product-line-price]\" value=\"" . $row['promotionPrice'] . "\">";
                        } else {
                            echo "<input type='hidden' class=\"hiddenLinePrice\" name=\"cart[$productID][product-line-price]\" value=\"" . $row['productPrice'] . "\">";
                        }
                        ?>


                    </div>
                    <div class='product-quantity' id='pquantity'>
                        <input type='number' value='1' min='1' name="cart[<?= $productID ?>][qty]" max='<?= $productQuantity ?>'>
                    </div>
                    <div class='product-removal'>
                        <a href='includes/removeFromCart.inc.php?productID=<?= $productID ?>'><button type="button">Delete</button></a>
                    </div>

                    <div class='product-line-price'>
                        <?php
                        if (!empty($row['promotionPrice'])) {

                            echo $row['promotionPrice'];
                        } else {

                            echo $row['productPrice'];
                        }
                        ?>
                    </div>
        </div>
<?php
                    // $arrayPaymentData['productID'][] = $row['productID'];
                    // $arrayPaymentData['productQuantity'][] = $row['productQuantity'];
                } else {
                }
            }

            // $_SESSION["arrayPaymentData"] = $arrayPaymentData;

?>

<div class="totals">
    <div class="totals-item">

        <div class="totals-item totals-item-total">
            <label>Grand Total</label>
            <div class="totals-value" id="cart-total"><?= $totalPrice ?></div>
        </div>
    </div>
    <input type="hidden" name="grandTotal" id="grandTotalHidden" value="<?= $totalPrice ?>">
    <input type="hidden" name="paymentID" id="paymentID" value=>

    <button class="checkout" button type="button" onclick="calculateTotal()">Checkout</button>
</div>
</div>
</form>
<!-- <div id="paypal-button-container"></div> -->
<!-- <div id="paypal-button-container"></div> -->

</div>

<!-- <input type="hidden" name="paymentID" value="<? //= json_encode($arrayPaymentData) 
                                                    ?>"> -->


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

<script>
    /* Set rates + misc */
    var fadeTime = 300;


    /* Assign actions */
    $('.product-quantity input').change(function() {
        updateQuantity(this);
    });

    $('.product-removal button').click(function() {
        removeItem(this);
    });



    /* Recalculate cart */
    function recalculateCart() {
        var subtotal = 0;

        /* Sum up row totals */
        $('.product').each(function() {
            subtotal += parseFloat($(this).children('.product-line-price').text());
        });

        /* Calculate totals */
        var total = subtotal;

        /* Update totals display */
        $('.totals-value').fadeOut(fadeTime, function() {
            $('#cart-subtotal').html(subtotal.toFixed(2));
            $('#cart-total').html(total.toFixed(2));
            if (total == 0) {
                $('.checkout').fadeOut(fadeTime);
            } else {
                $('.checkout').fadeIn(fadeTime);
            }
            $('.totals-value').fadeIn(fadeTime);
        });

        $('#grandTotalHidden').val(total);


        // return total;
    }


    /* Update quantity */
    function updateQuantity(quantityInput) {
        /* Calculate line price */
        var productRow = $(quantityInput).parent().parent();
        var price = parseFloat(productRow.children('.product-price').text());
        var quantity = $(quantityInput).val();

        // if (!empty($row['promotionPrice'])) {

        //    var linePrice = $row['promotionPrice'];
        //    var linePrice = price * quantity;
        // } else {
        //     var linePrice = $row['productPrice'];
        //     var linePrice = price * quantity;
        // }
        var linePrice = price * quantity;


        /* Update line price display and recalc cart totals */
        productRow.children('.product-line-price').each(function() {
            $(this).fadeOut(fadeTime, function() {
                $(this).text(linePrice.toFixed(2));
                recalculateCart();
                $(this).fadeIn(fadeTime);
            });
        });

        productRow.children('.hiddenLinePrice').each(function() {
            $(this).val(linePrice.toFixed(2));

        });
    }

    function calculateTotal() {
        var grandTotal = $('#grandTotalHidden').val();

        if (grandTotal >= 1) {
            $('#cartForm').submit();
        }
    }
</script>

</script>

</body>

</html>