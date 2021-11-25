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
// echo $price;
// die();
?>


<script src="https://www.paypal.com/sdk/js?client-id=AeVGLPsUt-ACbymXZlhlEgDq1yWTka3VFj5pEX5QrsSJX5bHf1rjSA88SbI2YKWImMRpgPouhAjnJCwF">
    // Required. Replace YOUR_CLIENT_ID with your sandbox client ID.
</script>



<!--content here-->
<h1>Page Header</h1>
<div class="container">

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
            createOrder: function(data, actions) {
                // This function sets up the details of the transaction, including the amount and line item details.
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '<?=$price ?>'
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