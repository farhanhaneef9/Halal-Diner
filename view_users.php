<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}
require 'hdconnection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/icon" href="image/images.jpeg">
    <title>Registered Users - Halal Diner</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .container {
            max-width: 1100px;
            margin: 40px auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h2 {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 12px 14px;
            text-align: center;
        }
        table th {
            background-color: #f2f2f2;
            color: #222;
        }
        table tr:nth-child(even) {
            background-color: #fafafa;
        }
    </style>
</head>
<body>

<header class="header">
    <a href="admin.php" class="logo">Halal Diner</a>
    <nav class="navbar">
        <a href="view_users.php"><i class="fa fa-users"></i>Users Info</a>
        <a href="view_reservation.php"><i class="fa fa-calendar-check"></i>Reservations</a>
        <a href="view_message.php"><i class="fa fa-envelope"></i>Messages</a>
        <a href="admin_logout.php" class="btn btn-outline-primary"><i class="fa fa-sign-out"></i> </a>
    </nav>
</header>

<main class="container">
    <h2>Registered Users</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Joined On</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = $conn->query("SELECT * FROM signup ORDER BY id DESC");
            if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['username']}</td>
                            <td>{$row['email']}</td>
                            <td>{$row['phone']}</td>
                            <td>{$row['created_at']}</td>
                            <td>
                                <form method='POST' action='delete_users.php' onsubmit=\"return confirm('Are you sure you want to delete this user?');\">
                                    <input type='hidden' name='id' value='{$row['id']}'>
                                    <button type='submit' class='btn btn-outline-primary'>Delete</button>
                                </form>
                            </td>
                        </tr>";
                    }}
                    
            $conn->close();
            ?>
        </tbody>
    </table>
</main>

</body>
</html>
