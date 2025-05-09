<?php
include 'hdconnection.php'; // your DB connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['reservation_id'];
    $status = $_POST['status'];

    $query = "UPDATE reservations SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();

    header("Location: view_reservation.php");
    exit();
}
?>
