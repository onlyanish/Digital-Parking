<?php
$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "login";

$conn = new mysqli($servername, $username_db, $password_db, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_GET['id'];

$sql = "SELECT id, first_name, last_name, email, vehicle_number FROM register WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($id, $firstName, $lastName, $email, $vehicleNumber);
$stmt->fetch();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
</head>

<body>
    <form action="update.php" method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <label for="first-name">First Name:</label>
        <input type="text" id="first-name" name="first-name" value="<?php echo $firstName; ?>" required>
        <br>
        <label for="last-name">Last Name:</label>
        <input type="text" id="last-name" name="last-name" value="<?php echo $lastName; ?>" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
        <br>
        <label for="vehicle-number">Vehicle Number:</label>
        <input type="text" id="vehicle-number" name="vehicle-number" value="<?php echo $vehicleNumber; ?>" required>
        <br>
        <button type="submit">Update</button>
    </form>
</body>

</html>

<?php
$conn->close();
?>