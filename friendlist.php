|<?php
    session_start();
    include_once 'header.php';

    ?>
<link rel="stylesheet" href="header&footer.css">
<link rel="stylesheet" href="friendlist.css">

<!--content here-->
<div class="container">

    <?php

    $userEmail = $_SESSION["userEmail"];
    // $secondUserEmail =  $_SESSION["secondUserEmail"];
    // $friendStatus =  $_SESSION["friendStatus"];

    $sql = " SELECT * FROM friendlist WHERE secondUserEmail = '$userEmail' AND friendStatus = 'pending' ";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);


    if ($resultCheck > 0) {

        // $_SESSION["secondUserEmail"] = $row['secondUserEmail'];
        // $_SESSION["friendStatus"] = $row['friendStatus'];

        echo '<table>+
            <caption>Friend List</caption>
            <thead>
                <tr>
                    <th scope="col">Email</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>';

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tbody>";
            echo "<tr>";
            echo "<td data-label='Email'>" . $row['secondUserEmail'] . "</td>";
            echo "<td data-label='Email'>" . $row['friendStatus'] . "</td>";
            echo "<td data-label='Action'>" . "<a href='includes/acceptFriend.inc.php?userEmail=".$row['secondUserEmail']."'>" . "<button class='btnAccept'>Accept</button></a>" . "<a href='includes/rejectFriend.inc.php?userEmail=".$row['secondUserEmail']."'>". "<button class='btnReject'>Reject</button></a>" . "</td>";
            echo "<tr>";
            echo "<tbody>";
        }
    } else {
        echo '<p style = "color : #fff">There is no friend to accept</p>';
    }
    ?>
    </table>

</div>

<div class="container">
    <?php
    $sql = "SELECT * FROM friendlist WHERE secondUserEmail = '$userEmail' AND friendStatus = 'accepted' ";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    if ($resultCheck > 0) {
        echo '<table>
            <caption>Friends</caption>
            <thead>
                <tr>
                    <th scope="col">User Email</th>
                    <th scope="col">Friend Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead><tbody>';

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td data-label='Email'>" . $row['firstUserEmail'] . "</td>";
            echo "<td data-label='Friend Status'>" . $row['friendStatus'] . "</td>";
            echo "<td data-label='Action'>" . "<a href='includes/removeFriend.inc.php?userEmail=".$row['secondUserEmail']."'>" . "<button class='btnUnfriend'>Unfriend</button></a>" . "</td>";
        }
        echo ' </tbody></table>';
    } else {
        echo '<p style = "color : #fff">There is no friend to unfriend</p>';
    }
    ?>
    <div style="margin-bottom:50px;"></div>
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