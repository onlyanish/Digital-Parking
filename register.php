<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstName = $_POST['first-name'];
    $lastName = $_POST['last-name'];
    $vehicleNumber = $_POST['vehicle-number'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm-password'];

    // Simple form validation
    if (empty($firstName) || empty($lastName) || empty($vehicleNumber) || empty($email) || empty($username) || empty($password) || empty($confirmPassword)) {
        echo "All fields are required!";
    } elseif ($password !== $confirmPassword) {
        echo "Passwords do not match!";
    } else {
        // Check if username or email already exists
        $checkSql = "SELECT * FROM register WHERE username = ? OR email = ?";
        $stmt = $conn->prepare($checkSql);
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo "Username or email already exists!";
        } else {
            // Insert user data into database without hashing the password
            $sql = "INSERT INTO register (first_name, last_name, vehicle_number, email, username, password) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssss", $firstName, $lastName, $vehicleNumber, $email, $username, $password);

            if ($stmt->execute() === TRUE) {
                // Redirect to login page after successful registration
                header("Location: login.php");
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }
        }
        $stmt->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Sustainable Cities & EV Parking</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <header>
        <h1>Digital Parking</h1>
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="register.php">Register</a></li>
                <li><a href="login.php">Login</a></li> <!-- Corrected link to login page -->
            </ul>
        </nav>
    </header>
    <main>
        <div class="register-form">
            <h2><strong>Register</strong></h2>
            <form id="registration-form" method="post" action="register.php">
                <label for="first-name"><strong>First Name:</strong></label>
                <input type="text" id="first-name" name="first-name" required>

                <label for="last-name"><strong>Last Name:</strong></label>
                <input type="text" id="last-name" name="last-name" required>

                <label for="vehicle-number"><strong>Vehicle Number:</strong></label>
                <input type="text" id="vehicle-number" name="vehicle-number" required>

                <label for="email"><strong>Email Address:</strong></label>
                <input type="email" id="email" name="email" required>

                <label for="username"><strong>Username:</strong></label>
                <input type="text" id="username" name="username" required>

                <label for="password"><strong>Password:</strong></label>
                <input type="password" id="password" name="password" required>

                <label for="confirm-password"><strong>Confirm Password:</strong></label>
                <input type="password" id="confirm-password" name="confirm-password" required>

                <button type="submit">Register</button>
            </form>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 Sustainable Cities. All rights reserved.</p>
    </footer>
</body>

</html>