<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--link to jquery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <!--link to css-->
    <link rel="stylesheet" href="style.css">
    <!--link font-->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <!--link bootsrap CDN-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!--link AOS-->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <!--link for back to top-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">


    <title>Fanciado Foodo</title>

    <!-- <style type="text/css">
        #slider {
            overflow: hidden;
        }
        #slider figure {
            position: relative;
            width: 500%;
            margin: 0;
            left: 0;
            animation: 20s slider infinite;
        }

        #slider figure img {
            width: 20%;
            float: left;
        }

        @keyframes slider {
            0% {
                left: 0;
            }
            20% {
                left: 0;
            }
            25% {
                left: -100%;
            }
            45% {
                left: -100%;
            }
            50% {
                left: -200%;
            }
            70% {
                left: -200%;
            }
            75% {
                left: -300%;
            }
            95% {
                left: -300%;
            }
            100% {
                left: -400%;
            }
        }
    </style> -->
    <script src="myscripts.js"></script>

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
                <ul id="menuitems">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="product.php">Products</a></li>
                        <li><a href="cart.php">Cart</a></li>
                        <li><a href="verifier.php">Verify</a></li>
                        <li><a href="faq.php">About</a></li>
                        <?php
                            if(isset($_SESSION["userEmail"])){
                                echo "<li><a href='user_profile.php'>Profile</a></li>";
                                echo "<li><a href='includes/logout.inc.php'>Log out</a></li>";
                            }
                            else{
                                echo "<li><a href='login.php'>Log in</a></li>";
                            }
                        ?>   
                    </ul>
                </nav>
                <!-- <a href="verifier.php"><img src="images/images/cart.png" width="30px" height="30px" alt=""></a> -->
                <img src="images/images/menu.png" class="menu-icon" onclick="toggleMenu()">
            </div>

            <!--back to top-->
            <a id="button"></a>

            <!-- <div id="slider">
                <figure>
                    <img src="images/images/cookies.jpg">
                    <img src="images/images/pasta.jpg">
                    <img src="images/images/snacks.jpg">
                    <img src="images/images/nuts.jpg">
                    <img src="images/images/protein.jpg">
                </figure>
            </div> -->
            <!-- Slideshow container -->

           

            <div class="slideshow-container fade">
                <!-- Full images with numbers and message Info -->
                <div class="Containers">
                    <div class="MessageInfo"></div>
                    <img src="images/images/cookies.jpg" style="width:100%">
                    <div class="Info">First caption</div>
                </div>

                <div class="Containers">
                    <div class="MessageInfo"></div>
                    <img src="images/images/pasta.jpg" style="width:100%">
                    <div class="Info">Second Caption</div>
                </div>

                <div class="Containers">
                    <div class="MessageInfo"></div>
                    <img src="images/images/snacks.jpg" style="width:100%">
                    <div class="Info">Third Caption</div>
                </div>

                <div class="Containers">
                    <div class="MessageInfo"></div>
                    <img src="images/images/protein.jpg" style="width:100%">
                    <div class="Info">Fourth Caption</div>
                </div>

                <div class="Containers">
                    <div class="MessageInfo"></div>
                    <img src="images/images/nuts.jpg" style="width:100%">
                    <div class="Info">Fifth Caption</div>
                </div>

                <!-- Back and forward buttons -->
                <a class="Back" onclick="plusSlides(-1)">&#10094;</a>
                <a class="forward" onclick="plusSlides(1)">&#10095;</a>
            </div>
            <br>

            <!-- The circles/dots -->
            <div style="text-align:center">
                <span class="dots" onclick="currentSlide(1)"></span>
                <span class="dots" onclick="currentSlide(2)"></span>
                <span class="dots" onclick="currentSlide(3)"></span>
                <span class="dots" onclick="currentSlide(4)"></span>
                <span class="dots" onclick="currentSlide(5)"></span>
            </div>



            <!--product 1-->
            <div class="row">
                <div class="col-2">
                    <h1>Biscuits</h1>
                    <p>Chocolate ?? Almond ?? Raisins ?? Oat ?? Butterscotch</p>
                    <div class="btn-container"><a href="" class="btn">Know more</a></div>

                </div>
                <div class="col-2">
                    <img src="images/products/product1-biscuit.jpg" data-aos="fade-left" alt="error product1 image">
                </div>
            </div>

            <!--product 2-->
            <div class="row">
                <div class="col-2">
                    <img data-aos="fade-right" style="height:500px; float: right;"
                        src="images/products/product2-pasta-left2.jpg" alt="error product1 image">
                </div>
                <div class="col-2">
                    <h1>Pasta</h1>
                    <p>Spaghetti ?? Fettuccine ?? Linguine ?? Penne ?? Macaroni</p>
                    <div class="btn-container"><a href="" class="btn">Know more</a></div>
                </div>
            </div>
        </div>
    </div>

    <!-- product categories -->
    <div class="categories">
        <div class="small-container">
            <h2 class="title" data-aos="fade-down">Categories</h2>
            <div class="row" data-aos="fade-down">
                <div class="col-3">
                    <img src="images/products/productCategory1-cereal-left-.jpeg" alt="">
                </div>
                <div class="col-3">
                    <img src="images/products/productCategory2-cereal-middle-.jpeg" alt="">
                </div>
                <div class="col-3">
                    <img style="height: 250px;" src="images/products/productCategory3-snack-middle3.jpeg" alt="">
                </div>
            </div>
        </div>
    </div>

    <!-- hot sales product -->
    <div class="small-container">
        <h2 class="title" data-aos="fade-down">Hot Sales products</h2>
        <div class="row" data-aos="fade-down">
            <div class="col-4">
                <img src="images/products/hotSaleproduct1-driedfruits.jpg" alt="">
                <h4>Dried Fruits</h4>
                <div class="rating">
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fas fa-star-half-alt" aria-hidden="true"></i>
                    <i class="far fa-star"></i>
                    <i class="far fa-star"></i>
                    <i class="far fa-star"></i>
                </div>
                <p>RM10.00</p>
            </div>

            <div class="col-4">
                <img src="images/products/hotSaleproduct1-driedfruits.jpg" alt="">
                <h4>Dried Fruits</h4>
                <div class="rating">
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fas fa-star-half-alt" aria-hidden="true"></i>
                    <i class="far fa-star"></i>
                    <i class="far fa-star"></i>
                    <i class="far fa-star"></i>
                </div>
                <p>RM10.00</p>
            </div>

            <div class="col-4">
                <img src="images/products/hotSaleproduct1-driedfruits.jpg" alt="">
                <h4>Dried Fruits</h4>
                <div class="rating">
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fas fa-star-half-alt" aria-hidden="true"></i>
                    <i class="far fa-star"></i>
                    <i class="far fa-star"></i>
                    <i class="far fa-star"></i>
                </div>
                <p>RM10.00</p>
            </div>

            <div class="col-4">
                <img src="images/products/hotSaleproduct1-driedfruits.jpg" alt="">
                <h4>Dried Fruits</h4>
                <div class="rating">
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fas fa-star-half-alt" aria-hidden="true"></i>
                    <i class="far fa-star"></i>
                    <i class="far fa-star"></i>
                    <i class="far fa-star"></i>
                </div>
                <p>RM10.00</p>
            </div>
        </div>
    </div>

    <!--5 brandings-->
    <div class="brands">
        <div class="small-container">
            <div class="row" data-aos="fade-down">
                <div class="col-5">
                    <img src="images/brand-logo/logo-clearspring.png" alt="">
                </div>
                <div class="col-5">
                    <img src="images/brand-logo/logo-danisa.png" alt="">
                </div>
                <div class="col-5">
                    <img src="images/brand-logo/logo-doritos.png" alt="">
                </div>
                <div class="col-5">
                    <img src="images/brand-logo/logo-dryfo.gif" alt="">
                </div>
                <div class="col-5">
                    <img src="images/brand-logo/logo-paypal.png" alt="">
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
                        <li><a href="http://localhost/FYPtestNicky-JinYuan/faq.php">FAQ</a></li>
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

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init({
            offset: 400,
            duration: 1000
        });

        var slidePosition = 1;
        SlideShow(slidePosition);

        // forward/Back controls
        function plusSlides(n) {
            SlideShow(slidePosition += n);
        }

        //  images controls
        function currentSlide(n) {
            SlideShow(slidePosition = n);
        }

        function SlideShow(n) {
            var i;
            var slides = document.getElementsByClassName("Containers");
            var circles = document.getElementsByClassName("dots");
            if (n > slides.length) { slidePosition = 1 }
            if (n < 1) { slidePosition = slides.length }
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            for (i = 0; i < circles.length; i++) {
                circles[i].className = circles[i].className.replace(" enable", "");
            }
            slides[slidePosition - 1].style.display = "block";
            circles[slidePosition - 1].className += " enable";
        }
    </script>
    
    


</body>

</html>