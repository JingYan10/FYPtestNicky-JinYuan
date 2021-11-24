<?php
session_start();
include_once 'header.php';
include_once 'includes/functions.inc.php';

?>
<link rel="stylesheet" href="header&footer.css">
<link rel="stylesheet" href="payment.css">
<script src="https://www.paypal.com/sdk/js?client-id=AeVGLPsUt-ACbymXZlhlEgDq1yWTka3VFj5pEX5QrsSJX5bHf1rjSA88SbI2YKWImMRpgPouhAjnJCwF">
    // Required. Replace YOUR_CLIENT_ID with your sandbox client ID.
</script>



<!--content here-->
<h1>Page Header</h1>
<div class="container">
    <form method="POST" action="buyProduct.inc.php" autocomplete="off">
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
                            <input type="hidden" name="cart[<?= $productID ?>]['id']" value="<?= $productID ?>">
                        </div>
                        <div class='product-details'>
                            <div class='product-title'><?= $row['productName'] ?></div>
                        </div>
                        <div class='product-price' id='pprice'><?= $row['productPrice'] ?>
                            <input type='hidden' class="hiddenLinePrice" name="cart[<?= $productID ?>]['product-line-price']" value="0">
                            <input type='hidden' name="cart[<?= $productID ?>]['unit_price']" value="<?= $row['productPrice'] ?>">
                        </div>
                        <div class='product-quantity' id='pquantity'>
                            <input type='number' value='1' min='1' name="cart[<?= $productID ?>]['qty']" max='<?= $productQuantity ?>'>
                        </div>
                        <div class='product-removal'>
                            <a href='includes/removeFromCart.inc.php?productID=<?= $productID ?>'><button type="button">Delete</button></a>

                        </div>

                        <div class='product-line-price'>
                        </div>
                    </div>
            <?php
                    $arrayPaymentData['productID'][] = $row['productID'];
                    $arrayPaymentData['productQuantity'][] = $row['productQuantity'];
                } else {
                }
            }
            ?>

            <div class="totals">
                <div class="totals-item">

                    <div class="totals-item totals-item-total">
                        <label>Grand Total</label>
                        <div class="totals-value" id="cart-total"></div>
                    </div>
                </div>
                <input type="hidden" name="grandTotal" id="grandTotalHidden" value="0">
                <input type="hidden" name="paymentID" value="<?= $paymentData ?>">
                <!-- <a href="payment.php" class="checkout" button type="submit">Checkout</button></a> -->

            </div>
        </div>
    </form>
    <div id="paypal-button-container"></div>
</div>








<script>
    $(function() {
        paypal.Buttons({
            style: {
                layout: 'vertical',
                color: 'blue',
                shape: 'rect',
                label: 'paypal'
            },
        }).render('#paypal-button-container');
    })


    function pay() {
        var total = $('#grandTotalHidden').val();
        console.log("test");

        paypal.Buttons({
            createOrder: function(data, actions) {
                // This function sets up the details of the transaction, including the amount and line item details.
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: total
                        }
                    }]
                });
            },
            onApprove: function(data, actions) {
                // This function captures the funds from the transaction.
                return actions.order.capture().then(function(details) {
                    // This function shows a transaction success message to your buyer.
                    console.log(details);

                    if (details.status == 'success') {
                        // ajax update product 
                        // ajax update cart
                        // payment status
                    }
                    alert('Transaction completed by ' + details.payer.name.given_name);
                });
            }
        });
    }
</script>


<?php

// require_once 'includes/databaseHandler.inc.php';
// require_once 'includes/functions.inc.php';


// echo "friendCode : " . generateFriendCode($conn);
?>
<?php
include_once 'footer.php';
?>



</body>

</html>