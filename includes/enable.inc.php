<?php
session_start();

    $email = $_GET["userEmail"]; 

    require_once 'databaseHandler.inc.php';
    require_once 'functions.inc.php';

    enableSeller($conn, $email);
