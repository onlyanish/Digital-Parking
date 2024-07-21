<?php
$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "login";

$conn = new mysqli($servername, $username_db, $password_db, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_POST['id'];
$firstName = $_POST['first-name'];
$lastName = $_POST['last-name'];
$email = $_POST['email'];
$vehicleNumber = $_POST['vehicle-number'];

$sql = "UPDATE register SET first_name = ?, last_name = ?, email = ?, vehicle_number = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssi", $firstName, $lastName, $email, $vehicleNumber, $id);

if ($stmt->execute()) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $stmt->error;
}

$stmt->close();
$conn->close();
