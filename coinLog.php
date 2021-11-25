<?php
// Start the session
session_start();
?>
<?php
include_once 'header.php';
include_once 'includes/databaseHandler.inc.php';
?>

<!--link to css-->
<link rel="stylesheet" href="coinLog.css">


<!--content here-->

<div style="margin-bottom: 120px;"></div>

<div class="bidding-container">
    <div class="bidding-inner-container">


        <div class="bidding-info">
            <div class="bidding-function-container">
                <a href="coinLog.php?search=deduct"><button class="btnDeduct">deduct</button></a>
                <a href="coinLog.php?search=add"><button class="btnAdd">add</button></a>
            </div>

            <?php

            $userEmail = $_SESSION["userEmail"];
            $sql;
            if (isset($_GET["search"])) {
                $search = $_GET["search"];
                if ($search == "add") {
                    $sql = "SELECT * FROM coin where transactionStatus = 'biddingRefund' AND userEmail = '$userEmail' ";
                } else if ($search == "deduct") {
                    // $sql = "SELECT * FROM coin where (userEmail = '$userEmail' and transactionStatus = 'deduct1') or (userEmail = '$userEmail' and transactionStatus = 'deduct2') ";
                    $sql ="SELECT * FROM coin where userEmail = '$userEmail' and transactionStatus = 'deduct1' UNION SELECT * FROM coin where userEmail = '$userEmail' and transactionStatus = 'deduct2'";
             
                } else {
                    $sql = "SELECT * FROM coin where  userEmail = '$userEmail' ";
                }
            } else {
                $sql = "SELECT * FROM coin where  userEmail = '$userEmail' ";
            }


            // $sql = "SELECT * FROM coin where  userEmail = '$userEmail' ";
            $result = mysqli_query($conn, $sql);
            $resultCheck = mysqli_num_rows($result);
            $count = 1;
            if ($resultCheck > 0) {
                echo '<table>
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">coin amount</th>
                                </tr>
                            </thead><tbody id="output">';
                while ($row = mysqli_fetch_assoc($result)) {
                    if ($row["transactionStatus"] == "biddingRefund") {
                        echo "<tr style='background-color:#46db7f'>";
                        echo "<td>" . $count . "</td>";
                        echo "<td>" . $row["coinAmount"] . "</td>";
                        echo "</tr>";
                    } else if ($row["transactionStatus"] == "deduct1") {
                        echo "<tr style='background-color:#e43939'>";
                        echo "<td>" . $count . "</td>";
                        echo "<td>" . $row["coinAmount"] . "</td>";
                        echo "</tr>";
                    } else if ($row["transactionStatus"] == "deduct2") {
                        echo "<tr style='background-color:#e43939'>";
                        echo "<td>" . $count . "</td>";
                        echo "<td>" . $row["coinAmount"] . "</td>";
                        echo "</tr>";
                    }

                    $count++;
                }
                echo ' </tbody></table>';
            } else {
                echo "<p style='margin-left:88px'>there is no coin transaction before</p>";
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

