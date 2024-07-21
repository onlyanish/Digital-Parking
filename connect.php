<?php

$host = "localhost";
$user = "root";
$pass = "";
$db = "login";
$port = 3308; // Ensure this port is correct

$conn = new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully";
