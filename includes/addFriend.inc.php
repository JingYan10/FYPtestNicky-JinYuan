<?php
session_start();

$currentUserEmail = $_SESSION["userEmail"];
$friendUserEmail = $_GET["userEmail"];

require_once 'databaseHandler.inc.php';
require_once 'functions.inc.php';

if (isFriendDataExist($conn, $currentUserEmail, $friendUserEmail) == true) {
    // echo "they are not friend";
    header("location: ../user_profile.php");
    exit;
} else if (isFriendDataExist($conn, $currentUserEmail, $friendUserEmail) == false) {
    // echo "they are friend";
    addFriend($conn, $currentUserEmail, $friendUserEmail);
    header("location: ../user_profile.php");
    exit;
}
