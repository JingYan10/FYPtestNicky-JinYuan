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
    <!-- <table>
        <caption>Statement Summary</caption>
        <thead>
            <tr>
                <th scope="col">User Accounts</th>
                <th scope="col">Ban Status</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td data-label="User Account"><?php echo $_SESSION['userEmail'];?></td>
                <td data-label="Ban Status"><?php echo $_SESSION['banStatus'];?></td>
                <td data-label="Action"><a href=""><input type="button" class="btnBan" value="Ban"></a>&nbsp;<a href=""><input type="button" class="btnUnban" value="Unban"></td>               
            </tr>
            <tr>
            <td data-label="User Account"><?php echo $_SESSION['userEmail'];?></td>
                <td data-label="Ban Status"><?php echo $_SESSION['banStatus'];?></td>
                <td data-label="Action"><a href=""><input type="button" class="btnBan" value="Ban"></a>&nbsp;<a href=""><input type="button" class="btnUnban" value="Unban"></td>              
            </tr>
            <tr>
            <td data-label="User Account"><?php echo $_SESSION['userEmail'];?></td>
                <td data-label="Ban Status"><?php echo $_SESSION['banStatus'];?></td>
                <td data-label="Action"><a href=""><input type="button" class="btnBan" value="Ban"></a>&nbsp;<a href=""><input type="button" class="btnUnban" value="Unban"></td>          
            </tr>
            <tr>
            <td data-label="User Account"><?php echo $_SESSION['userEmail'];?></td>
                <td data-label="Ban Status"><?php echo $_SESSION['banStatus'];?></td>
                <td data-label="Action"><a href=""><input type="button" class="btnBan" value="Ban"></a>&nbsp;<a href=""><input type="button" class="btnUnban" value="Unban"></td>  
            </tr>
        </tbody>
    </table> -->
</div>

    <?php
        $sql = "SELECT * FROM user where userEmail='ngjinyuan91@gmail.com' AND banStatus IS NULL ";
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
                echo "<td>" . $_SESSION['userEmail'] . "</td>";

            }

        
    ?>


<?php
include_once 'footer.php';
?>


</body>

</html>