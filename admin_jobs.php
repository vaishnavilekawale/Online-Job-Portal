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

    mysqli_query($conn, "DELETE FROM applications WHERE job_id = '$id'");
    mysqli_query($conn, "DELETE FROM saved_jobs WHERE job_id = '$id'");

    if (mysqli_query($conn, "DELETE FROM jobs WHERE job_id = '$id'")) {
        $success = "✅ Job deleted successfully.";
    } else {
        $success = "❌ Failed to delete job: " . mysqli_error($conn);
    }
}

$result = mysqli_query($conn, "SELECT * FROM jobs ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Manage Jobs</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: url('../job-portal-website/images/admin_jobs.avif') no-repeat center center fixed;
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
      max-width: 1100px;
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
      font-size: 38px;
      margin-bottom: 30px;
      color: #00eaff;
      letter-spacing: 1.5px;
      text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.7);
    }

    .back-home {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      margin-bottom: 25px;
      color: #00ffaa;
      text-decoration: none;
      font-weight: bold;
      font-size: 16px;
      background-color: rgba(0, 0, 0, 0.4);
      padding: 10px 18px;
      border-radius: 8px;
      transition: 0.3s ease, transform 0.2s ease;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    }

    .back-home:hover {
      background-color: rgba(0, 0, 0, 0.6);
      transform: translateY(-2px);
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.4);
    }

    .success {
      text-align: center;
      color: #d4edda;
      font-weight: bold;
      margin-bottom: 20px;
      background-color: rgba(0, 255, 128, 0.2);
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

    tr:hover {
      background-color: rgba(255, 255, 255, 0.15);
    }

    a.delete-btn {
      color: #ff6b6b;
      font-weight: bold;
      text-decoration: none;
      transition: color 0.3s ease;
    }

    a.delete-btn:hover {
      color: #ff4d4d;
      text-decoration: underline;
    }

    @media (max-width: 768px) {
      table, thead, tbody, th, td, tr {
        display: block;
      }

      th {
        display: none;
      }

      td {
        padding: 10px;
        text-align: right;
        position: relative;
      }

      td::before {
        content: attr(data-label);
        position: absolute;
        left: 10px;
        font-weight: bold;
        color: #ccc;
        text-align: left;
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

      .back-home {
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
    <a class="back-home" href="admin_dashboard.php">&larr; Back to Admin Dashboard</a>
    <h2>All Job Listings</h2>

    <?php if (!empty($success)): ?>
      <div class="success"><?= $success ?></div>
    <?php endif; ?>

    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Title</th>
          <th>Category</th>
          <th>Location</th>
          <th>Salary</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
        <tr>
          <td data-label="ID"><?= $row['job_id'] ?></td>
          <td data-label="Title"><?= $row['title'] ?></td>
          <td data-label="Category"><?= $row['category'] ?></td>
          <td data-label="Location"><?= $row['location'] ?></td>
          <td data-label="Salary"><?= $row['salary_range'] ?></td>
          <td data-label="Action">
            <a class="delete-btn" href="?delete=<?= $row['job_id'] ?>" onclick="return confirm('Delete this job?')">Delete</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</body>
</html>