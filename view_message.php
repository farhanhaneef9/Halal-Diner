<?php
require 'hdconnection.php'; // your DB connection

$query = "SELECT * FROM admin_messages ORDER BY created_at DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Messages - Halal Diner</title>
    <link rel="icon" type="image/icon" href="image/images.jpeg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>


        .container {
            max-width: 1100px;
            margin: 50px auto;
            background: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }

        h2 {
            margin-bottom: 25px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            padding: 14px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .no-data {
            text-align: center;
            font-style: italic;
            color: gray;
            padding: 30px 0;
        }
    </style>
</head>
<body>

<header class="header">
<a href="admin.php" class="logo">Halal Diner</a>
    <nav class="navbar">
        <a href="view_users.php"><i class="fa fa-users"></i> Users</a>
        <a href="view_reservation.php"><i class="fa fa-calendar-check"></i> Reservations</a>
        <a href="view_message.php"><i class="fa fa-envelope"></i>Messages</a>
        <a href="admin_logout.php" class="btn btn-outline-primary"><i class="fa fa-sign-out"></i> </a>
    </nav>
</header>

<main class="container">
    <h2><i class="fa fa-envelope"></i> Messages from Clients</h2>

    <?php if ($result && $result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Received At</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['subject']); ?></td>
                        <td><?php echo nl2br(htmlspecialchars($row['message'])); ?></td>
                        <td><?php echo $row['created_at']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="no-data">No messages available at the moment.</div>
    <?php endif; ?>

</main>

</body>
</html>

<?php $conn->close(); ?>
