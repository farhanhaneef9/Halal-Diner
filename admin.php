<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/icon" href="image/images.jpeg">
    <title>Admin Dashboard - Halal Diner</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style> 
       .container {
            max-width: 1000px;
            margin: 50px auto;
            background: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
        }

        .dashboard-card {
            background-color: #f9f9f9;
            padding: 25px;
            border-radius: 10px;
            text-align: center;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            background-color: #e9f5ec;
        }

        .dashboard-card i {
            font-size: 40px;
            margin-bottom: 10px;
            color: #4CAF50;
        }

        .dashboard-card a {
            text-decoration: none;
            color: #333;
            font-size: 18px;
            font-weight: 500;
            display: block;
            margin-top: 10px;
        }
    </style>
    </head>
<body>

<!-- Header -->
<header class="header">
    <a href="admin.php" class="logo">Halal Diner</a>
    <nav class="navbar">
        <a href="view_users.php"><i class="fa fa-users"></i>Users Info</a>
        <a href="view_reservation.php"><i class="fa fa-calendar-check"></i>Reservations</a>
        <a href="view_message.php"><i class="fa fa-envelope"></i>Messages</a>
        <a class="btn btn-outline-primary" href="admin_logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i></a>
    
    </nav>
</header>

<!-- Main Content -->
<main class="container">
    <div class="admin-info">
        <h1>Welcome to the Admin Dashboard</h1>
        <p>Logged in as: <strong><?php echo $_SESSION['admin_email']; ?></strong></p>
    </div>

    <?php
    require 'hdconnection.php';
    // Total Reservations
    $resQuery = $conn->query("SELECT COUNT(*) AS total FROM reservations");
    $resTotal = $resQuery->fetch_assoc()['total'];

    // Total Guests (for revenue)
    $guestQuery = $conn->query("SELECT SUM(guests) AS total_guests FROM reservations");
    $guestCount = $guestQuery->fetch_assoc()['total_guests'] ?? 0;

    // Total Users
    $userQuery = $conn->query("SELECT COUNT(*) AS total_users FROM signup");
    $userTotal = $userQuery->fetch_assoc()['total_users'];

    // Revenue Estimation
    $estimatedRevenue = $guestCount * 20; // Example: $20 per guest
    ?>

    <h2>Overview</h2>
    <div class="dashboard-cards" style="display: flex; gap: 20px; flex-wrap: 20px;">
        <div class="card" style="flex: 1; min-width: 220px; background: #f4f4f4; padding: 20px; border-radius: 10px;">
            <h3>Total Reservations</h3>
            <p style="font-size: 24px;"><?php echo $resTotal; ?></p>
        </div>
        <div class="dashboard-card" style="flex: 1; min-width: 220px; background: #f4f4f4; padding: 20px; border-radius: 10px;">
            <h3>Registered Users</h3>
            <p style="font-size: 24px;"><?php echo $userTotal; ?></p>
        </div>
        <div class="dashboard-card" style="flex: 1; min-width: 220px; background: #f4f4f4; padding: 20px; border-radius: 10px;">
            <h3>Estimated Revenue</h3>
            <p style="font-size: 24px;">$<?php echo number_format($estimatedRevenue); ?></p>
        </div>
    </div>

    <h2>Quick Actions</h2>
    <ul>
        <li><a class="btn" href="view_reservation.php">View Reservations</a></li>
        <li><a class="btn" href="view_users.php">Users Info</a></li>
        <li><a class="btn" href="view_message.php">Users Feedbacks</a></li>
    </ul>
</main>

</body>
</html>
