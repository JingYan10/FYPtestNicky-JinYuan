|<?php
    session_start();
    include_once 'header.php';

    ?>
<link rel="stylesheet" href="header&footer.css">
<link rel="stylesheet" href="paymentHistory.css">



<!--content here-->
<div class="container">

    <table>
        <caption style="color : White">Payment History</caption>
        <thead>
            <tr>
                <th scope="col">Payment ID</th>
                <th scope="col">Paid Amount</th>
                <th scope="col">Payment Date</th>
            </tr>
        </thead>

        <?php
        $email = $_SESSION["userEmail"];
        $sql = "SELECT * FROM payment WHERE userEmail = '$email'";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);

        if ($resultCheck > 0) {

            while ($row = mysqli_fetch_assoc($result)) {

                $paymentID = $row['paymentID'];
                $paymentAmount = $row['paymentAmount'];
                $paymentDate= $row['paymentDate'];

                echo "<tbody>";
                echo "<tr>";
                echo "<td data-label='paymentID'>" . $row['paymentID'] . "</td>";
                echo "<td data-label='paymentAmount'>" . $row['paymentAmount'] . "</td>";
                echo "<td data-label='paymentDate'>" . $row['paymentDate'] . "</td>";
                echo "<tr>";
                echo "</tbody>";    
            }
        } else {

        }
        ?>
    </table>
</div>






<?php
require_once 'includes/databaseHandler.inc.php';
require_once 'includes/functions.inc.php';


echo "friendCode : " . generateFriendCode($conn);
?>
<?php
include_once 'footer.php';
?>



</body>

</html>