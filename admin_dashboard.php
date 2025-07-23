<?php
session_start();
include "config.php";
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: url('../job-portal-website/images/admin_dashboard.avif') no-repeat center center fixed;
      background-size: cover;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
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

    .dashboard {
      background-color: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(15px);
      padding: 50px;
      border-radius: 20px;
      box-shadow: 0 15px 40px rgba(0, 0, 0, 0.5);
      text-align: center;
      max-width: 550px;
      width: 90%;
      position: relative;
      z-index: 1;
      border: 1px solid rgba(255, 255, 255, 0.3);
      animation: slideIn 0.8s ease-out forwards;
    }

    @keyframes slideIn {
      from {
        opacity: 0;
        transform: translateY(-50px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    h2 {
      font-size: 36px;
      color: #ffd700;
      margin-bottom: 40px;
      text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.6);
    }

    ul {
      list-style: none;
      padding: 0;
    }

    li {
      margin: 25px 0;
    }

    a {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 100%;
      padding: 16px;
      background-color: #00BFFF;
      color: #fff;
      text-decoration: none;
      border-radius: 10px;
      font-size: 18px;
      font-weight: bold;
      transition: background 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
      box-shadow: 0 6px 20px rgba(0, 191, 255, 0.4);
      gap: 12px;
    }

    a:hover {
      background-color: #008DCC;
      transform: translateY(-3px);
      box-shadow: 0 10px 25px rgba(0, 191, 255, 0.6);
    }

    @media (max-width: 600px) {
      .dashboard {
        padding: 40px 25px;
      }

      h2 {
        font-size: 30px;
        margin-bottom: 30px;
      }

      a {
        padding: 14px;
        font-size: 16px;
      }
    }
  </style>
</head>
<body>

  <div class="dashboard">
    <h2>Welcome, Admin</h2>
    <ul>
      <li><a href="admin_users.php">👤 Manage Users</a></li>
      <li><a href="admin_jobs.php">💼 Manage Jobs</a></li>
      <li><a href="admin_applications.php">📄 View Applications</a></li>
      <li><a href="admin_logout.php">🚪 Logout</a></li>
    </ul>
  </div>

</body>
</html>