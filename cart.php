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
    <form method="POST" action="payment.php" autocomplete="off">
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
                echo "<script> window.history.back(); </script>";
                // echo "<script>alert('There is no item in cart!')</script>";
            }

            if ($resultCheck > 0) {
            }

            $totalPrice = 0;
            while ($row = mysqli_fetch_assoc($result)) {

                $productQuantity = $row['productQuantity'];
                $productID = $row['productID'];

                //problem : the buttons 
                if (in_array($row['productID'], $c)) {

                    $totalPrice += $row['productPrice'];
            ?>
                    <div class='product'>
                        <div class='product-image'>
                            <img src="<?= $row['productImage'] ?>">
                            <input type="hidden" name="cart[<?= $productID ?>][id]" value="<?= $productID ?>">
                        </div>
                        <div class='product-details'>
                            <div class='product-title'><?= $row['productName'] ?></div>
                        </div>
                        <div class='product-price' id='pprice'><?= $row['productPrice'] ?>
                            <input type='hidden' class="hiddenLinePrice" name="cart[<?= $productID ?>][product-line-price]" value="0">
                            <input type='hidden' name="cart[<?= $productID ?>][unit_price]" value="<?= $row['productPrice'] ?>">
                        </div>
                        <div class='product-quantity' id='pquantity'>
                            <input type='number' value='1' min='1' name="cart[<?= $productID ?>][qty]" max='<?= $productQuantity ?>'>
                        </div>
                        <div class='product-removal'>
                            <a href='includes/removeFromCart.inc.php?productID=<?= $productID ?>'><button type="button">Delete</button></a>

                        </div>

                        <div class='product-line-price'>
                            <?= $row['productPrice'] ?>
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
                        <div class="totals-value" id="cart-total"><?= $totalPrice?></div>
                    </div>
                </div>
                <input type="hidden" name="grandTotal" id="grandTotalHidden" value="0">
                <input type="hidden" name="paymentID" id="paymentID" value= >
                
                <button class="checkout" button type="submit">Checkout</button>
            </div>
        </div>
    </form>
    <!-- <div id="paypal-button-container"></div> -->
    <!-- <div id="paypal-button-container"></div> -->

</div>

<!-- <input type="hidden" name="paymentID" value="<?//= json_encode($arrayPaymentData) ?>"> -->


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

    // function changeQuantity(a) {
    //     var inputQty = $(a).val();
    //     var productQuantity = $(a).attr("max");
    //     var productID = $(a).attr("id");
    //     var qty = productQuantity - inputQty;
    //     console.log(productID);

    //     $.ajax({
    //         url: 'includes/updateProduct.inc.php',
    //         type: 'post',
    //         data: {
    //             productID: productID,
    //             qty: qty
    //         },
    //         success: function(result) {

    //         }

    //     })
    // }

    // $(function() {
    //     paypal.Buttons({
    //         style: {
    //             layout: 'vertical',
    //             color: 'blue',
    //             shape: 'rect',
    //             label: 'paypal'
    //         },
    //     }).render('#paypal-button-container');
    // })

    
    // function pay() {
    //     // var total = $to;
        
    //     // console.log (total);
    //     // var total = $('#grandTotalHidden').val();
        
    //     paypal.Buttons({
    //         createOrder: function(data, actions) {
    //             // This function sets up the details of the transaction, including the amount and line item details.
    //             return actions.order.create({
    //                 purchase_units: [{
    //                     amount: {
    //                         value: total
    //                     }
    //                 }]
    //             });
    //         },
    //         onApprove: function(data, actions) {
    //             // This function captures the funds from the transaction.
    //             return actions.order.capture().then(function(details) {
    //                 // This function shows a transaction success message to your buyer.
    //                 console.log(details);

    //                 if (details.status == 'success') {
    //                     // ajax update product 
    //                     // ajax update cart
    //                     // payment status
    //                 }
    //                 alert('Transaction completed by ' + details.payer.name.given_name);
    //             });
    //         }
    //     });
    // }
</script>

</script>

</body>

</html>