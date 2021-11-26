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

function invalidPhoneNumber($phoneNumber)
{
    $result;
    if (!preg_match("/^(\+?6?01)[0-46-9]-*[0-9]{7,8}$/", $phoneNumber)) {
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



function createUser($conn, $firstName, $lastName, $email, $password, $userImage, $userPhoneNumber, $userHouseAddress)
{
    $sql = "INSERT INTO users (userEmail, userFirstName, userLastName, userPassword, userRole, userImage, userPhoneNumber, userHouseAddress) VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    $role = "member";
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signUp.php?error=stmtFailed");
        exit();
    }

    $encryptedPassword = password_hash($password, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt, "ssssssss", $email, $firstName, $lastName, $encryptedPassword, $role, $userImage, $userPhoneNumber, $userHouseAddress);
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
                $_SESSION["banStatus"] = $row['banStatus'];

            }
        }
        //Obtain user role
        if ($_SESSION["userRole"] == "admin") {
            header("location: ../adminProfile.php");
            exit();
        } else if ($_SESSION["banStatus"] == "Banned") {
            header("location: ../login.php?error=banned");
            exit();
        }
        else {

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

function approveUser($conn, $registryEmail, $registerationType)
{
    $sql = "UPDATE users SET userRole  = '$registerationType' WHERE userEmail = '$registryEmail'; ";

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../verifier.php?error=stmtFailed");
        exit();
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../verifier.php");
    $sql = "DELETE FROM verifierdocument WHERE userEmail='$registryEmail' AND registerationType = '$registerationType';";
    exit();
}

function rejectUser($conn, $registryEmail, $registerationType)
{

    $sql = "DELETE FROM verifierdocument WHERE userEmail='$registryEmail' AND registerationType = '$registerationType';";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../verifier.php?error=stmtFailed");
        exit();
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../verifier.php");
    exit();
}

function searchProduct($conn, $email, $searchData)
{
    $sql;
    if ($searchData == 'all') {
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

function searchProductForProduct($conn, $email, $searchData)
{
    
    
        $sql = "SELECT * FROM product WHERE productQuantity IS NOT NULL ";
  
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

function decreaseProductQuantityForBidding($conn, $productID, $productQuantity)
{
    echo $productQuantity;
    echo $productID;
    $deductQuantity = $productQuantity - 1;
    echo $deductQuantity;
    $sql = "UPDATE product SET productQuantity = '$deductQuantity' WHERE productID = '$productID'; ";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../userProfile.php?error=stmtFailed12");
        exit();
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
function createPromotion($conn, $productID, $promotionRate, $promotionEndingDate)
{

    $sql = "INSERT INTO promotion (productID, promotionRate, promotionEndingDate) VALUES ('$productID', '$promotionRate', '$promotionEndingDate');";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../createPromotion.php?error=stmtFailed");
        exit();
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../user_profile.php");
    exit();
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
function increaseProductQuantityBidding($conn, $productID)
{
    $sql = "UPDATE product SET productQuantity = productQuantity+1 WHERE productID = '$productID'; ";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../userProfile.php?error=stmtFailed13");
        exit();
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
function refundBiddingCoin($conn, $biddingID)
{
    $sql = "UPDATE coin SET transactionStatus = 'biddingRefund' WHERE biddingID = $biddingID AND transactionStatus = 'deduct1';";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../pinChangePassword.php?error=stmtFailed15");
        exit();
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
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
                $_SESSION["totalBidder"] = $row['totalBidder'];
                $_SESSION["biddingProductID"] = $row['biddingProductID'];
            }
        }
        $biddingID = $_SESSION["biddingID"];
        $biddingEndingPrice = $_SESSION["biddingEndingPrice"];
        $totalBidder = $_SESSION["totalBidder"];

        // echo "biddingID : ".$biddingID."<br>";
        // echo "biddingPrice : ".$biddingEndingPrice."<br>";


        if (!$totalBidder <= 0) { // got participant
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

            //update bidding winner userEmail
            $sql = "UPDATE bidding SET biddingWinner = '$biddingWinner' WHERE biddingID = $biddingID;";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("location: ../pinChangePassword.php?error=stmtFailed");
                exit();
            }
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            //refund coin to specific user who joined the bidding : working
            refundBiddingCoin($conn, $biddingID);

            //deduct coin from specific user
            $transactionStatus = "deduct2";
            $sql = "UPDATE coin SET transactionStatus = '$transactionStatus' WHERE biddingID = $biddingID AND coinAmount = $biddingEndingPrice ";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("location: ../pinChangePassword.php?error=stmtFailed");
                exit();
            }
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        } else { // no participant
            //increase specific productID by one 
            $biddingProductID = $_SESSION["biddingProductID"];
            increaseProductQuantityBidding($conn, $biddingProductID);
        }
    }
}
function addToCart($conn, $productID, $productQuantity, $userEmail)
{
    $sql = "INSERT INTO cart (productID, productQuantity, userEmail) VALUES ('$productID', $productQuantity, '$userEmail');";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../product.php?error=stmtFailed6");
        exit();
    }

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../product.php?error=none");
    exit();
}
function addToWishlist($conn, $productID, $userEmail)
{
    $sql = "INSERT INTO wishlist (productID, userEmail) VALUES ('$productID', '$userEmail');";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../product.php?error=stmtFailed");
        exit();
    }

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../product.php?error=none2");
    exit();
}
function removeFromCart($conn, $productID,  $userEmail)
{
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

function removeAllFromCart($conn, $userEmail)
{
    $sql = "DELETE FROM cart WHERE userEmail = '$userEmail';";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../cart.php?error=stmtFailed");
        exit();
    }

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../product.php?error=none");
    exit();
}


