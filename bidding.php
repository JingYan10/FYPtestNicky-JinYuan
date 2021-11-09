<?php
// Start the session
session_start();
?>
<?php
include_once 'header.php';
include_once 'includes/databaseHandler.inc.php';
?>

<!--link to css-->
<link rel="stylesheet" href="bidding.css">


<!--content here-->
<h1>Bidding Page</h1>

<div class="bidding-container">
    <div class="bidding-inner-container">


        <div class="bidding-info">
            <div class="bidding-function-container">
                <input type="text" class="biddingSearchBar" name="search2" id="search2" placeholder="search by biddingID">
                <a href="bidding.php?search=active"><button class="btnSearchActive">active</button></a>
                <a href="bidding.php?search=ended"><button class="btnSearchEnded">ended</button></a>
            </div>

            <?php

            $sql;
            if (isset($_GET["search"])) {
                $search = $_GET["search"];
                if ($search == "active") {
                    $sql = "SELECT * FROM bidding where biddingWinner IS NULL";
                } else if ($search == "ended") {
                    $sql = "SELECT * FROM bidding where biddingWinner IS NOT NULL";
                } else {
                    $sql = "SELECT * FROM bidding ";
                }
            } else {
                $sql = "SELECT * FROM bidding ";
            }
            $result = mysqli_query($conn, $sql);
            $resultCheck = mysqli_num_rows($result);




            $biddingEndingTime = "";
            if ($resultCheck > 0) {
                echo '<table>
                            <thead>
                                <tr>
                                    <th scope="col">Bidding ID</th>
                                    <th scope="col">ProductID</th>
                                    <th scope="col">Ending Time</th>
                                    <th scope="col">Starting Price</th>
                                    <th scope="col">Highest Price</th>
                                    <th scope="col">Total Bidder</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead><tbody id="output">';
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . "B00" . $row['biddingID'] . "</td>";
                    echo "<td>" . $row['biddingProductID'] . "</td>";
                    date_default_timezone_set("Asia/Kuala_Lumpur");
                    $biddingEndingTime = $row['biddingEndingTime'];
                    $timeBiddingEndingTime = strtotime($biddingEndingTime);
                    $dateBiddingEndingTime = date("d M Y h:i:s", $timeBiddingEndingTime);
                    echo "<td>" . $dateBiddingEndingTime . "</td>";
                    echo "<td>" . $row['biddingStartingPrice'] . "</td>";
                    echo "<td>" . $row['biddingEndingPrice'] . "</td>";
                    echo "<td>" . $row['totalBidder'] . "</td>";
                    echo "<td>";
                    $biddingData = "biddingID=" . $row['biddingID'];
                    if ($row['biddingWinner'] == null) {
                        echo "<a href='biddingDetail.php?" . $biddingData . "'>" . "<button class='btnJoinBidding'>join</button></a>";
                    } else {
                    }

                    echo "</td>";
                    echo "</tr>";
                }
                echo ' </tbody></table>';
            } else {
                echo "<p style='margin-left:350px'>there is no product created</p>";
            }
            ?>
        </div>
    </div>

</div>




<!--footer-->
<?php
include_once 'footer.php';
?>

<!--javascript-->
<script type="text/javascript">
    $(document).ready(function() {
        $("#search2").keypress(function() {
            $.ajax({
                async: false,
                type: 'POST',
                url: 'includes/searchBidding.inc.php',
                data: {
                    name2: $("#search2").val(),
                },
                success: function(data) {
                    $("#output").html(data);

                }
            });
        });
    });
</script>
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

</body>

</html>