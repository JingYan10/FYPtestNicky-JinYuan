<?php
// Start the session
session_start();
?>
<?php
include_once 'header.php';
?>
<!--link to css-->
<link rel="stylesheet" href="trackShipment.css">
<!--content here-->
<section class="forgetPassword-form">

    <div class="center">
        <h1>Track Shipment</h1>
        <form action="includes/trackShipment.inc.php" method="post">

            <div class="txt_field">
                <input type="text" name="shipmentID" id="shipmentID" required>
                <span></span>
                <label>Shipment ID ( e.g. shipment1 )</label>
            </div>
            <div id="result"></div>
            <br>

            <button class="button" style="margin-bottom:20px;" type="button" onclick="trackShipment()">Submit</button>



        </form>



        <?php
        if (isset($_GET["error"])) {
            if ($_GET["error"] == "invalidExistUser") {
                echo "<div style='text-align:center;color:red;font-weight:600'>user doesn't exist</div>";
            }
        }
        ?>
    </div>

</section>

<div class="removethis" style="margin-bottom: 700px;"></div>

<!--footer-->
<?php
include_once 'footer.php';
?>
<script>
    function trackShipment() {
        $.ajax({
            type: 'POST',
            url: 'includes/trackShipment.inc.php',
            data: {
                shipmentID: $("#shipmentID").val(),
            },
            success: function(data) {
                if (data != "noData") {
                    if (data == "delivered") {
                        $("#result").html("the parcel has received by the buyer");
                        $("#result").css('color', 'blue');
                    }else if (data == "delivering"){
                        $("#result").html("the driver is sending the current parcel");
                        $("#result").css('color', 'green');
                    }else if (data == "taskAssigned"){
                        $("#result").html("preparing shipment for current parcel");
                        $("#result").css('color', 'purple');
                    }
                } else {
                    $("#result").html("shipment data is not found"); 
                }

            }
        });
    }
</script>
<script>
    $('form').bind("keypress", function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            return false;
        }
    });
</script>
</body>

</html>