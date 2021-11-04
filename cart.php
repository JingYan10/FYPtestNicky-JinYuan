<?php
// Start the session
session_start();
?>
<?php
    include_once 'header.php';
?>

<!--link to css-->
<link rel="stylesheet" href="cart.css">

        <!--content here-->
        <div class = "Main-Container">
        <div class="CartContainer">
            <div class="Header">
                <h3 class="Heading">Shopping Cart</h3>
                <h5 class="Action">Remove all</h5>
            </div>
  
            <div class="Cart-Items">
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
            </div>
  
            <div class="Cart-Items pad">
                  <div class="image-box">
                      <img src="images/products/nuts3.jpg" height="120px" }} />
                  </div>
                  <div class="about">
                      <h1 class="title">Nuts</h1>
                      <h3 class="subtitle">250ml</h3>
                      
                  </div>
                  <div class="counter">
                      <div class="btn">+</div>
                      <div class="count">1</div>
                      <div class="btn">-</div>
                  </div>
                  <div class="prices">
                      <div class="amount">$3.19</div>
                      <div class="save"><u>Save for later</u></div>
                      <div class="remove"><u>Remove</u></div>
                  </div>
            </div>
          <hr> 
          <div class="checkout">
          <div class="total">
              <div>
                  <div class="Subtotal">Sub-Total</div>
                  <div class="items">2 items</div>
              </div>
              <div class="total-amount">$6.18</div>
          </div>
          <button class="button">Checkout</button></div>
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
              $('html, body').animate({scrollTop:0}, '300');
            });
        </script>

        <!--for toggleMenu()-->
        <script>
    
            $(document).ready(function () {
                $(".menu-icon").click(function () {
                    $("#Menuitems").fadeToggle(200);
                });

                var w = $(".container > .box-container > .box:first-child").width()
                $(".box:last-child").css({ width:""+w, flex: "none"})
            
            });
    
            $(window).bind("resize", function () {
                if ($(window).width() > 800)
                    $("#Menuitems").css("display", "block");
                else
                    $("#Menuitems").css("display", "none");
            });  
        </script>
        </body>
    </html>