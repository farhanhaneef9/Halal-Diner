<?php
session_start();

// Dummy credentials — replace with DB auth later
$admin_email = "farhan@gmail.com";
$admin_password = "admin123";

if ($_POST['email'] === $admin_email && $_POST['password'] === $admin_password) {
    $_SESSION['admin_logged_in'] = true;
    $_SESSION['admin_email'] = $admin_email; // Store email for display
    header("Location: admin.php");
} else {
    echo "Invalid credentials. <a href='admin_login.php'>Try again</a>.";
}
?>
