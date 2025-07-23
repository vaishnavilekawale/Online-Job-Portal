<?php
session_start();
include "config.php";

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}

$sql = "SELECT
    users.name AS applicant,
    jobs.title AS job,
    applications.applied_at,
    applications.status,
    au.interview_date,
    au.interview_time,
    au.message,
    au.address,
    companies.company_name AS company_name
FROM applications
JOIN users ON applications.user_id = users.user_id
JOIN jobs ON applications.job_id = jobs.job_id
JOIN companies ON jobs.company_id = companies.company_id
LEFT JOIN application_updates au ON applications.application_id = au.application_id
ORDER BY applications.applied_at DESC";

$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
<head>
  <title>All Applications</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: url('../job-portal-website/images/admin_applications.avif') no-repeat center center fixed;
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
      max-width: 1400px;
      margin: auto;
      background: rgba(0, 0, 0, 0.8);
      padding: 40px;
      border-radius: 18px;
      box-shadow: 0 12px 35px rgba(0, 0, 0, 0.5);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.2);
      overflow-x: auto;
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

    table {
      width: 100%;
      border-collapse: collapse;
      background: rgba(255, 255, 255, 0.08);
      backdrop-filter: blur(8px);
      margin-top: 10px;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    }

    th, td {
      padding: 15px 18px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.2);
      text-align: center;
      color: #f0f0f0;
      font-size: 14px;
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

    .status {
      font-weight: bold;
      padding: 6px 12px;
      border-radius: 20px;
      display: inline-block;
      min-width: 90px;
    }

    .status.applied {
      background-color: #6c757d;
      color: #fff;
    }

    .status.accepted {
      background-color: #28a745;
      color: #fff;
    }

    .status.rejected {
      background-color: #dc3545;
      color: #fff;
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
        font-size: 12px;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <a class="back-link" href="admin_dashboard.php">&larr; Back to Admin Dashboard</a>
    <h2>All Job Applications</h2>
    <table>
      <thead>
        <tr>
          <th>Applicant</th>
          <th>Job Title</th>
          <th>Company</th>
          <th>Applied On</th>
          <th>Status</th>
          <th>Interview Date</th>
          <th>Interview Time</th>
          <th>Message</th>
          <th>Address</th>
        </tr>
      </thead>
      <tbody>
      <?php while($row = mysqli_fetch_assoc($result)):
        $statusClass = strtolower($row['status']);
      ?>
      <tr>
        <td data-label="Applicant"><?= htmlspecialchars($row['applicant']) ?></td>
        <td data-label="Job Title"><?= htmlspecialchars($row['job']) ?></td>
        <td data-label="Company"><?= htmlspecialchars($row['company_name']) ?></td>
        <td data-label="Applied On"><?= date("d M Y, h:i A", strtotime($row['applied_at'])) ?></td>
        <td data-label="Status">
          <span class="status <?= $statusClass ?>"><?= ucfirst($row['status']) ?></span>
        </td>
        <td data-label="Interview Date"><?= $row['interview_date'] ?? '-' ?></td>
        <td data-label="Interview Time"><?= $row['interview_time'] ? date("h:i A", strtotime($row['interview_time'])) : '-' ?></td>
        <td data-label="Message"><?= htmlspecialchars($row['message'] ?? '-') ?></td>
        <td data-label="Address"><?= htmlspecialchars($row['address'] ?? '-') ?></td>
      </tr>
      <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</body>
</html>