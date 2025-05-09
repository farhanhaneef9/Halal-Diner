<?php
session_start();
if (isset($_SESSION['admin_logged_in'])) {
    header("Location: admin.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="icon" type="image/icon" href="image/images.jpeg">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login - Halal Diner</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet">
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
  <h2><i class="fa-solid fa-user-shield"></i> Admin Login</h2>
  <form method="POST" action="admin_auth.php">

    <div class="mb-3">
      <label class="form-label">Email</label>
      <div class="input-group">
        <span class="input-group-text"><i class="fa fa-envelope"></i></span>
        <input type="email" name="email" class="form-control" required>
      </div>
    </div>

    <div class="mb-3">
      <label class="form-label">Password</label>
      <div class="input-group">
        <span class="input-group-text"><i class="fa fa-lock"></i></span>
        <input type="password" name="password" class="form-control" required>
      </div>
    </div>

    <div class="d-grid">
      <button type="submit" class="btn btn-custom">Login</button>
    </div>
  </form>
</div>

</body>
</html>
