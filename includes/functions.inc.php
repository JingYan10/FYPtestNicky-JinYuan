<?php

function emptyInputSignUp($firstName,$lastName,$email,$password,$confirmPassword) {
    $result;
    if(empty($firstName) || empty($lastName)|| empty($email) || empty($password) || empty($confirmPassword)){
        $result = true;
    }
    else{
        $result = false;
    }
    return $result;
}

function invalidName($firstName,$lastName) {
    $result;
    if(!preg_match("/^[a-zA-z]*$/",$firstName) || !preg_match("/^[a-zA-z]*$/",$lastName )){
        $result = true;
    }
    else{
        $result = false;
    }
    return $result;
}

function invalidEmail($email) {
    $result;
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $result = true;
    }
    else{
        $result = false;
    }
    return $result;
}

function matchingPassword($password,$confirmPassword) {
    $result;
    if($password!=$confirmPassword){
        $result = true;
    }
    else{
        $result = false;
    }
    return $result;
}

function isExistUser($conn, $email) {
    $sql = "SELECT * FROM users WHERE userEmail = ?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../signUp.php?error=stmtFailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_assoc($resultData)){
        return $row;


    }else{
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);

}

function createUser($conn,$firstName,$lastName,$email,$password,$userImage) {
    $sql = "INSERT INTO users (userEmail, userFirstName, userLastName, userPassword, userRole, userImage) VALUES (?, ?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    $role = "member";
    if(!mysqli_stmt_prepare($stmt,$sql)){
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

function emptyInputLogin($email,$password) {
    $result;
    if( empty($email) || empty($password) ){
        $result = true;
    }
    else{
        $result = false;
    }
    return $result;
}

function loginUser($conn,$email,$password){
    $isExistUser = isExistUser($conn, $email);

    if($isExistUser== false){
        header("location: ../login.php?error=wrongLogin");
        exit();
    }

    $encryptedPassword = $isExistUser["userPassword"];
    $checkPassword = password_verify($password, $encryptedPassword);

    if($checkPassword == false){
        header("location: ../login.php?error=wrongLogin");
        exit();
    }
    else if ($checkPassword == true){
        session_start();
        $_SESSION["userEmail"] = $email;
        header("location: ../index.php");
        exit();
    }
}