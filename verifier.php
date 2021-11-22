<?php
session_start();
include_once 'header.php';
include_once 'includes/databaseHandler.inc.php';

?>
<link rel="stylesheet" href="header&footer.css">
<link rel="stylesheet" href="verifier.css">




<!--content here-->


<div class="container">
    <table>
        <caption>Waiting for Approval</caption>

        <thead>
            <tr>
                <th scope="col">Document ID</th>
                <th scope="col">IC</th>
                <th scope="col">FullName</th>
                <th scope="col">Document Location</th>
                <th scope="col">Registeration Type</th>
                <th scope="col">User Email</th>
                <th scope="col">Action</th>
            </tr>
        </thead>

        <?php
        $sql = " SELECT * FROM verifierdocument ";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);

        $userEmail = $_SESSION["userEmail"];

        if ($resultCheck > 0) {

            while ($row = mysqli_fetch_assoc($result)) {

                $documentID = $row['documentID'];
                $identityCard = $row['identityCard'];
                $fullNmae = $row['fullName'];
                $documentLocation = $row['documentLocation'];
                $registrationType = $row['registerationType'];
                $registryEmail = $row['userEmail'];

                // echo "<thead>";
                // echo "<tr>";
                // echo "<th scope='col'>documentID</th>";
                // echo "<th scope='col'>identityCard</th>";
                // echo "<th scope='col'>fullName</th>";
                // echo "<th scope='col'>documentLocation</th>";
                // echo "<th scope='col'>registrationType</th>";
                // echo "<th scope='col'>userEmail</th>";
                // echo "<th scope='col'>Action</th>";
                // echo "</tr>";
                // echo "</thead>";

                echo "<tbody>";
                echo "<tr>";
                echo "<td data-label='documentID' class='test'>" . $row['documentID'] . "</td>";
                echo "<td data-label='identityCard'>" . $row['identityCard'] . "</td>";
                echo "<td data-label='fullName'>" . $row['fullName'] . "</td>";
                echo "<td data-label='documentLocation'>" . "<a href='http://localhost/testing-fyp-2/".$row['documentLocation']."' download><button class='btnDocument'>Get Document</button></a>"  . "</td>";
                echo "<td data-label='registerationType'>" . $row['registerationType'] . "</td>";
                echo "<td data-label='userEmail'>" . $row['userEmail'] . "</td>";
                $verifierData = "userEmail=" . $row['userEmail'] . "&registerationType=" . $row['registerationType']; 
                echo "<td data-label='Action'>" . "<a href = 'includes/approve.inc.php?".$verifierData."'>'<button class='btnApprove'>Approve</button></a>" . "&nbsp" . "<a href = 'includes/reject.inc.php?".$verifierData."'>'<button class='btnReject'>Reject</button></a>" . "</td>";
            }
        } else {

        }
        ?>



        <!-- <tbody>
    <tr>
        <td data-label="documentID">Visa - 3412</td>
        <td data-label="identityCard">04/01/2016</td>
        <td data-label="fullName">$1,190</td>
        <td data-label="documentLocation">$1,190</td>
        <td data-label="registrationType">$1,190</td>
        <td data-label="userEmail">$1,190</td>
        <td data-label="Action">$1,190</td>

    </tr>
</tbody> -->
    </table>
</div>


<?php
// require_once 'includes/databaseHandler.inc.php';
// require_once 'includes/functions.inc.php';
// echo "friendCode : " . generateFriendCode($conn);
?>


<?php
include_once 'footer.php';
?>

    <script>
        function download(url){
            $.fileDownload(url)
                .done(function () { alert('File download a success!'); })
                .fail(function () { alert('File download failed!'); });
        }
    </script>
</body>