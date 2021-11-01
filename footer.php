 <!--footer-->

 <!--link to css-->
 <link rel="stylesheet" href="header&footer.css">
 
 <div class="footer">

<div class="box-container">

    <div class="box">
        <h1>Fanciado Foodo</h1>
        <img src="images/logo/logo.png" class="logo" alt="">
        <p>Our purpose is to serve the best quality of products and services to our customers.</p>
    </div>


    <div class="box">
        <h3>Helpful links</h3>
        <div class="links">
            <ul>
                <li><a href="">Coupons</a></li>
                <li><a href="faq.php">FAQ</a></li>
                <li><a href="">Feedback</a></li>
                <li><a href="">Join Us</a></li>
                <li><a href="">Refund Policy</a></li>
                <li><a href="">About Us</a></li>
            </ul>
        </div>
    </div>

    <div class="box">
        <h3>Follow us</h3>
        <div class="socials">
            <a href="#" class="btn fab fa-facebook-f"></a>
            <a href="#" class="btn fab fa-twitter"></a>
            <a href="#" class="btn fab fa-instagram"></a>
            <a href="#" class="btn fab fa-youtube"></a>
        </div>
    </div>
</div>

<hr>
<p class="copyright">Copyright reserved by Nicky & Jing Yan</p>
</div>

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
        });

        $(window).bind("resize", function () {
            if ($(window).width() > 800)
                $("#Menuitems").css("display", "block");
            else
                $("#Menuitems").css("display", "none");
        });

    </script>