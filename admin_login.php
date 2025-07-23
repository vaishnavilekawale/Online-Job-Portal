<?php
session_start();
include "config.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email    = $_POST['email'];
    $password = md5($_POST['password']);

    $sql = "SELECT * FROM admin WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $_SESSION['admin'] = $email;
        header("Location: admin_dashboard.php");
        exit;
    } else {
        $error = "Invalid login credentials.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: url('../job-portal-website/images/admin_login.avif') no-repeat center center fixed;
      background-size: cover;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
      position: relative;
      overflow: hidden;
    }

    body::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(to right, rgba(15, 32, 39, 0.7), rgba(32, 58, 67, 0.7), rgba(44, 83, 100, 0.7));
      z-index: 0;
    }

    .login-box {
      background: rgba(0, 0, 0, 0.75);
      backdrop-filter: blur(12px);
      border-radius: 18px;
      padding: 45px;
      width: 100%;
      max-width: 450px;
      box-shadow: 0 10px 35px rgba(0, 0, 0, 0.5);
      color: #fff;
      position: relative;
      z-index: 1;
      border: 1px solid rgba(255, 255, 255, 0.2);
      animation: fadeIn 0.8s ease-out;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(-20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .login-box h2 {
      text-align: center;
      margin-bottom: 35px;
      font-size: 32px;
      color: #fff;
      text-shadow: 2px 2px 6px #000;
      letter-spacing: 1px;
    }

    .login-box input[type="email"],
    .login-box input[type="password"] {
      width: 100%;
      padding: 14px;
      margin: 15px 0;
      border: none;
      border-radius: 10px;
      font-size: 16px;
      background-color: rgba(255, 255, 255, 0.2);
      color: #fff;
      border: 1px solid rgba(255, 255, 255, 0.3);
      transition: all 0.3s ease;
    }

    .login-box input[type="email"]:focus,
    .login-box input[type="password"]:focus {
      background-color: rgba(255, 255, 255, 0.3);
      border-color: #00BFFF;
      outline: none;
      box-shadow: 0 0 0 3px rgba(0, 191, 255, 0.3);
    }

    .login-box input::placeholder {
      color: #eee;
      opacity: 0.8;
    }

    .login-box input[type="submit"] {
      width: 100%;
      padding: 14px;
      background-color: #00BFFF;
      border: none;
      border-radius: 10px;
      color: white;
      font-size: 18px;
      font-weight: bold;
      cursor: pointer;
      margin-top: 25px;
      transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
      box-shadow: 0 5px 15px rgba(0, 191, 255, 0.4);
    }

    .login-box input[type="submit"]:hover {
      background-color: #008DCC;
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(0, 191, 255, 0.6);
    }

    .error {
      text-align: center;
      color: #ff6b6b;
      margin-top: 20px;
      font-weight: bold;
      font-size: 16px;
      background-color: rgba(255, 0, 0, 0.15);
      padding: 10px;
      border-radius: 8px;
    }

    .top-link {
      position: absolute;
      top: 30px;
      left: 30px;
      z-index: 2;
    }

    .top-link a {
      color: #fff;
      text-decoration: none;
      font-weight: bold;
      background-color: rgba(0, 0, 0, 0.5);
      padding: 10px 18px;
      border-radius: 8px;
      transition: 0.3s ease, transform 0.2s ease;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
      display: inline-flex;
      align-items: center;
      gap: 8px;
    }

    .top-link a:hover {
      background-color: rgba(0, 0, 0, 0.7);
      transform: translateY(-2px);
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.4);
    }
  </style>
</head>
<body>

  <div class="top-link">
    <a href="index.html">&larr; Back to Home</a>
  </div>

  <div class="login-box">
    <h2>Admin Login</h2>
    <form method="POST">
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <input type="submit" value="Login">
    </form>
    <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
  </div>

</body>
</html>