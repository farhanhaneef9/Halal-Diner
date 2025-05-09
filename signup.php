<?php
session_start();
if (isset($_SESSION['username'])) {
    header("Location: about.html");
}
?>
<?php
include("hdconnection.php");

if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($conn, $_POST['user']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = mysqli_real_escape_string($conn, $_POST['pass']);
    $cpassword = mysqli_real_escape_string($conn, $_POST['cpass']);

    $sql = "SELECT * FROM signup WHERE username='$username'";
    $result = mysqli_query($conn, $sql);
    $count_user = mysqli_num_rows($result);

    $sql = "SELECT * FROM signup WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    $count_email = mysqli_num_rows($result);

    if ($count_user == 0 && $count_email == 0) {
        if ($password == $cpassword) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO signup(username, email, phone, password) VALUES('$username', '$email', '$phone', '$hash')";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                header("Location: login.php");
            }
        } else {
            echo '<script>
                alert("Passwords do not match");
                window.location.href = "signup.php";
            </script>';
        }
    } else {
        if ($count_user > 0) {
            echo '<script>
                alert("Username already exists!!");
                window.location.href="index.php";
            </script>';
        }
        if ($count_email > 0) {
            echo '<script>
                alert("Email already exists!!");
                window.location.href="index.php";
            </script>';
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="icon" type="image/icon" href="image/images.jpeg">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sign Up - Halal Diner</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
  <h2><i class="fa-solid fa-user-plus"></i> Create Account</h2>
  <form action="signup.php" method="POST">
    
    <div class="mb-3">
      <label class="form-label">Username</label>
      <div class="input-group">
        <span class="input-group-text"><i class="fa fa-user"></i></span>
        <input type="text" name="user" class="form-control" required pattern="[A-Za-z\s]+" title="Only letters allowed">
      </div>
    </div>

    <div class="mb-3">
      <label class="form-label">Email address</label>
      <div class="input-group">
        <span class="input-group-text"><i class="fa fa-envelope"></i></span>
        <input type="email" name="email" class="form-control" required>
      </div>
    </div>

    <div class="mb-3">
      <label class="form-label">Phone Number</label>
      <div class="input-group">
        <span class="input-group-text"><i class="fa fa-phone"></i></span>
        <input type="tel" name="phone" class="form-control" maxlength="10" title="Enter a 10-digit number">
      </div>
    </div>

    <div class="mb-3">
      <label class="form-label">Password</label>
      <div class="input-group">
        <span class="input-group-text"><i class="fa fa-lock"></i></span>
        <input type="password" name="pass" class="form-control" required>
      </div>
    </div>

    <div class="mb-3">
      <label class="form-label">Confirm Password</label>
      <div class="input-group">
        <span class="input-group-text"><i class="fa fa-lock"></i></span>
        <input type="password" name="cpass" class="form-control" required>
      </div>
    </div>

    <div class="d-grid">
      <button type="submit" name="submit" class="btn btn-custom" value="signup">Sign Up</button>
    </div>
    <a href="login.php">Do have an account? Log In</a>
  </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

