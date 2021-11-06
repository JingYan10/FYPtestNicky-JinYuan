<?php

$dbServername = "25.19.149.25";
$dbUsername = "jinyuan888";
$dbPassword = "jinyuan888";
$dbName = "fanciadofoodo";

$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);

if(!$conn){
    die("connection failed: ".mysqli_connect_error());
}