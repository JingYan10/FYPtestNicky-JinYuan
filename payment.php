<?php
session_start();
include_once 'header.php';
include_once 'includes/functions.inc.php';

?>
<link rel="stylesheet" href="header&footer.css">
<link rel="stylesheet" href="payment.css">

<?php

// echo '<pre>';
// print_r($_POST);
// echo '<pre>';
// die();


$price = $_POST['grandTotal'];
$_SESSION['price'] = $price;


?>


<script src="https://www.paypal.com/sdk/js?client-id=AeVGLPsUt-ACbymXZlhlEgDq1yWTka3VFj5pEX5QrsSJX5bHf1rjSA88SbI2YKWImMRpgPouhAjnJCwF">
    // Required. Replace YOUR_CLIENT_ID with your sandbox client ID.
</script>



<!--content here-->

    <h1>Thank you! Please proceed to PayPal by click the button below.</h1>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>

    <div class="container">

        <div id="paypal-button-container"></div>
    </div>

    <script>
        $(function() {
            console.log('<?= json_encode($_POST) ?>');
            paypal.Buttons({
                style: {
                    layout: 'vertical',
                    color: 'blue',
                    shape: 'rect',
                    label: 'paypal'
                },
                createOrder: function(data, actions) {
                    // This function sets up the details of the transaction, including the amount and line item details.
                    return actions.order.create({
                        purchase_units: [{
                            amount: {
                                value: '<?= $price ?>'
                            }
                        }]
                    });
                },
                onApprove: function(data, actions) {
                    // This function captures the funds from the transaction.
                    return actions.order.capture().then(function(details) {
                        // This function shows a transaction success message to your buyer.
                        console.log(details);

                        if (details.status == 'COMPLETED') {

                            // function changeQuantity(a) {



                            // var inputQty = $(a).val();
                            // var productQuantity = $(a).attr("max");
                            // var productID = $(a).attr("id");
                            // var qty = productQuantity - inputQty;
                            // console.log(productID);

                            $.ajax({
                                url: 'includes/updateProduct.inc.php',
                                type: 'post',
                                data: {
                                    product: '<?= json_encode($_POST) ?>',
                                    // qty: qty
                                },
                                success: function(result) {

                                }

                            })
                            //}
                            // ajax update cart

                            // $(document).ready(function() {
                            //     var removeAllFromCart = "includes/removeAllFromCart.inc.php";
                            //     // $('#content').click(function() {
                            //         $('#content').load(removeAllFromCart);
                            //     // });

                            //     // pls i beg u just fucking go to removeAllFromCart.php

                            // });

                        } else {
                            $.ajax({
                                url: 'includes/MakePaymentOnFail.inc.php',
                                type: 'post',
                                data: {
                                    product: '<?= json_encode($_POST) ?>',
                                    // qty: qty
                                },
                                success: function(result) {

                                }

                            })
                        }
                        alert('Transaction completed by ' + details.payer.name.given_name);
                    });
                }
            }).render('#paypal-button-container');
        })


        function pay() {
            var total = $('#grandTotalHidden').val();

            paypal.Buttons({

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