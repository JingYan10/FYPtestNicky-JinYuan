<?php
session_start();
include_once 'header.php';

?>
<link rel="stylesheet" href="header&footer.css">



<!--content here-->

<h1>Page Header</h1>
<div class="container">
    <table>
        <caption>Waiting for Approval</caption>
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">User Email</th>
                <th scope="col">Action</th>

            </tr>
        </thead>
        <tbody>
            <tr>
                <td data-label="ID">Visa - 3412</td>
                <td data-label="User Email">04/01/2016</td>
                <td data-label="Action">$1,190</td>
            </tr>
        </tbody>
    </table>



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