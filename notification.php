<?php
// Start the session
?>
<!--link to css-->
<link rel="stylesheet" href="notification.css">

<?php
include_once 'includes/databaseHandler.inc.php';

$sql = "SELECT * FROM notification where receiverEmail='$_SESSION[userEmail]';";
$result = mysqli_query($conn, $sql);
$resultCheck = mysqli_num_rows($result);
$notificationCount = 0;
if ($resultCheck > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $notificationCount++;
    }
}
?>

<div class="notification">
    <a href="#">
        <div class="notBtn" href="#">
            <!--Number supports double digets and automaticly hides itself when there is nothing between divs -->
            <?php
            if (!$notificationCount <= 0) {
                echo "<div class='number'>$notificationCount</div>";
            }
            ?>
            <?php
            include_once 'includes/databaseHandler.inc.php';

            $sql = "SELECT * FROM notification where receiverEmail='$_SESSION[userEmail]' ORDER BY notificationID DESC;";
            $result = mysqli_query($conn, $sql);
            $resultCheck = mysqli_num_rows($result);
            if ($resultCheck > 0) {
                echo " <i class='fas fa-bell'></i>
                            <div class='box2'>
                                <div class='display'>
                                    <div class='nothing'>
                                        <i class='fas fa-child stick'></i>
                                        <div class='cent'>Looks Like your all caught up!</div>
                                    </div>
                                    <div class='cont'>
                            ";
                while ($row = mysqli_fetch_assoc($result)) {
                    // $_SESSION["userFirstName"] = $row['userFirstName'];
                    echo "<div class='sec new'>";
                    echo "<div class='profCont'>";
                    echo "<img class='profile' src='" . $row["image"] . "'>";
                    echo "</div>";
                    echo "<div class='txt' style='color:black;'>" . $row['notificationDescription'] . "</div>";
                    $productData = "productID=" . $row['neededID'];
                    if ($row["notificationType"] == "productReview") {
                        echo "<div class='txt sub'><a href=productReview.php?" . "$productData" . "><input type='button' value='review product'></a></div>";
                    }
                    echo "</div>";
                }
                echo "
                            </div>
                </div>
            </div>
        </div>
    </a>
</div>
                            ";
            }
            ?>