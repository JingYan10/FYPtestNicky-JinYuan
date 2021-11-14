<?php
// Start the session
session_start();
?>
<?php
include_once 'header.php';
?>
<!--link to css-->
<link rel="stylesheet" href="selectWorkingShift.css">
<!--content here-->
<section class="login-form">

    <div class="center">
        <h1>Select working shift</h1>
        <form action="includes/selectWorkingShift.inc.php" method="post">

            <div class="txt_field">
                <p>Working Shift</p>
                <div class="select">
                    <select name="workingShift" id="workingShift">
                        <option selected disabled>Working Shift Schedule</option>
                        <option value="shift1">08:00 am ~ 10:00 am</option>
                        <option value="shift2">10:00 am ~ 12:00 pm</option>
                        <option value="shift3">12:00 pm ~ 02:00 pm</option>
                        <option value="shift4">02:00 pm ~ 04:00 pm</option>
                        <option value="shift5">04:00 pm ~ 06:00 pm</option>
                        <option value="shift6">06:00 pm ~ 08:00 pm</option>
                        <option value="shift7">08:00 pm ~ 10:00 pm</option>
                        
                    </select>
                </div>
            </div>
            <button class="button" type="submit" name="submit">Submit</button>
        



        </form>



        <?php
        if (isset($_GET["error"])) {
            if ($_GET["error"] == "emptyInput") {
                echo "<div style='text-align:center;color:red;font-weight:600'>fill up the blank space</div>";
            } else if ($_GET["error"] == "wrongLogin") {
                echo "<div style='text-align:center;color:red;font-weight:600'>inccorect login</div>";
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
</body>

</html>