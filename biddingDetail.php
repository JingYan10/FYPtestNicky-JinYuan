<?php
// Start the session
session_start();
?>
<?php
include_once 'header.php';
include_once 'includes/databaseHandler.inc.php';
?>

<!--link to css-->
<link rel="stylesheet" href="biddingDetail.css">

<?php

if (isset($_GET["error"])) {

    $_SESSION["biddingProductID"];
    $_SESSION["biddingEndingTime"];
    $_SESSION["biddingStartingPrice"];
    $_SESSION["biddingEndingPrice"];
    $_SESSION["totalBidder"];
    $_SESSION["biddingWinner"];
    $_SESSION["productName"];
    $_SESSION["productImage"];
} else {





    if (isset($_GET["biddingID"])) {

        $_SESSION["biddingID"] = $_GET["biddingID"];
        $biddingID = $_SESSION["biddingID"];
        $sql = "SELECT * FROM bidding where biddingID='$biddingID'";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        if ($resultCheck > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $_SESSION["biddingProductID"] = $row['biddingProductID'];
                $_SESSION["biddingEndingTime"] = $row['biddingEndingTime'];
                $_SESSION["biddingStartingPrice"] = $row['biddingStartingPrice'];
                $_SESSION["biddingEndingPrice"] = $row['biddingEndingPrice'];
                $_SESSION["totalBidder"] = $row['totalBidder'];
                $_SESSION["biddingWinner"] = $row['biddingWinner'];
            }
        } else {
            header("location: ../login.php?error=noUserProfile");
            exit();
        }
        if (isset($_SESSION["biddingProductID"])) {
            $biddingProductID = $_SESSION["biddingProductID"];
            $sql = "SELECT * FROM product where productID='$biddingProductID'";
            $result = mysqli_query($conn, $sql);
            $resultCheck = mysqli_num_rows($result);
            if ($resultCheck > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $_SESSION["productName"] = $row['productName'];
                    $_SESSION["productImage"] = $row['productImage'];
                }
            } else {
                header("location: ../bidding.php?error=noProductInfo");
                exit();
            }
        }
    } else {
        header("location: ../bidding.php?error=noBiddingID");
        exit();
    }
}

date_default_timezone_set("Asia/Kuala_Lumpur");
$biddingEndingTime = $_SESSION["biddingEndingTime"];
$timeBiddingEndingTime = strtotime($biddingEndingTime);
$dateBiddingEndingTime = date("M d, Y H:i:s", $timeBiddingEndingTime);
?>


<!--content here-->
<h1>Bidding Page</h1>
<div class="bidding-container">
    <div class="bidding-inner-container">
        <div class="bidding-info">
            <div class="productPicture">
                <img src="<?php echo $_SESSION["productImage"] ?>" alt="">
            </div>
            <div class="productInfo">
                <div class="productData">
                    <label>Product Name</label>
                    <input type="text" name="productName" value="<?php echo  $_SESSION["productName"]; ?>" disabled>
                </div>
                <div class="productData">
                    <label>Starting Bid</label>
                    <input type="text" name="biddingStartingPrice" value="RM <?php echo  $_SESSION["biddingStartingPrice"]; ?>" disabled>
                </div>
                <div class="productData">
                    <label>Total Bid(s)</label>
                    <input type="text" name="totalBidder" value="<?php echo $_SESSION["totalBidder"]; ?>" disabled>
                </div>
                <div class="productData">
                    <label style="margin-top:20px;margin-left:85px;font-size:24px;">Ending Time</label>
                    <input type="hidden" id="biddingEndingTime" value="<?php echo $dateBiddingEndingTime ?>">
                    <p style="margin-left: 93px;font-size:18px;" id="countDownTimer"></p>
                </div>
            </div>

        </div>
    </div>
</div>


