<?php
session_start(); // Ensure user is logged in

// Database connection
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "login";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve username from session
$user = $_SESSION['username']; // Assuming you have stored username in session

// Query to fetch booking information from the register table
$sql = "SELECT parking_spot, booking_start_time, booking_end_time FROM register WHERE username='$user'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    echo "<h2>Your Booking Details:</h2>";
    while ($row = $result->fetch_assoc()) {
        echo "Parking Spot: " . $row["parking_spot"] . "<br>";
        echo "Booking Start Time: " . $row["booking_start_time"] . "<br>";
        echo "Booking End Time: " . $row["booking_end_time"] . "<br>";
    }
} else {
    echo "No booking information found.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Booking</title>
</head>

<body>
    <h1>Your Booking Information</h1>
    <form action="view_booking.php" method="POST">
        <input type="submit" value="View My Booking">
    </form>
</body>

</html>