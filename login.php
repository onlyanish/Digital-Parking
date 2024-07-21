<?php
session_start();
$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "login";

// Create connection
$conn = new mysqli($servername, $username_db, $password_db, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to select user with matching username and password
    $sql = "SELECT * FROM register WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    // Check if user exists
    if ($result->num_rows > 0) {
        $_SESSION['username'] = $username;
        header("Location: dashboard.php");
        exit();
    } else {
        echo '<script>
            alert("Login failed");
            window.location.href = "login.php";
        </script>';
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sustainable Cities & EV Parking</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <header>
        <h1>Digital Parking</h1>
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="register.php">Register</a></li>
                <li><a href="login.php">Login</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="login-form">
            <h2 style="font-weight: bold;">Login to Your Account</h2>
            <form id="login-form" method="post" action="login.php">
                <label for="username"><strong>Username:</strong></label>
                <input type="text" id="username" name="username" required>
                <label for="password"><strong>Password:</strong></label>
                <input type="password" id="password" name="password" required>
                <button type="submit">Login</button>
            </form>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 Sustainable Cities. All rights reserved.</p>
    </footer>
</body>

</html>