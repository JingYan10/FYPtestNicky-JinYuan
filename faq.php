<?php
// Start the session
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--link to ajax-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!--link to css-->
    <link rel="stylesheet" href="website-template.css">
    
    <link rel="stylesheet" href="faq.css">
    <!--link font-->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <!--link bootsrap CDN-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!--link AOS-->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <!--link to jquery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js%22%3E"></script>
    <!--link for back to top-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

    <title>Fanciado Foodo</title>
</head>

<body>
    <div class="header">
        <div class="container">
            <!--navigation bar-->
            <div class="navbar">
                <div class="logo">
                    <img src="images/logo/logo.png" class="logo" alt="error logo image">
                </div>
                <nav>
                    <ul id="Menuitems">
                        <li><a href="http://localhost/FYPtestNicky-JinYuan/index.php">Home</a></li>
                        <li><a href="">Products</a></li>
                        <li><a href="">About</a></li>
                        <li><a href="">Contact</a></li>
                        <li><a href="">Account</a></li>
                    </ul>
                </nav>
                <a href=""><img src="images/images/cart.png" width="30px" height="30px" alt=""></a>
                <img src="images/images/menu.png" class="menu-icon" onclick="toggleMenu()">
            </div>
            

            </div>
            <!--back to top-->
            <a id="button"></a>



            <!--FAQ content-->
      
            <div class="container">


                <h1>FAQ ( Frequently Asked Question )</h1>

                <div class="spacing-top" style="margin-top: 50px;"></div>

                <div class="accordion-menu">
                    <ul>
                        <li>
                            <input type="checkbox" checked>
                            <i class="arrow"></i>
                            <h2><i class="fas fa-question"></i>Languages Used</h2>
                            <p>This UI was written in HTML and CSS.</p>
                        </li>
                        <li>
                            <input type="checkbox" checked>
                            <i class="arrow"></i>
                            <h2><i class="fas fa-question"></i>How it Works</h2>
                            <p>Using the sibling and checked selectors, we can determine 
                                the styling of sibling elements based on the checked state
                                of the checkbox input element. 
                            </p>
                        </li>
                        <li>
                            <input type="checkbox" checked>
                            <i class="arrow"></i>
                            <h2><i class="fas fa-question"></i>Points of Interest</h2>
                            <p>
                                By making the open state default for when :checked isn't 
                                detected, we can make this system accessable for browsers 
                                that don't recognize :checked.
                            </p>
                        </li>
                    </ul>

                    
                    
                </div>

  

            </div>

        </div>

    </div>

    <!--footer-->
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
                        <li><a href="">FAQ</a></li>
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

    <!--for faq()-->
    <script>
        var acc = document.getElementsByClassName("accordion");
        var i;

        for (i = 0; i < acc.length; i++) {
            acc[i].addEventListener("click", function () {
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



</body>

</html>