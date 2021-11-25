<?php
session_start();

    $userEmail = $_SESSION["userEmail"];

    require_once 'databaseHandler.inc.php';
    require_once 'functions.inc.php';
 

    removeAllFromCart($conn,$userEmail);