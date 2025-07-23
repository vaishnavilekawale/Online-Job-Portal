<?php
session_start();
include 'config.php';

$msg = '';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'recruiter') {
    header("Location: user_login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$companies = [];

$user_id_escaped = mysqli_real_escape_string($conn, $user_id);
$sql = "SELECT * FROM companies WHERE user_id = '$user_id_escaped'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $companies[] = $row;
    }
} else {
    $msg = "⚠️ You haven't added your company details yet. Please add them from the dashboard.";
    $msg_class = "warning-msg";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Company Info</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: url('../job-portal-website/images/view_company.jpg') no-repeat center center fixed;
      background-size: cover;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
      position: relative;
      overflow: auto;
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
    html, body {
    height: auto;
    max-height: none;
    overflow: auto;
    font-family: 'Poppins', sans-serif;
  }

    .container {
      background: rgba(0, 0, 0, 0.75);
      backdrop-filter: blur(12px);
      border-radius: 18px;
      padding: 45px;
      width: 100%;
      max-width: 650px;
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
      color: #00eaff;
      text-shadow: 2px 2px 6px #000;
      letter-spacing: 1px;
      font-weight: 700;
    }

    .info {
      font-size: 18px;
      line-height: 1.8;
      text-align: left;
      padding: 20px;
      background-color: rgba(255, 255, 255, 0.08);
      border-radius: 12px;
      border: 1px solid rgba(255, 255, 255, 0.15);
      box-shadow: 0 2px 8px rgba(0,0,0,0.3);
    }

    .info p {
      margin-bottom: 12px;
      display: flex;
      align-items: flex-start;
      gap: 15px;
      font-weight: 400;
    }
    .info p:last-child {
        margin-bottom: 0;
    }

    .info strong {
      color: #00ff9d;
      min-width: 130px;
      display: inline-block;
      font-weight: 600;
      text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.4);
    }
    .info .fas {
        color: #00eaff;
        font-size: 20px;
        flex-shrink: 0;
    }

    .back-btn {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      margin-bottom: 25px;
      color: #00ffaa;
      text-decoration: none;
      font-weight: bold;
      background-color: rgba(0, 0, 0, 0.4);
      padding: 10px 18px;
      border-radius: 8px;
      transition: all 0.3s ease, transform 0.2s ease;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    }

    .back-btn:hover {
      background-color: rgba(0, 0, 0, 0.6);
      transform: translateY(-2px);
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.4);
      color: #fff;
    }
    .back-btn .fas {
        font-size: 18px;
    }

    .message {
      text-align: center;
      margin-top: 25px;
      font-weight: bold;
      font-size: 16px;
      background-color: rgba(40, 167, 69, 0.2);
      padding: 12px;
      border-radius: 8px;
      border: 1px solid rgba(40, 167, 69, 0.4);
      color: #d4edda;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
    }

    .message .fas {
        font-size: 20px;
    }

    .message.error-msg, .message.warning-msg {
        color: #ff6b6b;
        background-color: rgba(220, 53, 69, 0.2);
        border: 1px solid rgba(220, 53, 69, 0.4);
    }

    @media (max-width: 650px) {
      .container {
        padding: 35px 30px;
        margin: 0 15px;
      }
      h2 {
        font-size: 30px;
        margin-bottom: 30px;
      }
      .info {
        font-size: 17px;
        padding: 15px;
      }
      .info strong {
        min-width: 110px;
      }
      .message {
        font-size: 15px;
        padding: 10px;
        margin-top: 20px;
      }
      .back-btn {
        padding: 8px 15px;
        font-size: 15px;
        margin-bottom: 20px;
      }
    }

    @media (max-width: 480px) {
      .container {
        padding: 25px 20px;
      }
      h2 {
        font-size: 26px;
        margin-bottom: 25px;
      }
      .info {
        font-size: 16px;
        line-height: 1.6;
      }
      .info p {
        flex-direction: column;
        align-items: flex-start;
        gap: 5px;
        margin-bottom: 8px;
      }
      .info strong {
        min-width: auto;
        display: block;
        margin-bottom: 5px;
      }
      .info .fas {
          margin-right: 0;
          margin-bottom: 5px;
      }
      .message .fas {
          font-size: 18px;
      }
    }
  </style>
</head>
<body>

<div class="container">
  <a href="recruiter_dashboard.php" class="back-btn"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
  <h2><i class="fas fa-building"></i> My Company Details</h2>

  <?php if (!empty($companies)): ?>
  <?php foreach ($companies as $company): ?>
    <div class="info">
      <p><strong><i class="fas fa-building"></i> Company Name:</strong> <?= htmlspecialchars($company['company_name']) ?></p>
      <p><strong><i class="fas fa-map-marker-alt"></i> Location:</strong> <?= htmlspecialchars($company['location']) ?></p>
      <p><strong><i class="fas fa-envelope"></i> Email:</strong> <?= htmlspecialchars($company['email']) ?></p>
      <p><strong><i class="fas fa-calendar-alt"></i> Registered On:</strong> <?= date("d M Y, h:i A", strtotime($company['created_at'])) ?></p>
    </div>
    <br>
  <?php endforeach; ?>
<?php else: ?>

    <p class="message <?= $msg_class ?>">
        <?php
            if (strpos($msg, '✅') !== false) echo '<i class="fas fa-check-circle"></i> ';
            else if (strpos($msg, '❌') !== false) echo '<i class="fas fa-times-circle"></i> ';
            else if (strpos($msg, '⚠️') !== false) echo '<i class="fas fa-exclamation-triangle"></i> ';
            echo htmlspecialchars($msg);
        ?>
    </p>
  <?php endif; ?>
</div>

</body>
</html>