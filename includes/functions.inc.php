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

function createSellerDocument($conn, $identityCard, $fullName,$documentLocation, $userEmail)
{
    require_once 'databaseHandler.inc.php';
    $registrationType = "seller";
    $sql = "INSERT INTO verifierdocument (identityCard, fullName, documentLocation, registerationType, userEmail) VALUES (?, ?, ?, ?, ? );";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signUp.php?error=stmtFailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sssss", $identityCard, $fullName, $documentLocation, $registrationType ,$userEmail);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
   

}

function updateUserSellerStatus($conn,$userEmail){
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
        if( $_SESSION["userRole"] == "admin"){
            header("location: ../adminProfile.php");
            exit();
        }
        else{
            header("location: ../index.php");
            exit();
        }
    }
}

function checkOldPassword($conn,$email,$oldPassword){
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
function changePassword($conn,$email,$newPassword){
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

    if(strlen($IC) !=12 || !preg_match("/^[0-9]*$/", $IC) ){
        $result = true;
    } else {
        $result = false;
    }
    return $result;

}
function invalidFullName($fullName){
    $result;
    if (!preg_match("/^[a-zA-z]*$/", $fullName)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}
