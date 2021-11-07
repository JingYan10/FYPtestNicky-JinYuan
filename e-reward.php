<?php
// Start the session
session_start();
?>
<?php
include_once 'header.php';
?>

<!--link to css-->
<link rel="stylesheet" href="e-reward.css">


<!--content here-->
<div class="cardList">
    <!--
      -->
    <div class="card common"></div>
    <!--
      -->
    <div class="card rare"></div>
    <!--
      -->
    <div class="card mythical"></div>
    <!--
      -->
    <div class="card legendary"></div>
    <!--
      -->
</div>
<button id="spin">Spin</button>



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
    var cardList = $('.cardList').first(),
        cards = $('.card'),
        speed = 10000000,
        width = 100,
        randomize = true,
        distance = 10 * width;

    for (var i = 0; i < 50; i++) {
        cards.clone().appendTo(cardList);
    }

    function spin() {
        var newMargin = 0,
            newDistance = distance;
        if (randomize) {
            newDistance = Math.floor(Math.random() * cards.length * 5);
            newDistance += cards.length * 100;
            var rand = Math.floor((Math.random() * 100) + 1);
            newDistance *= rand;
        }
        newMargin = -(newDistance);
        cards.first().animate({
            marginLeft: newMargin
        }, 7500);
    }

    $('#spin').click(function() {
        //cards.first().css('margin-left', 0);
        setTimeout(spin, 500);
        return false;
    });
</script>

</body>

</html>