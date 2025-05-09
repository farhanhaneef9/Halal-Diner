<?php
session_start();
include('hdconnection.php');

// Redirect if already logged in
if (isset($_SESSION['username'])) {
    header("Location: inde.html");
    exit();
}

$login = false;
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("CSRF token validation failed.");
    }

    $username = trim($_POST['email']);
    $password = trim($_POST['pass']);

    if (!empty($username) && !empty($password)) {
        $stmt = $conn->prepare("SELECT * FROM signup WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row["password"])) {
                session_regenerate_id(true); // Prevent session fixation
                $_SESSION['username'] = $row['username'];
                $_SESSION['loggedin'] = true;
                header("Location: inde.html");
                exit();
            } else {
                $error = "Invalid password!";
            }
        } else {
            $error = "Invalid username or email!";
        }
    } else {
        $error = "Please fill in all fields!";
    }
}

// Generate CSRF token
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/icon" href="image/images.jpeg">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet">
    <title>Login</title>
    <style>
        body {
    background: linear-gradient(-45deg, #500112, #d4a373, #b38257, #ffffff);
    background-size: 400% 400%;
    animation: gradientAnimation 10s ease infinite;
}

@keyframes gradientAnimation {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}
body {
      background-color: #f7f9fb;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      font-family: 'Segoe UI', sans-serif;
    }

    .signup-card {
      background: white;
      padding: 40px;
      border-radius: 15px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 500px;
    }

    .signup-card h2 {
      text-align: center;
      margin-bottom: 30px;
      color: #333;
    }

    .form-control:focus {
      box-shadow: none;
      border-color: #28a745;
    }

    .btn-custom {
      background-color:rgb(255, 255, 255);
      border: none;
      color:  #500112;
    }

    .btn-custom:hover {
      background-color: #500112;
      color:rgb(255, 255, 255);
    }

    .input-group-text {
      background-color: #f0f0f0;
      border: none;
    }
        </style>
</head>
<body>
   <div class="signup-card">
    <form action="" method="POST">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <div class="signup-card">
  <h2><i class="fa-solid fa-right-to-bracket"></i> Login</h2>
  <form action="login.php" method="POST">

    <div class="mb-3">
      <label class="form-label">Email Address</label>
      <div class="input-group">
        <span class="input-group-text"><i class="fa fa-envelope"></i></span>
        <input type="email" name="email" class="form-control" required>
      </div>
    </div>

    <div class="mb-3">
      <label class="form-label">Password</label>
      <div class="input-group">
        <span class="input-group-text"><i class="fa fa-lock"></i></span>
        <input type="password" name="pass" class="form-control" required>
      </div>
    </div>

    <div class="d-grid">
      <button type="submit" name="login" class="btn btn-custom" value="login">Login</button>
    </div>
        <a href="signup.php">Don't have an account? Sign Up</a>
        <?php if ($error): ?>
            <p class="error"> <?= htmlspecialchars($error) ?> </p>
        <?php endif; ?>
    </form>
        </div>
</body>
</html>
