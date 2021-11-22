<?php
session_start();

    $registryEmail = $_GET["userEmail"]; 
    $registerationType = $_GET["registerationType"];

    require_once 'databaseHandler.inc.php';
    require_once 'functions.inc.php';

    rejectUser($conn, $registryEmail, $registerationType);