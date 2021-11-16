<?php

function emptyInputSignUp($firstName, $lastName, $email, $password, $confirmPassword)
{
    $result;
    if (empty($firstName) || empty($lastName) || empty($email) || empty($password) || empty($confirmPassword)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function invalidName($firstName, $lastName)
{
    $result;
    if (!preg_match("/^[a-zA-z]*$/", $firstName) || !preg_match("/^[a-zA-z]*$/", $lastName)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function invalidEmail($email)
{
    $result;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function matchingPassword($password, $confirmPassword)
{
    $result;
    if ($password != $confirmPassword) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function isExistUser($conn, $email)
{
    $sql = "SELECT * FROM users WHERE userEmail = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signUp.php?error=stmtFailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}



function createUser($conn, $firstName, $lastName, $email, $password, $userImage)
{
    $sql = "INSERT INTO users (userEmail, userFirstName, userLastName, userPassword, userRole, userImage) VALUES (?, ?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    $role = "member";
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signUp.php?error=stmtFailed");
        exit();
    }

    $encryptedPassword = password_hash($password, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt, "ssssss", $email, $firstName, $lastName, $encryptedPassword, $role, $userImage);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../signUp.php?error=none");
    exit();
}

function createSellerDocument($conn, $identityCard, $fullName, $documentLocation, $userEmail)
{
    require_once 'databaseHandler.inc.php';
    $registrationType = "seller";
    $sql = "INSERT INTO verifierdocument (identityCard, fullName, documentLocation, registerationType, userEmail) VALUES (?, ?, ?, ?, ? );";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signUp.php?error=stmtFailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sssss", $identityCard, $fullName, $documentLocation, $registrationType, $userEmail);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function updateUserSellerStatus($conn, $userEmail)
{
    // require_once 'databaseHandler.inc.php';

    $sellerStatus = "pending";
    $sql = "UPDATE users SET sellerStatus = '$sellerStatus' WHERE userEmail = '$userEmail'; ";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../user_profile_edit.php?error=stmtFailed");
        exit();
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../becomeSeller.php?error=none");
    exit();
}


function updateUser($conn, $firstName, $lastName, $email)
{
    $sql = "UPDATE users SET userFirstName = '$firstName', userLastName = '$lastName' WHERE userEmail = '$email'; ";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../user_profile_edit.php?error=stmtFailed");
        exit();
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../user_profile.php?error=none");
    exit();
}

function updateuserImage($conn, $email, $userImage)
{
    $sql = "UPDATE users SET userImage = '$userImage' WHERE userEmail = '$email'; ";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../user_profile_edit.php?error=stmtFailed");
        exit();
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../user_profile.php?error=none");
    exit();
}

function emptyInputLogin($email, $password)
{
    $result;
    if (empty($email) || empty($password)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function loginUser($conn, $email, $password)
{
    $isExistUser = isExistUser($conn, $email);

    if ($isExistUser == false) {
        header("location: ../login.php?error=wrongLogin");
        exit();
    }

    $encryptedPassword = $isExistUser["userPassword"];
    $checkPassword = password_verify($password, $encryptedPassword);

    if ($checkPassword == false) {
        header("location: ../login.php?error=wrongLogin");
        exit();
    } else if ($checkPassword == true) {
        session_start();
        $_SESSION["userEmail"] = $email;

        $sql = "SELECT * FROM users where userEmail='$_SESSION[userEmail]'";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        if ($resultCheck > 0) {
            while ($row = mysqli_fetch_assoc($result)) {

                $_SESSION["userRole"] = $row['userRole'];
            }
        }
        //Obtain user role
        if ($_SESSION["userRole"] == "admin") {
            header("location: ../adminProfile.php");
            exit();
        } else {
            header("location: ../index.php");
            exit();
        }
    }
}

function checkOldPassword($conn, $email, $oldPassword)
{
    $isExistUser = isExistUser($conn, $email);

    if ($isExistUser == false) {
        header("location: ../login.php?error=wrongLogin");
        exit();
    }

    $encryptedPassword = $isExistUser["userPassword"];
    $checkPassword = password_verify($oldPassword, $encryptedPassword);

    if ($checkPassword == false) {
        return false;
    } else if ($checkPassword == true) {
        return true;
    }
}
function changePassword($conn, $email, $newPassword)
{
    $encryptedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $sql = "UPDATE users SET userPassword = '$encryptedPassword' WHERE userEmail = '$email'; ";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../user_profile_changePassword.php?error=stmtFailed");
        exit();
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../user_profile.php?error=none");
    exit();
}
function invalidIC($IC)
{
    $result;

    if (strlen($IC) != 12 || !preg_match("/^[0-9]*$/", $IC)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}
function invalidFullName($fullName)
{
    $result;
    if (!preg_match("/^[a-zA-z]*$/", $fullName)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}
function invalidProductName($productName)
{
    $result;
    if (!preg_match("/^[a-zA-Z ]*$/", $productName)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}
function invalidProductQuantity($productQuantity)
{
    $result;
    if (!preg_match("/^[0-9]*$/", $productQuantity)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}
function invalidProductPrice($productPrice)
{
    $result;
    if (!preg_match("/^\d{0,8}(\.\d{1,4})?$/", $productPrice)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}
function createProduct($conn, $productName, $productImage, $productQuantity, $productPrice, $email)
{
    //$sql = "INSERT INTO product (productName, productImage, productQuantity, productPrice, userEmail) VALUES (?, ?, ?, ?, ?);";
    $sql = "INSERT INTO product (productName, productImage, productQuantity, productPrice, userEmail) VALUES ('$productName', '$productImage', $productQuantity, '$productPrice', '$email');";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../createProduct.php?error=stmtFailed");
        exit();
    }

    // $intProductQuantity = (int)$productQuantity;
    // $doubleProductPrice = (double)$productPrice;

    // mysqli_stmt_bind_param($stmt, "ssids", $productName, $productImage, $intProductQuantity, $doubleProductPrice, $userEmail);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../createProduct.php?error=none");
    exit();
}

function editProduct($conn, $productID, $productName, $productImage, $productQuantity, $productPrice, $email)
{
    $sql = "UPDATE product SET productName  = '$productName', productImage = '$productImage', productQuantity = $productQuantity, productPrice = $productPrice  WHERE productID = '$productID'; ";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../editProduct.php?error=stmtFailed");
        exit();
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../user_profile.php");
    exit();
}
function deleteProduct($conn, $productID, $email)
{
    $sql = "UPDATE product SET deleteStatus  = 'yes'  WHERE productID = '$productID'; ";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../deleteProduct.php?error=stmtFailed");
        exit();
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../user_profile.php");
    exit();
}

function banUser($conn, $email)
{
    $sql = "UPDATE users SET banStatus  = 'Banned' WHERE userEmail = '$email'; ";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../user_profile_ban.php?error=stmtFailed");
        exit();
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../user_profile_ban.php");
    exit();
}

function UnbanUser($conn, $email)
{
    $sql = "UPDATE users SET banStatus  = 'UnBanned' WHERE userEmail = '$email'; ";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../user_profile_ban.php?error=stmtFailed");
        exit();
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../user_profile_ban.php");
    exit();
}
function searchProduct($conn, $email, $searchData)
{
    $sql;
    if ($searchData == 'al') {
        $sql = "SELECT * FROM product WHERE userEmail='tete1234@gmail.com' AND deleteStatus IS NULL ";
    } else {
        $sql = "SELECT * FROM product WHERE userEmail='tete1234@gmail.com' AND deleteStatus IS NULL AND productName LIKE '%" . $searchData . "%' ";
    }
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . "P00" . $row['productID'] . "</td>";
            echo "<td>" . $row['productName'] . "</td>";
            echo "<td>" . "<img style='height:140px;width:140px;' src=" . $row['productImage'] . ">" . "</td>";
            echo "<td>" . $row['productQuantity'] . "</td>";
            echo "<td>" . $row['productPrice'] . "</td>";
            echo "<td>";
            $productData = "productID=" . $row['productID'] . "&productName=" . $row['productName'] . "&productImage=" . $row['productImage'] . "&productQuantity=" . $row['productQuantity'] . "&productPrice=" . $row['productPrice'];
            echo "<a href='editProduct.php?" . $productData . "'>" . "<button class='btnEditProduct'>edit</button></a>";
            echo "<a href='deleteProduct.php?" . $productData . "'>" . "<button class='btnDeleteProduct'>delete</button></a>";
            echo "</td>";
            echo "</tr>";
        }
    }
}
function generateFriendCode($conn)
{
    $friendCode = "";
    $count = 0;
    $sql = "SELECT * FROM users";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $databaseFriendCode =  $row['friendCode'];
        }
    }
    if ($databaseFriendCode != uniqid()) {
        $friendCode = uniqid() . uniqid();
        $count++;
    } else {
        $friendCode = uniqid() . uniqid() . $count;
    }
    return $friendCode;
}
function createBidding($conn, $productID, $biddingEndingTime, $biddingStartingPrice, $biddingEndingPrice, $totalBidder)
{

    $sql = "INSERT INTO bidding (biddingProductID, biddingEndingTime, biddingStartingPrice, biddingEndingPrice, totalBidder) VALUES ($productID, '$biddingEndingTime', $biddingStartingPrice, $biddingEndingPrice, $totalBidder);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../createBidding.php?error=stmtFailed");
        exit();
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../user_profile.php");
    exit();
}
function createBiddingParticipant($conn, $biddingID, $biddingPrice, $email, $totalBidder, $biddingTime)
{
    $sql = "INSERT INTO biddingparticipant (biddingID, userEmail, biddingPrice, biddingTime) VALUES ('$biddingID', '$email', $biddingPrice, '$biddingTime');";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../biddingDetail.php?error=stmtFailed");
        exit();
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
function updateBidding($conn, $biddingPrice, $totalBidder, $biddingID)
{
    $newTotalBidder = (int) $totalBidder + 1;
    $sql = "UPDATE bidding SET biddingEndingPrice = '$biddingPrice', totalBidder = '$newTotalBidder' WHERE biddingID = '$biddingID'; ";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../biddingDetail.php?error=stmtFailed");
        exit();
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
function deductCoin($conn, $biddingPrice, $email, $biddingID)
{
    $transactionStatus = "deduct1";
    $sql = "INSERT INTO coin (coinAmount, transactionStatus, userEmail, biddingID) VALUES ($biddingPrice, '$transactionStatus', '$email', '$biddingID');";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../biddingDetail.php?error=stmtFailed");
        exit();
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../biddingDetail.php?biddingID=" . $biddingID);
}
function updateBiddingWinner($conn)
{
    date_default_timezone_set("Asia/Kuala_Lumpur");
    $currentDate = date("d/m/y h:i:s");

    $sql = "SELECT * FROM bidding ";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $_SESSION["biddingEndingTime"] = $row['biddingEndingTime'];

            $timeBiddingEndingTime = strtotime($_SESSION["biddingEndingTime"]);
            $dateBiddingEndingTime = date('d/m/y h:i:s', $timeBiddingEndingTime);


            // echo "bidding ending time -> ".$dateBiddingEndingTime."<br>";
            // echo "current time -> ".$currentDate."<br>";

            if ($dateBiddingEndingTime <= $currentDate) {
                $_SESSION["biddingID"] = $row['biddingID'];
                $_SESSION["biddingEndingPrice"] = $row['biddingEndingPrice'];
            }
        }
        $biddingID = $_SESSION["biddingID"];
        $biddingEndingPrice = $_SESSION["biddingEndingPrice"];

        // echo "biddingID : ".$biddingID."<br>";
        // echo "biddingPrice : ".$biddingEndingPrice."<br>";

        $sql = "SELECT * FROM biddingparticipant where biddingID = '$biddingID' AND biddingPrice = $biddingEndingPrice ";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);

        if ($resultCheck > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $_SESSION["biddingWinner"] = $row['userEmail'];
            }
        }
        // echo $_SESSION["biddingWinner"];
        $biddingWinner = $_SESSION["biddingWinner"];

        $sql = "UPDATE bidding SET biddingWinner = '$biddingWinner' WHERE biddingID = $biddingID;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../pinChangePassword.php?error=stmtFailed");
            exit();
        }
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        $transactionStatus = "deduct2";
        $sql = "UPDATE coin SET transactionStatus = '$transactionStatus' WHERE biddingID = $biddingID AND coinAmount = $biddingEndingPrice ";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../pinChangePassword.php?error=stmtFailed");
            exit();
        }
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}
function addToCart($conn, $productID, $productQuantity, $userEmail)
{
    $sql = "INSERT INTO cart (productID, productQuantity, userEmail) VALUES ('$productID', $productQuantity, '$userEmail');";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../product.php?error=stmtFailed");
        exit();
    }

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../product.php?error=none");
    exit();
}

function removeFromCart($conn, $productID,  $userEmail){
    $sql = "DELETE FROM cart WHERE productID='$productID' AND userEmail = '$userEmail';";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../cart.php?error=stmtFailed");
        exit();
    }

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../cart.php?error=none");
    exit();
}
function searchBidding($conn, $searchData)
{
    $sql;
    if ($searchData == 'al') {
        $sql = "SELECT * FROM bidding WHERE biddingWinner IS NULL ";
    } else {
        $sql = "SELECT * FROM bidding WHERE biddingID = '$searchData' ";
    }
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . "B00" . $row['biddingID'] . "</td>";
            echo "<td>" . $row['biddingProductID'] . "</td>";
            date_default_timezone_set("Asia/Kuala_Lumpur");
            $biddingEndingTime = $row['biddingEndingTime'];
            $timeBiddingEndingTime = strtotime($biddingEndingTime);
            $dateBiddingEndingTime = date("d M Y h:i:s", $timeBiddingEndingTime);
            echo "<td>" . $dateBiddingEndingTime . "</td>";
            echo "<td>" . $row['biddingStartingPrice'] . "</td>";
            echo "<td>" . $row['biddingEndingPrice'] . "</td>";
            echo "<td>" . $row['totalBidder'] . "</td>";
            echo "<td>";
            $biddingData = "biddingID=" . $row['biddingID'];
            echo "<a href='biddingDetail.php?" . $biddingData . "'>" . "<button class='btnJoinBidding'>join</button></a>";
            echo "</td>";
            echo "</tr>";
        }
    }
}
function pinChangePassword($conn, $email, $newPassword)
{
    $encryptedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $sql = "UPDATE users SET userPassword = '$encryptedPassword' WHERE userEmail = '$email'; ";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../pinChangePassword.php?error=stmtFailed");
        exit();
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../login.php");
    exit();
}
function createDelivererDocument($conn, $identityCard, $fullName, $documentLocation, $userEmail)
{
    require_once 'databaseHandler.inc.php';
    $registrationType = "deliverer";
    $sql = "INSERT INTO verifierdocument (identityCard, fullName, documentLocation, registerationType, userEmail) VALUES (?, ?, ?, ?, ? );";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signUp.php?error=stmtFailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sssss", $identityCard, $fullName, $documentLocation, $registrationType, $userEmail);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
function updateUserDelivererStatus($conn, $userEmail)
{
    // require_once 'databaseHandler.inc.php';

    $delivererStatus = "pending";
    $sql = "UPDATE users SET delivererStatus = '$delivererStatus' WHERE userEmail = '$userEmail'; ";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../becomeDeliverer.php?error=stmtFailed");
        exit();
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../becomeDeliverer.php?error=none");
    exit();
}
function checkWorkingShiftAvailability($conn, $workingShift)
{
    $count = 0;
    $sql = "SELECT * FROM workingshift WHERE shiftNO = '$workingShift';";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $count++;
        }
    }
    if ($count >= 2) {
        return false;
    } else {
        return true;
    }
}
function createWorkingShift($conn, $workingShift, $email)
{
    $workingStartingTime = "";
    $workingEndingTime = "";
    switch ($workingShift) {
        case "shift1":
            $workingStartingTime = "08:00";
            $workingEndingTime = "10:00";
            break;
        case "shift2":
            $workingStartingTime = "10:00";
            $workingEndingTime = "12:00";
            break;
        case "shift3":
            $workingStartingTime = "12:00";
            $workingEndingTime = "14:00";
            break;
        case "shift4":
            $workingStartingTime = "14:00";
            $workingEndingTime = "16:00";
            break;
        case "shift5":
            $workingStartingTime = "16:00";
            $workingEndingTime = "18:00";
            break;
        case "shift6":
            $workingStartingTime = "18:00";
            $workingEndingTime = "20:00";
            break;
        case "shift7":
            $workingStartingTime = "20:00";
            $workingEndingTime = "22:00";
            break;
    }
    // echo "shift : ". $workingShift."<br>";
    // echo "startingTime : ". $workingStartingTime."<br>";
    // echo "endingTime : ". $workingEndingTime."<br>";

    $taskDone = 0;
    $sql = "INSERT INTO workingshift (shiftNO, workingStartingTime, workingEndingTime, userEmail, taskDone) VALUES ('$workingShift', '$workingStartingTime', '$workingEndingTime', '$email', $taskDone);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../selectWorkingShift.php?error=stmtFailed");
        exit();
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../user_profile.php");
    exit();
}
function createSoldProduct($conn, $productID, $productQuantity, $paymentID, $email)
{

    $sql = "INSERT INTO soldProduct (productID, productQuantity, paymentID, userEmail) VALUES ('$productID', $productQuantity, '$paymentID', '$email')";

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../buyProduct.inc.php?error=stmtFailed");
        exit();
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
function findSoldProductID($conn)
{
    $sql = "SELECT * FROM soldProduct";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    $soldProductID = 0;
    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $soldProductID++;
        }
    }
}
function createBoughtProductData($conn, $productID, $productQuantity, $paymentID, $email)
{

    //insert product data to soldProduct
    $sql = "INSERT INTO soldProduct (productID, productQuantity, paymentID, userEmail) VALUES ('$productID', $productQuantity, '$paymentID', '$email')";

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../buyProduct.inc.php?error=stmtFailed1");
        exit();
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);


    //find just added soldProductID
    $sql = "SELECT * FROM soldProduct";

    $stmt = mysqli_stmt_init($conn);
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    $soldProductID = 0;
    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $soldProductID++;
        }
    }


    // obtain latest shiftNo result from shipment

    $sql = "SELECT * FROM shipment";

    $stmt = mysqli_stmt_init($conn);
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    $shipmentResult = 0;
    $shiftNo = 0;

    $databaseShiftNo = "";
    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $shipmentResult++;
            $shiftNo = (int) $row['shiftNO'];
        }
    }

    if ($shiftNo == 0) {
        $shiftNo = 1;
    } else if ($shiftNo == 7) {
        $shiftNo = 1;
    } else {
        $shiftNo += 1;
    }




    // find deliverer with shift NO, assign current shipment to deliverer by email

    $workingShiftNo = "shift" . $shiftNo;
    $sql = "SELECT * FROM workingShift where shiftNO = '$workingShiftNo';";

    $stmt = mysqli_stmt_init($conn);
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    $foundDelivererData = array(); //store useremail & taskdone
    $foundDelivererData2 = array(array());

    $assignedDelivererEmail = "";


    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $foundDelivererData[] = $row['userEmail'];
            $foundDelivererData[] += $row['taskDone'];
        }
        if ($resultCheck == 1) {
            $firstDelivererEmail = $foundDelivererData[0];
            $assignedDelivererEmail = $firstDelivererEmail;
        }
        if ($resultCheck == 2) {
            $firstDelivererEmail = $foundDelivererData[0];
            $firstDelivererTaskDone = $foundDelivererData[1];
            $secondDelivererEmail = $foundDelivererData[2];
            $secondDelivererTaskDone = $foundDelivererData[3];

            // assign job to the deliverer based on the tasks that they've done
            if ($firstDelivererTaskDone == 0 && $secondDelivererTaskDone == 0) {
                $assignedDelivererEmail = $firstDelivererEmail;
            } else if ($firstDelivererTaskDone > $secondDelivererTaskDone) {
                $assignedDelivererEmail = $secondDelivererEmail;
            } else if ($secondDelivererTaskDone > $firstDelivererTaskDone) {
                $assignedDelivererEmail = $firstDelivererEmail;
            }
        }
    } else {
        $sql = "SELECT * FROM workingShift";

        $stmt = mysqli_stmt_init($conn);
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);

        if ($resultCheck > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $foundDelivererData2['shiftNO'][] = $row['shiftNo'];
                $foundDelivererData2['taskDone'][] = $row['taskDone'];
                $foundDelivererData2['userEmail'][] = $row['userEmail'];

                //$foundDelivererData2 = $row['shiftNO'];
            }
        }
    }

    //shipmentDate = +1day of the product purchase day
    date_default_timezone_set("Asia/Kuala_Lumpur");
    $shipmentDate = date('d/m/y h:i:s', strtotime('+1 day'));



    //insert into shipment

    $shipmentStatus = "taskAssigned";
    $sql = "INSERT INTO shipment (soldProductID, soldProductQuantity, shipmentDate, userEmail, shipmentStatus, shiftNO) VALUES ('$soldProductID', $productQuantity, '$shipmentDate', '$assignedDelivererEmail','$shipmentStatus',$shiftNo)";

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../buyProduct.inc.php?error=stmtFailed2");
        exit();
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    //find just added shipmentID
    $sql = "SELECT * FROM shipment";

    $stmt = mysqli_stmt_init($conn);
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    $shipmentID = 0;
    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $shipmentID++;
        }
    }


    // get latest shipmentID
    $sql = "SELECT * FROM shipment";

    $stmt = mysqli_stmt_init($conn);
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    $shipmentID = "";


    $databaseShiftNo = "";
    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $shipmentID = $row['shipmentID'];
        }
    }
    // get latest soldProductID
    $sql = "SELECT * FROM soldProduct";

    $stmt = mysqli_stmt_init($conn);
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    $soldProductID = "";


    $databaseShiftNo = "";
    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $soldProductID = $row['soldProductID'];
        }
    }

    //update soldProduct with gotten shipmentID

    $sql = "UPDATE soldProduct SET shipmentID = '$shipmentID' WHERE soldProductID = $soldProductID  ";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../buyProduct.inc.php?error=stmtFailed3");
        exit();
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    echo "done";

    //get deliverer current taskdone
    $sql = "SELECT * FROM workingshift WHERE userEmail = '$assignedDelivererEmail'";

    $stmt = mysqli_stmt_init($conn);
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    $currentTaskDone = 0;


    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $currentTaskDone = (int) $row['taskDone'];
        }
    }

    //update taskdone of deliverer at workingshift
    $newTaskDone = $currentTaskDone + 1;

    $sql = "UPDATE workingshift SET taskDone = '$newTaskDone' WHERE  userEmail = '$assignedDelivererEmail'  ";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../buyProduct.inc.php?error=stmtFailed3");
        exit();
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    echo "done";
}
function testing2($conn)
{
    $sql = "SELECT * FROM workingShift";

    $stmt = mysqli_stmt_init($conn);
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    $foundDelivererData2 = array();
    $totalResult = 0;
    $firstShiftNo = "";
    $totalShiftNoSet = 1;


    $shift1TaskDone = 0;
    $shift2TaskDone = 0;
    $shift3TaskDone = 0;
    $shift4TaskDone = 0;
    $shift5TaskDone = 0;
    $shift6TaskDone = 0;
    $shift7TaskDone = 0;

    if ($resultCheck > 0) {

        while ($row = mysqli_fetch_assoc($result)) {
            $foundDelivererData2['shiftNO'][] = $row['shiftNO'];
            $foundDelivererData2['taskDone'][] = $row['taskDone'];
            $foundDelivererData2['userEmail'][] = $row['userEmail'];
            $totalResult++;

            //$foundDelivererData2 = $row['shiftNO'];
        }
        // find how many different set in shiftNO
        for ($i = 0; $i < $totalResult; $i++) {
            $firstShiftNo = $foundDelivererData2['shiftNO'][0];
            if ($foundDelivererData2['shiftNO'][$i] != $firstShiftNo) {
                $totalShiftNoSet++;
            }
            // combine taskDone data if ShiftNO is same
            switch ($foundDelivererData2['shiftNO'][$i]) {
                case "shift1":
                    $shift1TaskDone += $foundDelivererData2['taskDone'][$i];
                    break;
                case "shift2":
                    $shift2TaskDone += $foundDelivererData2['taskDone'][$i];
                    break;
                case "shift3":
                    $shift3TaskDone += $foundDelivererData2['taskDone'][$i];
                    break;
                case "shift4":
                    $shift4TaskDone += $foundDelivererData2['taskDone'][$i];
                    break;
                case "shift5":
                    $shift5TaskDone += $foundDelivererData2['taskDone'][$i];
                    break;
                case "shift6":
                    $shift6TaskDone += $foundDelivererData2['taskDone'][$i];
                    break;
                case "shift7":
                    $shift7TaskDone += $foundDelivererData2['taskDone'][$i];
                    break;
            }
            // remove all taskdone which is 0
            
        
            // get highest taskDone
            $lowestTaskDone = min(
                $shift1TaskDone,
                $shift2TaskDone,
                $shift3TaskDone,
                $shift4TaskDone,
                $shift5TaskDone,
                $shift6TaskDone,
                $shift7TaskDone
            );
        }
    }

    return $lowestTaskDone;
}
