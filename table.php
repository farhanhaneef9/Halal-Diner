<?php
// Database connection
$servername = "localhost"; // Change as needed
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "halaldiner"; // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to check table availability
function isTableAvailable($date, $time, $guests) {
    global $conn;

    // Query to count existing reservations for the given date and time
    $sql = "SELECT SUM(guests) as total_guests FROM reservations WHERE date = ? AND time = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $date, $time);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // Assuming the maximum capacity is 8 guests per table
    $maxCapacity = 8;
    $currentGuests = $row['total_guests'] ? $row['total_guests'] : 0;

    // Calculate available tables
    $availableTables = floor(($maxCapacity - $currentGuests) / $maxCapacity);

    return $availableTables > 0; // Return true if at least one table is available
}

// Handle request to check availability
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST['date'];
    $time = $_POST['time'];
    $guests = $_POST['guests'];

    if (isTableAvailable($date, $time, $guests)) {
        echo "Tables are available for your selected date and time.";
        header("Location: reservation.html");
    } else {
        echo "Sorry, no tables are available for the selected date and time.";
    }
}

$conn->close();
?>
