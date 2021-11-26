<?php


$commentNewCount = $_POST['commentNewCount'];
$productID = $_POST['productID'];

require_once 'databaseHandler.inc.php';
require_once 'functions.inc.php';


$sql = "SELECT * FROM comments where productID='$productID' LIMIT $commentNewCount ";
$result = mysqli_query($conn, $sql);
$resultCheck = mysqli_num_rows($result);
if ($resultCheck > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='balloon balloon--primary'>";
        echo "<div class='balloon__inner'>";
        echo "<p style='color:#033a99'>user : " . $row['userEmail'];
        echo "</p><br>";
        echo "<p style='color:#033a99'>say : " . $row['productComment'];
        echo "</p><br>";
        echo "<p style='color:#033a99'>by :" . $row['commentDate'];
        echo " </p></div>";
        echo "</div>";
    }
}
