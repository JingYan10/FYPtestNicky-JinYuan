<?php
// Start the session
session_start();
?>
<?php
    include_once 'header.php';
?>

<!--link to css-->
<link rel="stylesheet" href="admin.css">

        
<!--Content Here-->










        
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