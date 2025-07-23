<?php
session_start();
include "config.php";

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}

$success = "";
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    mysqli_query($conn, "DELETE FROM applications WHERE user_id = '$id'");
    mysqli_query($conn, "DELETE FROM saved_jobs WHERE user_id = '$id'");
    mysqli_query($conn, "DELETE FROM user_profiles WHERE user_id = '$id'");
    mysqli_query($conn, "DELETE FROM companies WHERE user_id = '$id'");

    if (mysqli_query($conn, "DELETE FROM users WHERE user_id = '$id'")) {
        $success = "✅ User deleted successfully.";
    } else {
        $success = "❌ Error deleting user: " . mysqli_error($conn);
    }
}

$result = mysqli_query($conn, "SELECT * FROM users ORDER BY user_id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>All Registered Users</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: url('../job-portal-website/images/admin_users.jpg') no-repeat center center fixed;
      background-size: cover;
      color: #fff;
      min-height: 100vh;
      padding: 40px 20px;
      position: relative;
      overflow-x: hidden;
    }

    body::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(to right, rgba(15, 32, 39, 0.7), rgba(32, 58, 67, 0.7), rgba(44, 83, 100, 0.7));
      z-index: -1;
    }

    .container {
      max-width: 1000px;
      margin: auto;
      background: rgba(0, 0, 0, 0.8);
      padding: 40px;
      border-radius: 18px;
      box-shadow: 0 12px 35px rgba(0, 0, 0, 0.5);
      backdrop-filter: blur(10px);
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
      margin-bottom: 30px;
      font-size: 38px;
      color: #00eaff;
      letter-spacing: 1.5px;
      text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.7);
    }

    .back-link {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      margin-bottom: 25px;
      color: #00ffaa;
      font-weight: bold;
      text-decoration: none;
      background-color: rgba(0, 0, 0, 0.4);
      padding: 10px 18px;
      border-radius: 8px;
      transition: 0.3s ease, transform 0.2s ease;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    }

    .back-link:hover {
      background-color: rgba(0, 0, 0, 0.6);
      transform: translateY(-2px);
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.4);
    }

    .success {
      background-color: rgba(0, 255, 128, 0.2);
      color: #d4edda;
      font-weight: bold;
      text-align: center;
      margin-bottom: 20px;
      padding: 12px;
      border-radius: 10px;
      border: 1px solid rgba(0, 255, 128, 0.4);
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: rgba(255, 255, 255, 0.08);
      backdrop-filter: blur(8px);
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    }

    th, td {
      padding: 15px 18px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.2);
      text-align: center;
      color: #f0f0f0;
    }

    th {
      background-color: #00BFFF;
      color: #fff;
      text-transform: uppercase;
      font-size: 15px;
      letter-spacing: 0.5px;
      font-weight: bold;
    }

    a.delete-btn {
      color: #ff6b6b;
      text-decoration: none;
      font-weight: bold;
      transition: color 0.3s ease;
    }

    a.delete-btn:hover {
      color: #ff4d4d;
      text-decoration: underline;
    }

    tr:hover {
      background-color: rgba(255, 255, 255, 0.15);
    }

    @media (max-width: 768px) {
      table, thead, tbody, th, td, tr {
        display: block;
      }

      th {
        display: none;
      }

      td {
        text-align: right;
        padding-left: 50%;
        position: relative;
      }

      td::before {
        content: attr(data-label);
        position: absolute;
        left: 15px;
        font-weight: bold;
        color: #ccc;
      }

      .container {
        padding: 30px;
      }

      h2 {
        font-size: 30px;
      }
    }

    @media (max-width: 480px) {
      .container {
        padding: 20px;
      }

      h2 {
        font-size: 26px;
      }

      .back-link {
        padding: 8px 14px;
        font-size: 14px;
      }

      th, td {
        padding: 10px;
        font-size: 14px;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <a class="back-link" href="admin_dashboard.php">&larr; Back to Admin Dashboard</a>
    <h2>All Registered Users</h2>

    <?php if (!empty($success)): ?>
      <div class="success"><?= $success ?></div>
    <?php endif; ?>

    <table>
      <thead>
        <tr>
          <th>No.</th>
          <th>Name</th>
          <th>Email</th>
          <th>Role</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php $count = 1; while($row = mysqli_fetch_assoc($result)): ?>
          <tr>
            <td data-label="No."><?= $count++ ?></td>
            <td data-label="Name"><?= htmlspecialchars($row['name']) ?></td>
            <td data-label="Email"><?= htmlspecialchars($row['email']) ?></td>
            <td data-label="Role"><?= ucfirst($row['role']) ?></td>
            <td data-label="Action">
              <a class="delete-btn" href="?delete=<?= $row['user_id'] ?>" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</body>
</html>