<div class="bidding-container-2">
    <div class="bidding-inner-container-2">
        <div class="bidding-info-2">
            <div class="bidding-participant-container">

                <?php
                $biddingID = $_SESSION["biddingID"];
                $sql = "SELECT * FROM biddingParticipant where biddingID='$biddingID' ORDER BY biddingPrice DESC";
                $result = mysqli_query($conn, $sql);
                $resultCheck = mysqli_num_rows($result);

                if ($resultCheck > 0) {
                    echo '<table>
                            <thead>
                                <tr>
                                    <th scope="col">Bidding participant ID</th>
                                    <th scope="col">bidding price</th>
                                    <th scope="col">bidding time</th>
                                </tr>
                            </thead><tbody id="output">';
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . "BP00" . $row['biddingParticipantID'] . "</td>";
                        echo "<td>" . $row['biddingPrice'] . "</td>";
                        echo "<td>" . $row['biddingTime'] . "</td>";
                        echo "</tr>";
                    }
                    echo ' </tbody></table>';
                } else {
                    echo '<table>
                    <thead>
                        <tr>
                            <th scope="col">Bidding participant ID</th>
                            <th scope="col">bidding price</th>
                            <th scope="col">bidding time</th>
                        </tr>
                    </thead><tbody id="output">';
                    echo ' </tbody></table>';
                    
                }
                ?>


            </div>
            <div class="placeBid-container">
                <form action="includes/biddingDetail.inc.php" method="post">
                    <input type="hidden" name="biddingID" value="<?php echo $_SESSION["biddingID"]; ?>">
                    <input type="hidden" name="biddingEndingTime" value="<?php echo $_SESSION["biddingEndingTime"]; ?>">
                    <input type="hidden" name="totalBidder" value="<?php echo $_SESSION["totalBidder"]; ?>">
                    <input type="hidden" name="biddingEndingPrice" value="<?php echo $_SESSION["biddingEndingPrice"]; ?>">
                    <label style="margin-top:20px;margin-left:110px;font-size:24px;font-weight:550">Ending Time</label>
                    <p style="margin-left: 116px;font-size:18px;margin-bottom:20px;" id="countDownTimer2"></p>
                    <?php
                        if (!isset($_GET["view"])){
                            echo "<input style='margin-left: 20px;' type='text' name='biddingPrice'>";
                            echo "<button class='btnPlaceBid' type='submit' name='submit'>Place bid</button>";
                        }
                     ?>
                    
                    
                </form>
                <?php
                if (isset($_GET["error"])) {
                    if ($_GET["error"] == "invalidBiddingPrice") {
                        echo "<div style='text-align:center;color:red;font-weight:600'>bidding price shall not contain any alphabets</div>";
                    } else if ($_GET["error"] == "invalidBiddingTime") {
                        echo "<div style='text-align:center;color:red;font-weight:600'>bidding has over</div>";
                    } else if ($_GET["error"] == "higherBiddingPrice") {
                        echo "<div style='text-align:center;color:red;font-weight:600'>place higher bid to join the bidding</div>";
                    } else if ($_GET["error"] == "insufficientBalance") {
                        echo "<div style='text-align:center;color:red;font-weight:600'>insufficient fund, please topup coin</div>";
                    }
                   
                }
                ?>
            </div>



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
    var biddingEndingDateTime = document.getElementById("biddingEndingTime").value;
    // Set the date we're counting down to
    var countDownDate = new Date(biddingEndingDateTime).getTime();

    // Update the count down every 1 second
    var x = setInterval(function() {

        // Get today's date and time
        var now = new Date().getTime();

        // Find the distance between now and the count down date
        var distance = countDownDate - now;

        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);


        document.getElementById("countDownTimer").innerHTML = days + "d " + hours + "h " +
            minutes + "m " + seconds + "s ";
        
            document.getElementById("countDownTimer2").innerHTML = days + "d " + hours + "h " +
            minutes + "m " + seconds + "s ";

        // If the count down is over, write some text 
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("countDownTimer").innerHTML = "EXPIRED";
            document.getElementById("countDownTimer2").innerHTML = "EXPIRED";
        }
    }, 1000);
</script>
</body>

</html>