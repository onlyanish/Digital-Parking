<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'connect.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sustainable Cities & EV Parking</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .dashboard-option {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
            margin: 10px 0;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .dashboard-option h3 {
            margin-top: 0;
            color: #003366;
            /* Deep Blue */
        }

        .parking-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin: 20px 0;
            visibility: hidden;
            /* Hidden by default */
        }

        .parking-spot {
            background-color: #ccc;
            padding: 20px;
            text-align: center;
            border-radius: 5px;
            font-size: 1.2em;
            transition: background-color 0.3s ease;
        }

        .parking-spot.red {
            background-color: red;
            color: white;
        }

        .parking-spot.green {
            background-color: green;
            color: white;
        }

        .time-details,
        .notification {
            margin-top: 10px;
        }

        .notification {
            display: none;
            background-color: #ffcc00;
            padding: 10px;
            border-radius: 5px;
        }

        .payment-methods li {
            font-weight: bold;
        }

        .about-us,
        .contact-us {
            background-color: #f1f1f1;
            padding: 20px;
            border-radius: 10px;
            margin: 10px 0;
        }

        .about-us h2,
        .contact-us h2 {
            color: #003366;
        }
    </style>
    <script>
        let timerDuration = 60 * 60; // 1 hour
        let timerInterval;
        let parkingSpots = [];
        let isBookingActive = false;

        function formatTime(date) {
            let hours = date.getHours();
            let minutes = date.getMinutes();
            let ampm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12;
            hours = hours ? hours : 12; // the hour '0' should be '12'
            minutes = minutes < 10 ? '0' + minutes : minutes;
            return hours + ':' + minutes + ' ' + ampm;
        }

        function startTimer(duration, display) {
            clearInterval(timerInterval);
            var timer = duration,
                minutes, seconds;
            let startTime = new Date();
            let endTime = new Date(startTime.getTime() + timer * 1000);

            document.querySelector('.time-details').innerHTML = `
                <p>Time started at: ${formatTime(startTime)}</p>
                <p>Ends at: ${formatTime(endTime)}</p>
            `;

            timerInterval = setInterval(function() {
                minutes = parseInt(timer / 60, 10);
                seconds = parseInt(timer % 60, 10);

                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                display.textContent = minutes + ":" + seconds;

                if (--timer < 0) {
                    clearInterval(timerInterval);
                    display.textContent = "00:00";
                    document.getElementById("notification").style.display = "block";
                }

                if (timer === 900) {
                    document.getElementById("notification").style.display = "block";
                }
            }, 1000);
        }

        function resetTimer() {
            clearInterval(timerInterval);
            document.querySelector('#timer-display').textContent = "00:00";
            document.querySelector('.time-details').innerHTML = "";
            isBookingActive = false;
        }

        function extendTime() {
            if (isBookingActive) {
                timerDuration += 60 * 60; // extend by 1 hour
                startTimer(timerDuration, document.querySelector('#timer-display'));
            } else {
                alert("No active booking to extend time.");
            }
        }

        function randomizeParking() {
            parkingSpots = [];
            var parkingGrid = document.querySelector('.parking-grid');
            parkingGrid.innerHTML = '';
            for (var i = 1; i <= 20; i++) {
                var spot = document.createElement('div');
                spot.classList.add('parking-spot', 'red');
                spot.textContent = 'A' + i;
                spot.onclick = function() {
                    bookParkingSpot(this);
                };
                parkingSpots.push(spot);
                parkingGrid.appendChild(spot);
            }
        }

        function bookParkingSpot(spot) {
            if (spot.classList.contains('red')) {
                spot.classList.remove('red');
                spot.classList.add('green');
                alert('Parking spot booked!');
                startTimer(timerDuration, document.querySelector('#timer-display'));
                isBookingActive = true;
            } else {
                alert('This spot is already booked.');
            }
        }

        function cancelParking() {
            if (isBookingActive) {
                resetTimer();
                parkingSpots.forEach(spot => {
                    if (spot.classList.contains('green')) {
                        spot.classList.remove('green');
                        spot.classList.add('red');
                    }
                });
                alert('Parking booking canceled.');
            } else {
                alert('No active booking to cancel.');
            }
        }

        function showGoogleMaps() {
            window.open("https://www.google.com/maps", "_blank");
        }

        function toggleParkingSpaces(show) {
            var parkingGrid = document.querySelector('.parking-grid');
            parkingGrid.style.visibility = show ? 'visible' : 'hidden';
        }

        window.onload = function() {
            var display = document.querySelector('#timer-display');
            startTimer(timerDuration, display);
            randomizeParking();
        };
    </script>
</head>

<body>
    <header>
        <h1>Digital Parking</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="#about-us">About Us</a></li>
                <li><a href="#contact-us">Contact Us</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="dashboard">
            <div class="dashboard-option">
                <h3>Parking Status</h3>
                <p>Get real-time updates on parking space availability in your area.</p>
                <button onclick="showGoogleMaps()">Show on Google Maps</button>
            </div>
            <div class="dashboard-option">
                <h3>Smart Navigation</h3>
                <p>Navigate to the nearest available EV parking space with our smart navigation system.</p>
                <div class="parking-grid"></div>
                <button onclick="toggleParkingSpaces(true)">Show Parking Spaces</button>
                <button onclick="toggleParkingSpaces(false)">Close Parking Spaces</button>
            </div>
            <div class="dashboard-option">
                <h3>Book Parking</h3>
                <p>Click on a parking spot to book it. Red spots are available, green spots are booked.</p>
            </div>
            <div class="dashboard-option">
                <h3>Time Remaining</h3>
                <div id="timer-display">60:00</div>
                <div class="time-details"></div>
                <div id="notification" class="notification">
                    15 minutes remaining!
                </div>
                <button onclick="extendTime()">Extend Time by 1 Hour</button>
            </div>
            <div class="dashboard-option">
                <h3>Payment</h3>
                <p>Choose your preferred payment method:</p>
                <ul class="payment-methods">
                    <li>Banking</li>
                    <li>E-wallet</li>
                    <li>Cash</li>
                </ul>
            </div>
            <div class="dashboard-option">
                <h3>Cancel Parking</h3>
                <p>Cancel your current parking session.</p>
                <button onclick="cancelParking()">Cancel Parking</button>
            </div>
        </section>

        <section id="about-us" class="about-us">
            <h2>About Us</h2>
            <p>Welcome to Sustainable Cities & EV Parking, where we are dedicated to making urban living more
                efficient and eco-friendly through innovative digital parking solutions and electric vehicle
                management systems.</p>
            <p>Our mission is to reduce traffic congestion, improve air quality, and provide convenient parking
                solutions for electric vehicle owners. We strive to create sustainable cities by integrating smart
                technology into everyday life, making it easier for people to find available parking spaces and
                navigate urban areas.</p>
        </section>

        <section id="contact-us" class="contact-us">
            <h2>Contact Us</h2>
            <form>
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="message">Message:</label>
                <textarea id="message" name="message" rows="4" required></textarea>

                <button type="submit">Submit</button>
            </form>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 Sustainable Cities & EV Parking. All rights reserved.</p>
    </footer>
</body>

</html>