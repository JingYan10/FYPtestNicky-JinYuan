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


<!--content here-->
<div class="container">
    <table>
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
                <td data-label="Ban Status"><?php echo $_SESSION[''];?></td>
                <td data-label="Action">$1,190</td>               
            </tr>
            <tr>
                <td scope="row" data-label="User Account">Visa - 6076</td>
                <td data-label="Ban Status">03/01/2016</td>
                <td data-label="Action">$2,443</td>             
            </tr>
            <tr>
                <td scope="row" data-label="User Account">Corporate AMEX</td>
                <td data-label="Ban Status">03/01/2016</td>
                <td data-label="Action">$1,181</td>          
            </tr>
            <tr>
                <td scope="row" data-label="User Acount">Visa - 3412</td>
                <td data-label="Ban Status">02/01/2016</td>
                <td data-label="Action">$842</td>
            </tr>
        </tbody>
    </table>
</div>

<?php
include_once 'footer.php';
?>



</body>

</html>