<?php
session_start();

$currentUserEmail = $_SESSION["userEmail"];
$friendEmail = 

require_once 'databaseHandler.inc.php';
require_once 'functions.inc.php';



addFriend($conn, $currentUserEmail, $friendEmail);
