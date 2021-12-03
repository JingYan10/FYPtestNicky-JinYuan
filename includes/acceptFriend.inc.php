<?php
session_start();

require_once 'databaseHandler.inc.php';
require_once 'functions.inc.php';

$currentUserEmail = $_SESSION["userEmail"];
$friendEmail = getLatestFriendID($conn, $currentUserEmail);


acceptFriend($conn, $currentUserEmail, $friendEmail);
