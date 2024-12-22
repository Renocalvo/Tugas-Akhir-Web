<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "webtaskcompany";

// Establish a connection
$koneksi = mysqli_connect($host, $user, $pass, $db);

// Check connection
if (!$koneksi) {
    die("Connection failed: " . mysqli_connect_error());
}

