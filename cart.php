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

                // echo "<div class = 'Cart-Items'>";
                // echo "<div class = 'image-box'>" . "<img src = " . $row['productImage'] . ">";
                // echo "</div>";
                // echo "<div class = 'about'>";
                // echo "<h1 class = 'title'>" . $row['productName'] . "</h1>";
                // // echo "<h3 class = 'subtitle'>" . 
                // echo "</div>";
                // echo "<div class = 'counter'>";
                // echo "<div class = 'amount$productID'>" . $row['productPrice'] . "</div>";
                // // echo "<button class = 'btnSub' onclick = 'btnSub($productID)'>-</button>";
                // echo "<input type = number min = '1' max = '$productQuantity' id = 'quantity$productID' class = 'itemQty' value = '1'>";
                // // echo "</div>";
                // // echo "<button class = 'btnAdd' onclick = 'btnAdd($productID)'>+</button>";
                // echo "</div>";
                // echo "<div class = prices'>";
                // echo "<div class = 'amount$productID'>" . $row['productPrice'] . "</div>";
                // // echo "<a href='includes/removeFromCart.inc.php?productID = $productID><button>'" . $row['productPrice'] . "</button></a>";
                // echo "<a href='includes/removeFromCart.inc.php?productID=$productID'>" . "<div class = 'remove'><u>Remove</u></div></a>";
                // echo "</div>";
                // echo "</div>";
                // echo "<input type='hidden' id='productQuantity' name='productQuantity' value='$productQuantity'>";

                echo "<div class = 'product'>";
                echo "<div class = 'product-image'>" . "<img src = " . $row['productImage'] . ">";
                echo "</div>";
                echo "<div class = 'product-details'>";
                echo "<div class ='product-title'>" . $row['productName'] . "</div>";
                echo "</div>";
                echo "<div class = 'product-price'>" . $row['productPrice'] . "</div>";
                echo "<div class = 'product-quantity'>";
                echo "<input type = 'number' value = '1' min = '1' max = '$productQuantity>";
                echo "</div>";
                echo "<div class ='product-removal'>";
                echo "<a href='includes/removeFromCart.inc.php?productID = $productID><button>'" . $row['productPrice'] . "</button></a>";
                echo "</div>";
                echo "<div class = 'product-line-price'></div>";
                echo "</div>";
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

            <button class="checkout">Checkout</button>

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
    }

    // function calculateRemaining(e) {

    //     var total = 0;
    //     var remaining = 0;

    //     $('.amount').each(function() {
    //         if ($(this).val()) {
    //             value += parseFloat($(this).val());
    //         }
    //     });


    //     $("#remaining").val(remaining);

    // }


    // $(document).ready(function() {

    //     $(".itemQty").on('change', function(){

    //         var add = document.getElementById("quantity"+id).value;
    //         var productQuantity = document.getElementById("productQuantity").value;
    //         console.log(productQuantity);

    //         $.ajax({
    //             url:'action.php',
    //             method: 'post',
    //             cache: false,
    //             data: {add:"quantity"+id, productQuantity:productQuantity},
    //             success: function(response){
    //                 console.log(response); 
    //             }
    //         });
    //     });
    // })

    //     function btnAdd(id) {
    //         add = document.getElementById("quantity"+id).value; // before quantity
    //         productQuantity = document.getElementById("productQuantity").value;
    //         amountQuantity = $(".amount" + id).text(); // value in html
    //         newAdd = parseInt(add)+1; // after quantity
    //         totalPrice = parseFloat($(".total-amount").text().replace('$', '')); 

    //         if (add >= productQuantity) {
    //             newAdd = productQuantity;
    //         } else{
    //             newAdd = parseInt(add) + 1;
    //         }
    //         document.getElementById("quantity"+id).value = newAdd; 

    //         originalPrice = amountQuantity/add // divide up to find ori value exp = 100/5 = rm20
    //         newPrice1 = Math.round((originalPrice*newAdd) * 100)/100; 

    //         totalCalculate = totalPrice+originalPrice

    //         $(".amount"+id).text(newPrice1);

    //         if (add < productQuantity) {
    //             $(".total-amount").text("$"+Math.round(totalCalculate*100)/100);   // set after quantity * original price
    //         }      
    // }

    //     function btnSub(id) {
    //         sub = document.getElementById("quantity"+id).value;
    //         productQuantity = document.getElementById("productQuantity").value;
    //         amountQuantity = $(".amount" + id).text();
    //         newSub = parseInt(sub)-1;
    //         originalPrice = amountQuantity/sub
    //         if (sub <= 1){
    //             newSub = 1;
    //         } else {
    //             totalPrice1 =  parseFloat($(".total-amount").text().replace('$', '')) - originalPrice;
    //         }
    //         document.getElementById("quantity"+id).value = newSub; 

    //         newPrice = Math.round((originalPrice*newSub) * 100)/100; 

    //         $(".amount"+id).text(newPrice);
    //         $(".total-amount").text("$"+Math.round((totalPrice1) * 100)/100);    
    //     }     

    // $(document).ready(function() {

    // });

    // function btnAdd(id) {

    //     var add = document.getElementById("quantity"+id).value;
    //     var productQuantity = document.getElementById("productQuantity").value;
    //     var totaProductPrice = add * productQuantity;

    //     var price = $(".amount" + id).text(); 

    //     $.post("includes/increaseCart.php", {valueOne: add,valueTwo: price}, function(data,status) {

    //         // alert("Data: " + data + "\nStatus: " + status);


    //         $("#testing").text("$"+valueOne);
    //         $("#total-amount").text("$"+data);
    //     });
    // }
</script>

</body>

</html>