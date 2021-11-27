|<?php
    session_start();
    include_once 'header.php';
    require_once 'includes/databaseHandler.inc.php';
    require_once 'includes/functions.inc.php';

    ?>
<link rel="stylesheet" href="header&footer.css">
<link rel="stylesheet" href="disableSeller.css">



<!--content here-->
<h1>Seller List</h1>
<div class="container">
    <table>

        <?php
        $sql = "SELECT * FROM users where sellerStatus = 'approved' ";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);

        if ($resultCheck > 0) {
            echo '<table>
            <caption>Disable User</caption>
            <thead>
                <tr>
                    <th scope="col">Seller Email</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead><tbody>';

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['userEmail'] . "</td>";
                echo "<td>" . $row['sellerStatus'] . "</td>";
                $userData = "userEmail=" . $row['userEmail'];
                echo "<td>" . "<a href='includes/disable.inc.php?" . $userData . "'>" . "<button class='btnDisable'>Disable</button></a>" . "</td>";
            }
            echo ' </tbody></table>';
        } else {
            echo '<p style = "color : #fff">There is no seller to disable</p>';
        }
        ?>
    </table>
</div>

<div class="container">
    <?php
    $sql = "SELECT * FROM users where sellerStatus = 'disable' ";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    if ($resultCheck > 0) {
        echo '<table>
            <caption>Enable User</caption>
            <thead>
                <tr>
                    <th scope="col">Seller Email</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead><tbody>';

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['userEmail'] . "</td>";
            echo "<td>" . $row['sellerStatus'] . "</td>";
            $userData = "userEmail=" . $row['userEmail'];
            echo "<td>" . "<a href='includes/enable.inc.php?" . $userData . "'>" . "<button class='btnEnable'>Enable</button></a>" . "</td>";
        }
        echo ' </tbody></table>';
    } else {
        echo '<p style = "color : #fff">There is no user to enable</p>';
    }
    ?>





    <?php
    // echo "friendCode : ".generateFriendCode($conn);
    ?>
    <?php
    include_once 'footer.php';
    ?>



    </body>

    </html>