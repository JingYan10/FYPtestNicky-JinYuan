<?php
// Start the session
session_start();
?>
<?php
include_once 'header.php';
include_once 'includes/databaseHandler.inc.php';
?>

<!--link to css-->
<link rel="stylesheet" href="user_profile_ban.css">

<?php
$sql = "SELECT * FROM users where userEmail='$_SESSION[userEmail]'";
$result = mysqli_query($conn, $sql);
$resultCheck = mysqli_num_rows($result);
if ($resultCheck > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $_SESSION["userFirstName"] = $row['userFirstName'];
        $_SESSION["userLastName"] = $row['userLastName'];
        $_SESSION["userRole"] = $row['userRole'];
        $_SESSION["userImage"] = $row['userImage'];
        $_SESSION["banStatus"] = $row['banStatus'];
    }
} else {
    header("location: ../login.php?error=noUserProfile");
    exit();
}
?>

<!--content here-->
<div class="container">
    <?php
        $sql = "SELECT * FROM users where banStatus = 'UnBanned' ";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
                       
        if ($resultCheck > 0) {
            echo '<table>
            <caption>Products</caption>
            <thead>
                <tr>
                    <th scope="col">User Email</th>
                    <th scope="col">Ban Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead><tbody>';
            
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['userEmail'] . "</td>";
                echo "<td>" . $row['banStatus'] . "</td>";
                $userData = "userEmail=".$row['userEmail'];
                echo "<td>" . "<a href='includes/banUser.inc.php?".$userData."'>"."<button class='btnBan'>Ban</button></a>" ."</td>";

            }
            echo ' </tbody></table>';
        }else {
            echo '<p style = "color : #fff">There is no user to ban</P>';
        }      
    ?>
       <div style="margin-bottom:50px;"></div>
</div>


<div class="container">
<?php
        $sql = "SELECT * FROM users where banStatus = 'Banned' ";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
                       
        if ($resultCheck > 0) {
            echo '<table>
            <caption>Products</caption>
            <thead>
                <tr>
                    <th scope="col">User Email</th>
                    <th scope="col">Ban Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead><tbody>';
            
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['userEmail'] . "</td>";
                echo "<td>" . $row['banStatus'] . "</td>";
                $userData = "userEmail=".$row['userEmail'];
                echo "<td>" . "<a href='includes/UnbanUser.inc.php?".$userData."'>". "<button class='btnUnBan'>UnBan</button></a>"."</td>";
            }
            echo ' </tbody></table>';
        }else {
            echo '<p style = "color : #fff">There is no user to unban</p>';
        }      
    ?>
       <div style="margin-bottom:50px;"></div>
</div>



<?php
include_once 'footer.php';
?>


</body>

</html>