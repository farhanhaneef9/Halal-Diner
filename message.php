<?php
include 'hdconnection.php'; // Include your database connection file
$success = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $subject = $conn->real_escape_string($_POST['subject']);
    $message = $conn->real_escape_string($_POST['message']);

    $sql = "INSERT INTO admin_messages (username, email, subject, message)
            VALUES ('$username', '$email', '$subject', '$message')";

    if ($conn->query($sql) === TRUE) {
        $success = true;
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Contact Halal Diner</title>
    <link rel="icon" type="image/icon" href="image/images.jpeg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        .contact-form-container {
            max-width: 600px;
            margin: 80px auto;
            background: #fff;
            padding: 30px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            border-radius: 10px;
        }
        .contact-form-container h2 {
            text-align: center;
            color: #333;
        }
        .contact-form-container input,
        .contact-form-container textarea {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        /* Pop-up modal styling */
        .popup {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.6);
            justify-content: center;
            align-items: center;
        }

        .popup-content {
            background: white;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
        }

        .popup-content h3 {
            color: #27ae60;
        }

        .popup-content button {
            margin-top: 15px;
            padding: 10px 20px;
            background: #27ae60;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<?php if ($success): ?>
<div class="popup" id="popup">
    <div class="popup-content">
        <h3>Message Sent Successfully!</h3>
        <p>Thank you for contacting us. We'll get back to you shortly.</p>
        <button onclick="document.getElementById('popup').style.display='none'">Close</button>
    </div>
</div>
<script>
    document.getElementById('popup').style.display = 'flex';
</script>
<?php endif; ?>

<section class="contact-form-container">
    <h2>Send Us a Message</h2>
    <form method="post">
        <input type="text" name="name" placeholder="Your Name" required />
        <input type="email" name="email" placeholder="Your Email" />
        <input type="text" name="subject" placeholder="Subject" />
        <textarea name="message" placeholder="Your Message" rows="6" required></textarea>
        <button type="submit" class="btn btn-outline-primary">Send Message</button>
    </form>
    <a href="contact.html" class="btn btn-outline-primary">Back </a>
</section>
</body>
</html>
