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
                <input type="text" class="biddingSearchBar" name="search2" id="search2" placeholder="search by biddingID (eg : B002) ">
                <a href="bidding.php?search=active"><button class="btnSearchActive">active</button></a>
                <a href="bidding.php?search=ended"><button class="btnSearchEnded">ended</button></a>
            </div>

            <?php

            $sql;
            if (isset($_GET["search"])) {
                $search = $_GET["search"];
                if ($search == "active") {
                    $sql = "SELECT * FROM bidding where biddingStatus = 'active'";
                } else if ($search == "ended") {
                    $sql = "SELECT * FROM bidding where biddingStatus = 'ended'";
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
                                     
                                    <th scope="col">Product Image</th>
                                    <th scope="col">Ending Time</th>
                                    <th scope="col">Starting Price</th>
                                    <th scope="col">Highest Price</th>
                                    <th scope="col">Total Bidder</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead><tbody id="output">';
                while ($row = mysqli_fetch_assoc($result)) {
                    $biddingProductID = $row['biddingProductID'];
                    $sql = "SELECT * FROM product where productID ='$biddingProductID'";
                    $result2 = mysqli_query($conn, $sql);
                    $resultCheck2 = mysqli_num_rows($result2);
                    if ($resultCheck2 > 0) {
                        while ($row2 = mysqli_fetch_assoc($result2)) {
                            echo "<tr>";
                            echo "<td>" . "B00" . $row['biddingID'] . "</td>";
                            // echo "<td>" . $row['biddingProductID'] . "</td>";
                            echo "<td><img style='width:50px;height:50px;'src='" . $row2['productImage'] . "'></td>";
                            date_default_timezone_set("Asia/Kuala_Lumpur");
                            $biddingEndingTime = $row['biddingEndingTime'];
                            $timeBiddingEndingTime = strtotime($biddingEndingTime);
                            $dateBiddingEndingTime = date("d M Y h:i:s", $timeBiddingEndingTime);
                            echo "<td>" . $dateBiddingEndingTime . "</td>";
                            echo "<td>RM " . number_format((float)$row['biddingStartingPrice'], 2, '.', '') . "</td>";
                            echo "<td>RM " . number_format((float)$row['biddingEndingPrice'], 2, '.', '')  . "</td>";
                            echo "<td>" . $row['totalBidder'] . "</td>";
                            echo "<td>";

                            if ($row['biddingStatus'] == "active") {
                                $biddingData = "biddingID=" . $row['biddingID'];
                                echo "<a href='biddingDetail.php?" . $biddingData . "'>" . "<button class='btnJoinBidding'>join</button></a>";
                            } else {
                                $biddingData = "biddingID=" . $row['biddingID'] . "&view=true";
                                echo "<a href='biddingDetail.php?" . $biddingData . "'>" . "<button class='btnJoinBidding'>view</button></a>";
                            }
                        }
                        echo "</td>";
                        echo "</tr>";
                    }
                }
                echo ' </tbody></table>';
            } else {
                echo "<p style='margin-left:350px'>there is no active bidding</p>";
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
        $("#search2").keyup(function() {
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