<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'recruiter') {
    header("Location: user_login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Recruiter Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: url('../job-portal-website/images/recruiter_dashboard.avif');
      background-size: cover;
      color: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
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
      background: rgba(0, 0, 0, 0.75);
      backdrop-filter: blur(12px);
      padding: 45px;
      border-radius: 18px;
      box-shadow: 0 12px 35px rgba(0, 0, 0, 0.5);
      max-width: 500px;
      width: 90%;
      text-align: center;
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

    .dashboard h2 {
      font-size: 32px;
      margin-bottom: 35px;
      color: #00eaff;
      text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.7);
      letter-spacing: 1.5px;
    }

    .back-home {
      position: absolute;
      top: 30px;
      left: 30px;
      font-size: 14px;
      text-decoration: none;
      background-color: rgba(0, 0, 0, 0.5);
      color: white;
      padding: 10px 18px;
      border-radius: 8px;
      transition: 0.3s ease, transform 0.2s ease;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
      z-index: 2;
      display: inline-flex;
      align-items: center;
      gap: 8px;
    }

    .back-home:hover {
      background-color: rgba(0, 0, 0, 0.7);
      transform: translateY(-2px);
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.4);
    }

    ul {
      list-style: none;
      padding: 0;
    }

    li {
      margin: 20px 0;
    }

    a.btn-link {
      display: inline-block;
      width: 100%;
      padding: 16px;
      background: linear-gradient(135deg, #00BFFF, #008DCC);
      color: white;
      text-decoration: none;
      border-radius: 10px;
      font-size: 18px;
      font-weight: bold;
      transition: all 0.3s ease;
      box-shadow: 0 6px 20px rgba(0, 191, 255, 0.4);
      border: 1px solid rgba(255, 255, 255, 0.3);
      letter-spacing: 0.5px;
    }

    a.btn-link:hover {
      background: linear-gradient(135deg, #008DCC, #0056b3);
      transform: translateY(-3px) scale(1.02);
      box-shadow: 0 10px 25px rgba(0, 191, 255, 0.6);
    }

    @media (max-width: 600px) {
      .dashboard {
        padding: 30px;
      }

      .dashboard h2 {
        font-size: 28px;
      }

      a.btn-link {
        font-size: 16px;
        padding: 14px;
      }

      .back-home {
        top: 20px;
        left: 20px;
        padding: 8px 14px;
        font-size: 13px;
      }
    }

    @media (max-width: 400px) {
      .dashboard {
        padding: 25px;
      }

      .dashboard h2 {
        font-size: 24px;
      }

      a.btn-link {
        font-size: 15px;
        padding: 12px;
      }
    }
  </style>
</head>
<body>

  <a href="index.html" class="back-home">&larr; Home</a>

  <div class="dashboard">
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?> (Recruiter)</h2>
    <ul>
      <li><a class="btn-link" href="add_company.php">🏢 Add/Update Company</a></li>
      <li><a class="btn-link" href="view_company.php">🏢 View My Company</a></li>
      <li><a class="btn-link" href="post_job.php">📝 Post New Job</a></li>
      <li><a class="btn-link" href="view_applications.php">📄 View Applications</a></li>
      <li><a class="btn-link" href="logout.php">🚪 Logout</a></li>
    </ul>
  </div>

</body>
</html>
