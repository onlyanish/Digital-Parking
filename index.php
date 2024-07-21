<?php
include 'connect.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sustainable Cities & EV Parking</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .features {
            position: relative;
            background-image: url('Parking garage.jpg');
            background-size: cover;
            background-position: center;
            padding: 20px;
            color: white;
        }

        .features .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            /* Semi-transparent overlay for better readability */
            z-index: 1;
        }

        .features-content {
            position: relative;
            z-index: 2;
            padding: 20px;
        }

        .features-content h3,
        .features-content h4,
        .features-content p {
            margin: 0 0 10px;
            color: #333;
            /* Darker color for text */
        }
    </style>
</head>

<body>
    <header>
        <h1>Digital Parking</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="register.php">Register</a></li>
                <li><a href="login.php">Login</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="hero">
            <img src="blank" alt="EV Parking" class="hero-image">
            <h2 style="font-weight: bold;">Welcome to Digital parking</h2>
            <p style="font-weight: bold;">Smart solutions for electric vehicle parking and management.</p>
        </section>

        <section class="features">
            <div class="overlay"></div>
            <div class="features-content">
                <h3>Our Features</h3>
                <ul>
                    <li>
                        <h4>Live Parking Status</h4>
                        <p>Get real-time updates on parking space availability in your area.</p>
                    </li>
                    <li>
                        <h4>Smart Navigation</h4>
                        <p>Navigate to the nearest available EV parking space with our smart navigation system.</p>
                    </li>
                    <li>
                        <h4>User Account Management</h4>
                        <p>Manage your parking sessions, payments, and account details easily.</p>
                    </li>
                    <li>
                        <h4>Notifications & Alerts</h4>
                        <p>Receive alerts when your parking time is about to expire and get notifications about
                            important updates.</p>
                    </li>
                    <li>
                        <h4>Support & Problem Resolution</h4>
                        <p>Contact our support team for any issues or inquiries regarding our services.</p>
                    </li>
                </ul>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 Sustainable Cities. All rights reserved.</p>
    </footer>
</body>

</html>