function searchBidding($conn, $searchData)
{
    $sql;
    if ($searchData == 'all') {
        $sql = "SELECT * FROM bidding ";
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
            if ($row['biddingWinner'] == null) {
                echo "<a href='biddingDetail.php?" . $biddingData . "'>" . "<button class='btnJoinBidding'>join</button></a>";
            }
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

function generateNewShipmentArrangementNo($conn)
{
    //find latest shipmentArrangementNo from soldProduct
    $sql = "SELECT * FROM soldProduct";

    $stmt = mysqli_stmt_init($conn);
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    $soldProductNewShipmentArrangementNo = "";
    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            // print_r($row);
            // die();
            $soldProductNewShipmentArrangementNo = $row['shipmentArrangementNo'];
        }
    } else {
        $soldProductNewShipmentArrangementNo = 0;
    }

    if ($soldProductNewShipmentArrangementNo == 0) {
        $soldProductNewShipmentArrangementNo = 1;
    } else {
        $soldProductNewShipmentArrangementNo++;
    }

    return $soldProductNewShipmentArrangementNo;
}
function createSoldProductData($conn, $productID, $productQuantity, $paymentID, $email, $arrangementNo)
{
    //insert product data to soldProduct
    $sql = "INSERT INTO soldProduct (productID, productQuantity, paymentID, userEmail, shipmentArrangementNo) VALUES ('$productID', $productQuantity, '$paymentID', '$email', '$arrangementNo')";

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../buyProduct.inc.php?error=stmtFailed92");
        exit();
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function getWorkingShiftReplacement($conn)
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
        }
        $arrayShiftTaskDone = array(
            array('shiftNO' => 'shift1', 'taskDone' => $shift1TaskDone),
            array('shiftNO' => 'shift2', 'taskDone' => $shift2TaskDone),
            array('shiftNO' => 'shift3', 'taskDone' => $shift3TaskDone),
            array('shiftNO' => 'shift4', 'taskDone' => $shift4TaskDone),
            array('shiftNO' => 'shift5', 'taskDone' => $shift5TaskDone),
            array('shiftNO' => 'shift6', 'taskDone' => $shift6TaskDone),
            array('shiftNO' => 'shift7', 'taskDone' => $shift7TaskDone),
        );

        // remove all taskdone which is 0
        $filterShiftTaskDone1 = array_filter($arrayShiftTaskDone, function ($var) {
            return ($var['taskDone'] != 0);
        });


        // get shift that has lowest task done 
        $min = min(array_column($filterShiftTaskDone1, 'taskDone'));

        $data = $filterShiftTaskDone1;

        $getLowestTaskDone =  array_filter(array_map(function ($data) use ($min) {
            return $data['taskDone'] == $min ? $data : null;
        }, $data));

        //reassign the index of the array incase two result ease to trace
        $newGetlowestTaskDone = array_values($getLowestTaskDone);


        $shiftResult = array_column($newGetlowestTaskDone, 'shiftNO');

        // get only the first data
        $finalShiftResult = $shiftResult[0];
    }
    return $finalShiftResult;
}
function generateNewShiftNo($conn)
{
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

    return $shiftNo;
}
function decideDeliverer($conn, $shiftNo)
{
    // find deliverer with shift NO, assign current shipment to deliverer by email

    $workingShiftNo = "shift" . $shiftNo;
    $sql = "SELECT * FROM workingShift where shiftNO = '$workingShiftNo';";

    $stmt = mysqli_stmt_init($conn);
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    $foundDelivererData = array(); //store useremail & taskdone


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
            if ($firstDelivererTaskDone == $secondDelivererTaskDone) {
                $assignedDelivererEmail = $firstDelivererEmail;
            }
            if ($firstDelivererTaskDone > $secondDelivererTaskDone) {
                $assignedDelivererEmail = $secondDelivererEmail;
            } else if ($secondDelivererTaskDone > $firstDelivererTaskDone) {
                $assignedDelivererEmail = $firstDelivererEmail;
            }
        }
    } else {
        $workingShiftReplacement = getWorkingShiftReplacement($conn);
        $sql = "SELECT * FROM workingShift where shiftNO = '$workingShiftReplacement'";

        $stmt = mysqli_stmt_init($conn);
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);


        if ($resultCheck > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $foundDelivererData[] = $row['userEmail'];
                $foundDelivererData[] += $row['taskDone'];
            }
            if ($resultCheck == 1) {
                $firstDelivererEmail = $foundDelivererData[0];
                $assignedDelivererEmail = $firstDelivererEmail;
                echo "loop1";
            }
            if ($resultCheck == 2) {
                $firstDelivererEmail = $foundDelivererData[0];
                $firstDelivererTaskDone = $foundDelivererData[1];
                $secondDelivererEmail = $foundDelivererData[2];
                $secondDelivererTaskDone = $foundDelivererData[3];

                // assign job to the deliverer based on the tasks that they've done
                if ($firstDelivererTaskDone == $secondDelivererTaskDone) {
                    $assignedDelivererEmail = $firstDelivererEmail;
                }
                if ($firstDelivererTaskDone > $secondDelivererTaskDone) {
                    $assignedDelivererEmail = $secondDelivererEmail;
                } else if ($secondDelivererTaskDone > $firstDelivererTaskDone) {
                    $assignedDelivererEmail = $firstDelivererEmail;
                }
            }
        }
        $shiftNo = substr($workingShiftReplacement, 5);
    }

    return array($assignedDelivererEmail, $shiftNo);
}
function createShipmentData($conn, $productID, $productQuantity, $paymentID, $email, $arrangementNo, $shiftNo, $assignedDelivererEmail)
{

    //shipmentDate = +1day of the product purchase day
    date_default_timezone_set("Asia/Kuala_Lumpur");
    $shipmentDate = date('d/m/y h:i:s', strtotime('+1 day'));

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

    //insert into shipment

    $shipmentStatus = "taskAssigned";
    $sql = "INSERT INTO shipment (soldProductID, soldProductQuantity, shipmentDate, userEmail, shipmentStatus, shiftNO, shipmentArrangementNo) VALUES ('$soldProductID', $productQuantity, '$shipmentDate', '$assignedDelivererEmail','$shipmentStatus',$shiftNo,'$arrangementNo')";

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../buyProduct.inc.php?error=stmtFailed2");
        exit();
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);


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
}
function updateTaskDoneDeliverer($conn, $assignedDelivererEmail)
{
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
    echo "done"; //remove this
}
function updateShipmentStatus($conn, $shipmentArrangementNo)
{
    $shipmentStatus = "delivering";
    $sql = "UPDATE shipment SET shipmentStatus = '$shipmentStatus' WHERE shipmentArrangementNo = '$shipmentArrangementNo'; ";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../viewShipmentDetail.php?error=stmtFailed");
        exit();
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
function generateDeliveryPin($conn, $clientEmail)
{
    $shipmentStatus = "delivering";
    $deliveryPin  = uniqid();
    $sql = "update users set deliveryPin='$deliveryPin' where userEmail = '$clientEmail'; ";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../viewShipmentDetail.php?error=stmtFailed");
        exit();
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../viewShipmentDetail.php?error=noneDelivering");
    exit();
}
function verifyDeliveryPin($conn, $deliveryPin, $clientEmail)
{
    $result = false;
    //get delivery pin from client email
    $sql = "SELECT * FROM users WHERE userEmail = '$clientEmail'";

    $stmt = mysqli_stmt_init($conn);
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    $databaseDeliveryPin = "";


    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $databaseDeliveryPin = $row['deliveryPin'];
        }
    }

    if ($deliveryPin == $databaseDeliveryPin) {
        $result = true;
    } else {
        $result = false;
    }

    return $result;
}
function updateDeliveryDeliveredStatus($conn, $shipmentArrangementNo)
{
    $shipmentStatus = "delivered";
    $sql = "UPDATE shipment SET shipmentStatus = '$shipmentStatus' WHERE  shipmentArrangementNo = '$shipmentArrangementNo'  ";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../buyProduct.inc.php?error=stmtFailed3");
        exit();
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
function searchShipment($conn, $email, $searchData)
{
    $sql;
    if ($searchData == 'all') {
        $sql = "SELECT * FROM shipment where userEmail='$email' GROUP BY shipmentArrangementNo; ";
    } else {
        $sql = "SELECT * FROM shipment WHERE userEmail='$email' AND shipmentStatus LIKE '%" . $searchData . "%' GROUP BY shipmentArrangementNo; ";
    }
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['shipmentDate'] . "</td>";
            echo "<td>" . $row['shipmentArrangementNo'] . "</td>";
            echo "<td>" . $row['shipmentStatus'] . "</td>";
            echo "<td>";
            $shipmentData = "shipmentID=" . $row['shipmentID'] . "&soldProductID=" . $row['soldProductID'] . "&soldProductQuantity=" . $row['soldProductQuantity'] . "&shipmentDate=" . $row['shipmentDate'] . "&shipmentArrangementNo=" . $row['shipmentArrangementNo'] . "&shipmentStatus=" . $row['shipmentStatus'];
            echo "<a href='viewShipmentDetail.php?" . $shipmentData . "'>" . "<button class='btnEditProduct'>view</button></a>";
            echo "</td>";
            echo "</tr>";
        }
    }
}
function createProductReviewingNotification($conn, $productID, $userEmail)
{
    //insert product data to soldProduct

    $notificationType = "productReview";
    $notificationDescription = "review a bought product";
    $neededID = $productID;
    $typeID = "productID";
    $receiverEmail = $userEmail;

    $sql = "INSERT INTO notification (notificationType, notificationDescription, neededID, typeID, receiverEmail) VALUES ('$notificationType','$notificationDescription','$neededID','$typeID','$receiverEmail');";

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../buyProduct.inc.php?error=stmtFailed10");
        exit();
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
function createProductRating($conn, $productID, $productRating, $userEmail)
{
    $sql = "INSERT INTO rating (productID, ratingNO, userEmail) VALUES ('$productID', '$productRating', '$userEmail');";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../productReview.php?error=stmtFailed90");
        exit();
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
function createProductComment($conn, $productID, $productComment, $userEmail)
{
    $sql = "INSERT INTO comments (productID, productComment, userEmail) VALUES ('$productID', '$productComment', '$userEmail');";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../productReview.php?error=stmtFailed2");
        exit();
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
function deleteProductReviewNotification($conn, $productID, $userEmail)
{
    $sql = "DELETE FROM notification WHERE neededID ='$productID' AND receiverEmail = '$userEmail';";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../productReview.php?error=stmtFailed3");
        exit();
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../product.php?error=none");
    exit();
}

function updateProduct($conn, $email, $productID, $productQuantity)
{
    $sql = "UPDATE product set productQuantity = '$productQuantity' where productID = '$productID'";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../cart.php?error=stmtFailed");
        exit();
    }

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    // header("location: ../cart.php?error=none");
    // exit();
}

function makePaymentOnSuccess($conn, $paymentAmount, $userEmail, $paymentStatus, $paymentDate)
{
    $sql = "INSERT INTO payment (paymentAmount, userEmail, paymentStatus, paymentDate) VALUES ('$paymentAmount', '$userEmail', '$paymentStatus', '$paymentDate');";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../cart.php?error=stmtFailed123");
        exit();
    }

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../cart.php?error=none");
    exit();
}
function makePaymentOnFail($conn, $paymentAmount, $userEmail, $paymentStatus, $paymentDate)
{
    $sql = "INSERT INTO payment (paymentAmount, userEmail, paymentStatus, paymentDate) VALUES ('$paymentAmount', '$userEmail', '$paymentStatus', '$paymentDate');";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../cart.php?error=stmtFailed123");
        exit();
    }

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../cart.php?error=none");
    exit();
}
function productRatingResult($finalRating)
{
    $printResult = "";
    switch ($finalRating) {
        case 0:
            $printResult =
                "<i class='fa fa-star fa-1x' data-index='0' style='color:black'></i>" .
                "<i class='fa fa-star fa-1x' data-index='0' style='color:black'></i>" .
                "<i class='fa fa-star fa-1x' data-index='0' style='color:black'></i>" .
                "<i class='fa fa-star fa-1x' data-index='0' style='color:black'></i>" .
                "<i class='fa fa-star fa-1x' data-index='0' style='color:black'></i>";
            break;
        case 1:
            $printResult =
                "<i class='fa fa-star fa-1x' data-index='0' style='color:yellow'></i>" .
                "<i class='fa fa-star fa-1x' data-index='0' style='color:black'></i>" .
                "<i class='fa fa-star fa-1x' data-index='0' style='color:black'></i>" .
                "<i class='fa fa-star fa-1x' data-index='0' style='color:black'></i>" .
                "<i class='fa fa-star fa-1x' data-index='0' style='color:black'></i>";
            break;
        case 2:
            $printResult =
                "<i class='fa fa-star fa-1x' data-index='0' style='color:yellow'></i>" .
                "<i class='fa fa-star fa-1x' data-index='0' style='color:yellow'></i>" .
                "<i class='fa fa-star fa-1x' data-index='0' style='color:black'></i>" .
                "<i class='fa fa-star fa-1x' data-index='0' style='color:black'></i>" .
                "<i class='fa fa-star fa-1x' data-index='0' style='color:black'></i>";
            break;
        case 3:
            $printResult =
                "<i class='fa fa-star fa-1x' data-index='0' style='color:yellow'></i>" .
                "<i class='fa fa-star fa-1x' data-index='0' style='color:yellow'></i>" .
                "<i class='fa fa-star fa-1x' data-index='0' style='color:yellow'></i>" .
                "<i class='fa fa-star fa-1x' data-index='0' style='color:black'></i>" .
                "<i class='fa fa-star fa-1x' data-index='0' style='color:black'></i>";
            break;
        case 4:
            $printResult =
                "<i class='fa fa-star fa-1x' data-index='0' style='color:yellow'></i>" .
                "<i class='fa fa-star fa-1x' data-index='0' style='color:yellow'></i>" .
                "<i class='fa fa-star fa-1x' data-index='0' style='color:yellow'></i>" .
                "<i class='fa fa-star fa-1x' data-index='0' style='color:yellow'></i>" .
                "<i class='fa fa-star fa-1x' data-index='0' style='color:black'></i>";
            break;
        case 5:
            $printResult =
                "<i class='fa fa-star fa-1x' data-index='0' style='color:yellow'></i>" .
                "<i class='fa fa-star fa-1x' data-index='0' style='color:yellow'></i>" .
                "<i class='fa fa-star fa-1x' data-index='0' style='color:yellow'></i>" .
                "<i class='fa fa-star fa-1x' data-index='0' style='color:yellow'></i>" .
                "<i class='fa fa-star fa-1x' data-index='0' style='color:yellow'></i>";
            break;
        default:
    }
    return $printResult;
}
function removeFromWishlist($conn, $userEmail, $productID)
{
    $sql = "DELETE FROM wishlist WHERE userEmail='$userEmail' AND productID='$productID' ";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../wishlist.php?error=stmtFailed");
        exit();
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../wishlist.php");
    exit();
}
function isProductIDExistCart($conn, $productID)
{
    $sql = "SELECT * FROM cart where productID ='$productID'";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $existence = true;
        }
    } else {
        $existence = false;
    }
    return $existence;
}
function checkCoinBalance($conn, $userEmail)
{
    $deductCoin = 0;
    $addCoin = 0;
    $sql = "SELECT * FROM coin WHERE userEmail = '$userEmail';";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row["transactionStatus"] == "biddingRefund") {
                $addCoin += $row["coinAmount"];
            } else if ($row["transactionStatus"] == "deduct1") {
                $deductCoin += $row["coinAmount"];
            } else if ($row["transactionStatus"] == "deduct2") {
                $deductCoin += $row["coinAmount"];
            }
        }
    }
    $coinBalance = $addCoin - $deductCoin;
    return $coinBalance;
}
//friendlist
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
function searchFriendByFriendCode($conn, $friendCode)
{
    $sql = "SELECT * FROM users WHERE friendCode = '$friendCode';";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    $foundFriendDetail = array();
    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $foundFriendDetail['userFirstName'] = $row["userFirstName"];
            $foundFriendDetail['userLastName'] = $row["userLastName"];
            $foundFriendDetail['userImage'] = $row["userImage"];
        }
    }
    return $foundFriendDetail;
}
function isFriend($conn, $firstUserEmail, $secondUserEmail)
{
    $sql = "SELECT * FROM friendlist WHERE firstUserEmail = '$firstUserEmail' AND secondUserEmail = '$secondUserEmail' OR firstUserEmail = '$secondUserEmail' AND secondUserEmail = '$firstUserEmail';";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    $isFriend = false;
    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row["friendStatus"] == "accepted") {
                $isFriend = true;
            }
        }
    }
    return $isFriend;
}
function addFriend($conn, $currentUserEmail, $friendEmail)
{
    $sql = "INSERT INTO friendlist (firstUserEmail, secondUserEmail, friendStatus) VALUES ('$currentUserEmail','$friendEmail','pending')";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../buyProduct.inc.php?error=stmtFailed18"); // rmb to edit the error apge
        exit();
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
function rejectFriend($conn, $currentUserEmail, $friendEmail){

    $friendStatus = "rejected";
    $sql = "UPDATE friendlist SET friendStatus = '$friendStatus' WHERE firstUserEmail = '$currentUserEmail' AND secondUserEmail = '$friendEmail' OR firstUserEmail = '$friendEmail' AND secondUserEmail = '$currentUserEmail'; ";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../user_profile_edit.php?error=stmtFailed");
        exit();
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
function acceptFriend($conn, $currentUserEmail, $friendEmail){

    $friendStatus = "accepted";
    $sql = "UPDATE friendlist SET friendStatus = '$friendStatus' WHERE firstUserEmail = '$currentUserEmail' AND secondUserEmail = '$friendEmail' OR firstUserEmail = '$friendEmail' AND secondUserEmail = '$currentUserEmail'; ";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../user_profile_edit.php?error=stmtFailed");
        exit();
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

// sql to get whole friendlist for current user select * from friendlist where firstUserEmail = '$currentUserEmail' OR secondUserEmail = '$currentUserEmail';

