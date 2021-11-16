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
