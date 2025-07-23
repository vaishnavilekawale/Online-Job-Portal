<?php
session_start();
include "config.php";

$email = $password = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['name']    = $user['name'];
            $_SESSION['role']    = $user['role'];

            if ($user['role'] == 'applicant') {
                header("Location: applicant_dashboard.php");
            } elseif ($user['role'] == 'recruiter') {
                header("Location: recruiter_dashboard.php");
            }
            exit;
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "No user found with this email.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Login</title>
    <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: url('../job-portal-website/images/user_login.avif') no-repeat center center fixed;
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

    .form-box {
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

    h2 {
      text-align: center;
      margin-bottom: 35px;
      font-size: 32px;
      color: #fff;
      text-shadow: 2px 2px 6px #000;
      letter-spacing: 1px;
    }

    input[type="email"],
    input[type="password"] {
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

    input::placeholder {
      color: #eee;
      opacity: 0.8;
    }

    input[type="email"]:focus,
    input[type="password"]:focus {
      background-color: rgba(255, 255, 255, 0.3);
      border-color: #00BFFF;
      outline: none;
      box-shadow: 0 0 0 3px rgba(0, 191, 255, 0.3);
    }

    .btn {
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

    .btn:hover {
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

    .link {
      display: block;
      text-align: center;
      margin-top: 15px;
      color: #00BFFF;
      font-weight: 500;
      text-decoration: none;
      transition: color 0.3s ease;
    }

    .link:hover {
      color: #008DCC;
      text-decoration: underline;
    }

    .top-link {
      position: absolute;
      top: 30px;
      left: 30px;
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
      z-index: 2;
    }

    .top-link:hover {
      background-color: rgba(0, 0, 0, 0.7);
      transform: translateY(-2px);
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.4);
    }

    @media (max-width: 480px) {
      .form-box {
        margin: 20px;
        padding: 30px 25px;
      }

      h2 {
        font-size: 28px;
      }

      input, .btn {
        padding: 12px;
        font-size: 15px;
      }

      .top-link {
        padding: 8px 14px;
        font-size: 14px;
        top: 20px;
        left: 20px;
      }
    }
  </style>
</head>
<body>
  <a class="top-link" href="index.html">&larr; Back to Home</a>

    <div class="form-box">
        <h2>User Login</h2>
        <form method="POST">
            <input type="email" name="email" placeholder="Email Address" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" value="Login" class="btn">
        </form>
        <?php if ($error): ?>
            <p class="error"><?= $error ?></p>
        <?php endif; ?>
    </div>
</body>
</html>