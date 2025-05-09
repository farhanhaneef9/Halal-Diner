<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/icon" href="image/images.jpeg">
    <title>View Reservations - Halal Diner</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
        <a href="view_reservation.php"><i class="fa fa-calendar-check"></i> Reservations</a>
        <a href="view_message.php"><i class="fa fa-envelope"></i>Messages</a>
        <a href="admin_logout.php" class="btn btn-outline-primary"><i class="fa fa-sign-out"></i> </a>
    </nav>
</header>

<main class="container">
    <h2>All Reservations</h2>
<section></section>
    <table>
        <thead>
            <tr>
                <th>Email</th>
                <th>Phone</th>
                <th>Date</th>
                <th>Time</th>
                <th>Guests</th>
                <th>Dining Style</th>
                <th>Dining Type</th>
                <th>Status</th>
                <th>Actions</th>
                <th>Submitted At</th>
            </tr>
        </thead>
        </section>
        <tbody>
        <?php
require 'hdconnection.php';

$query = "SELECT * FROM reservations ORDER BY created_at DESC";
$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>{$row['email']}</td>
            <td>{$row['phone']}</td>
            <td>{$row['date']}</td>
            <td>{$row['time']}</td>
            <td>{$row['guests']}</td>
            <td>{$row['diningStyle']}</td>
            <td>{$row['diningType']}</td>
            <td>
                <form method='POST' action='update_status.php'>
                    <input type='hidden' name='reservation_id' value='{$row['id']}'>
                    <select name='status' onchange='this.form.submit()'>
                        <option value='Pending'" . ($row['status'] == 'Pending' ? ' selected' : '') . ">Pending</option>
                        <option value='Confirmed'" . ($row['status'] == 'Confirmed' ? ' selected' : '') . ">Confirmed</option>
                        <option value='Cancelled'" . ($row['status'] == 'Cancelled' ? ' selected' : '') . ">Cancelled</option>
                    </select>
                </form>
            </td>
            <td>
                <form method='POST' action='delete_reservation.php' onsubmit=\"return confirm('Are you sure you want to delete this reservation?');\">
                    <input type='hidden' name='id' value='{$row['id']}'>
                    <button type='submit' class='btn btn-outline-primary'>Delete</button>
                </form>
            </td>
            <td>{$row['created_at']}</td>
        </tr>";
    }
}
$conn->close();
?>

</main>
</body>
</html>
