<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--link to ajax-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!--link to css-->
    <link rel="stylesheet" href="signUp.css">
    
    
    <!--link font-->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <!--link bootsrap CDN-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    
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
                        <li><a href="index.php"m>Home</a></li>
                        <li><a href="">Products</a></li>
                        <li><a href="">About</a></li>
                        <li><a href="">Contact</a></li>
                        <li><a href="">Account</a></li>
                    </ul>
                </nav>
                <a href=""><img src="images/images/cart.png" width="30px" height="30px" alt=""></a>
                <img src="images/images/menu.png" class="menu-icon" onclick="toggleMenu()">
            </div>

            <!--back to top-->
            <a id="button"></a>

            <!--content here-->
            <section class="singUp-form">
            <h1 style="margin-top:70px;margin-left:100px">Sign Up</h1>
            <form action="includes/signUp.inc.php" method="post">
                <input type="text" name="firstName" placeholder="First name..."> <br>
                <input type="text" name="lastName" placeholder="Last name..."> <br>
                <input type="text" name="email" placeholder="Email..."> <br>
                <input type="password" name="password" placeholder="Password..."> <br>
                <input type="password" name="confirmPassword" placeholder="Confirm password..."> <br>
                <button type="submit" name="submit">Sign Up</button> <br>
            </form>

            <?php
            if(isset($_GET["error"])){
                if($_GET["error"]=="emptyInput"){
                    echo "fill up the blank space";
                }
                else if ($_GET["error"]=="invalidName"){
                    echo "firstname / lastname cannot have digit(s)";
                }
                else if ($_GET["error"]=="invalidEmail"){
                    echo "inccorect email format";
                }
                else if ($_GET["error"]=="mismatchPassword"){
                    echo "password and confirm password are not matched";
                }
                else if ($_GET["error"]=="existingUser"){
                    echo "this email has registered before";
                }
                else if ($_GET["error"]=="stmtFailed"){
                    echo "something went wrong, please try again later";
                }
                else if ($_GET["error"]=="none"){
                    echo "congrats to join us";
                }
                   

            }
        ?>

            </section>

        
            

            

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
</body>
</html>