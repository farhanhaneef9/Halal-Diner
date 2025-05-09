<?php
require 'hdconnection.php';

$status = '';
$reservations = [];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    $email = $_POST['email'];

    $stmt = $conn->prepare("SELECT * FROM reservations WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $reservations = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    if (count($reservations) == 0) {
        $status = "No reservations found for this email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/icon" href="image/images.jpeg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Check Your Reservation - Halal Diner</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .container {
            max-width: 800px;
            margin: 40px auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        table th {
            background-color: #f2f2f2;
        }
        input[type=email] {
            padding: 8px;
            width: 70%;
        }
        button {
            padding: 8px 14px;
        }
    </style>
</head>
<body>

<main class="container">
    <h2>Check Your Reservation</h2>
    <form method="POST">
        <label for="email">Enter your email to view reservation status:</label><br><br>
        <input type="email" name="email" id="email" required>
        <button type="submit">Check</button>
    </form>

    <?php if ($status): ?>
        <p><?php echo $status; ?></p>
    <?php endif; ?>

    <?php if (!empty($reservations)): ?>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Guests</th>
                    <th>Dining Style</th>
                    <th>Dining Type</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservations as $res): ?>
                    <tr>
                        <td><?php echo $res['date']; ?></td>
                        <td><?php echo $res['time']; ?></td>
                        <td><?php echo $res['guests']; ?></td>
                        <td><?php echo $res['diningStyle']; ?></td>
                        <td><?php echo $res['diningType']; ?></td>
                        <td><strong><?php echo $res['status']; ?></strong></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="inde.html" class="btn btn-outline-primary">Back </a>
    <?php endif; ?>
</main>

</body>
</html>
