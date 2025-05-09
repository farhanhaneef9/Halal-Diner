<?php
require_once 'hdconnection.php'; // Ensure this file contains database connection details



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate inputs
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $phone = preg_replace("/[^0-9]/", "", $_POST['phone']); // Remove non-numeric characters
    $date = date('Y-m-d', strtotime($_POST['date'])); // Ensure date is in correct format
    $time = date('H:i:s', strtotime($_POST['time'])); // Ensure time is in correct format
    $guests = filter_var($_POST['guests'], FILTER_VALIDATE_INT, ["options" => ["min_range" => 1, "max_range" => 20]]);
    $diningStyle = filter_var($_POST["dining-style"]);
    $diningType = filter_var($_POST["dining-type"]);

    if ($email && $phone && $date && $time && $guests) {
        try {
            $query = "INSERT INTO reservations (email, phone, date, time, guests, diningStyle, diningType) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $query);
            
            if ($stmt === false) {
                throw new Exception("Failed to prepare statement: " . mysqli_error($conn));
            }

            mysqli_stmt_bind_param($stmt, "sssssss", $email, $phone, $date, $time, $guests, $diningStyle, $diningType);
            
            if (mysqli_stmt_execute($stmt)) {
                // Set a session variable for success message
                session_start();
                $_SESSION['reservation_success'] = true;
                
                // Redirect using PHP header
                header("Location: inde.html");
                exit();
            } else {
                throw new Exception("Failed to execute statement: " . mysqli_stmt_error($stmt));
            }
        } catch (Exception $e) {
            // Log the error and show a user-friendly message
            error_log($e->getMessage());
            echo "An error occurred while processing your reservation. Please try again later.";
        } finally {
            if (isset($stmt)) {
                mysqli_stmt_close($stmt);
            }
            mysqli_close($conn);
        }
    } else {
        echo "Invalid input data. Please check your entries and try again.";
    }
} else {
    // If accessed directly without POST data, redirect to the reservation page
    header("Location: reservation.html");
    exit();
}
?>