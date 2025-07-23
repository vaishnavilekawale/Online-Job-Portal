<?php
session_start();
include "config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applications</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background: url('../job-portal-website/images/view_applications.avif') no-repeat center center fixed;
            background-size: cover;
            color: #fff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            padding: 20px;
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
            z-index: 0;
        }

        .back-link {
            position: fixed;
            top: 25px;
            left: 30px;
            color: #fff;
            font-weight: 600;
            text-decoration: none;
            background-color: #00BFFF;
            padding: 12px 22px;
            border-radius: 10px;
            transition: all 0.3s ease;
            z-index: 10;
            box-shadow: 0 4px 12px rgba(0, 191, 255, 0.4);
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .back-link:hover {
            background-color: #008DCC;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 191, 255, 0.6);
        }
        .back-link .fas {
            font-size: 16px;
        }

        .container {
            max-width: 900px;
            width: 100%;
            margin: 100px auto 40px auto;
            background: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(12px);
            padding: 45px;
            border-radius: 18px;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.5);
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
            margin-bottom: 40px;
            font-size: 36px;
            color: #00eaff;
            text-shadow: 2px 2px 6px #000;
            letter-spacing: 1.5px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }
        h2 .fas {
            font-size: 32px;
            color: #00ffaa;
        }

        .app-card {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .app-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
        }

        .app-card p {
            margin-bottom: 8px;
            font-size: 17px;
            line-height: 1.6;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }
        .app-card p:last-child {
            margin-bottom: 0;
        }
        .app-card strong {
            color: #00ffaa;
            min-width: 100px;
            display: inline-block;
            font-weight: 600;
        }
        .app-card .fas {
            color: #00eaff;
            font-size: 18px;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .status {
            padding: 6px 18px;
            border-radius: 25px;
            font-weight: 600;
            color: #fff;
            display: inline-block;
            margin-left: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
            text-transform: capitalize;
        }
        .applied { background: #007bff; }
        .accepted { background: #28a745; }
        .rejected { background: #dc3545; }

        .msg {
            text-align: center;
            font-weight: 600;
            margin: 20px 0;
            font-size: 17px;
            padding: 12px;
            border-radius: 10px;
            border: 1px solid;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        }
        .msg .fas {
            font-size: 20px;
        }
        .msg.success {
            color: #d4edda;
            background-color: rgba(40, 167, 69, 0.2);
            border-color: rgba(40, 167, 69, 0.4);
        }
        .msg.error {
            color: #ff6b6b;
            background-color: rgba(220, 53, 69, 0.2);
            border-color: rgba(220, 53, 69, 0.4);
        }

        .form-inline {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px dashed rgba(255,255,255,0.2);
        }
        .form-inline input,
        .form-inline textarea,
        .form-inline select {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 8px;
            border: none;
            font-size: 15px;
            background: rgba(255, 255, 255, 0.15);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.25);
            transition: all 0.3s ease;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }
        .form-inline input::placeholder,
        .form-inline textarea::placeholder {
            color: #ddd;
            opacity: 0.8;
        }
        .form-inline input:focus,
        .form-inline textarea:focus,
        .form-inline select:focus {
            outline: none;
            background-color: rgba(255, 255, 255, 0.25);
            border-color: #00BFFF;
            box-shadow: 0 0 0 3px rgba(0, 191, 255, 0.3);
        }
        .form-inline select {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23ffffff'%3E%3Cpath d='M7 10l5 5 5-5z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 18px;
            padding-right: 40px;
        }
        .form-inline select option {
            background-color: #2c5364;
            color: #fff;
        }

        .form-inline button {
            margin-top: 20px;
            width: 100%;
            background: #00BFFF;
            padding: 14px 0;
            border: none;
            border-radius: 10px;
            font-weight: bold;
            font-size: 17px;
            color: #fff;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 191, 255, 0.4);
        }
        .form-inline button:hover {
            background: #008DCC;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 191, 255, 0.6);
        }

        .no-apps {
            text-align: center;
            font-size: 20px;
            color: #eee;
            padding: 30px;
            background: rgba(255,255,255,0.05);
            border-radius: 15px;
            border: 1px solid rgba(255,255,255,0.1);
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            margin-top: 30px;
        }

        .resume-box {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 15px;
            background-color: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 8px;
            font-size: 15px;
            margin-top: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
            font-weight: 500;
        }
        .resume-box a {
            color: #00f7ff;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .resume-box a:hover {
            text-decoration: underline;
            color: #fff;
        }
        .resume-box .fas {
            color: #00ffaa;
            font-size: 16px;
        }

        @media (max-width: 768px) {
            .container {
                margin: 80px auto 30px auto;
                padding: 35px;
            }
            h2 {
                font-size: 30px;
                margin-bottom: 30px;
            }
            .app-card {
                padding: 25px;
            }
            .app-card p {
                font-size: 16px;
                flex-direction: column;
                align-items: flex-start;
                gap: 5px;
            }
            .app-card strong {
                min-width: auto;
            }
            .back-link {
                top: 20px;
                left: 20px;
                padding: 10px 18px;
                font-size: 14px;
            }
            .back-link .fas {
                font-size: 14px;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 25px 20px;
                margin: 70px auto 20px auto;
            }
            h2 {
                font-size: 26px;
                margin-bottom: 25px;
                gap: 10px;
            }
            h2 .fas {
                font-size: 24px;
            }
            .app-card {
                padding: 20px;
            }
            .app-card p {
                font-size: 15px;
            }
            .form-inline input,
            .form-inline textarea,
            .form-inline select {
                padding: 10px;
                font-size: 14px;
            }
            .form-inline button {
                padding: 12px;
                font-size: 15px;
            }
            .status {
                padding: 5px 12px;
                font-size: 14px;
            }
            .resume-box {
                padding: 6px 12px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

<?php if ($role === 'applicant'): ?>
  <a href="applicant_dashboard.php" class="back-link"><i class="fas fa-arrow-left"></i> Dashboard</a>
<?php else: ?>
  <a href="recruiter_dashboard.php" class="back-link"><i class="fas fa-arrow-left"></i> Dashboard</a>
<?php endif; ?>

<div class="container">
  <h2><i class="fas fa-list-alt"></i> Applications</h2>

  <?php if (isset($_GET['msg'])): ?>
    <div class="msg <?php echo ($_GET['msg'] === 'error') ? 'error' : 'success'; ?>">
      <?php echo $_GET['msg'] === 'updated' ? "<i class='fas fa-check-circle'></i> Status updated successfully!" : "<i class='fas fa-times-circle'></i> Failed to update status!"; ?>
    </div>
  <?php endif; ?>

  <?php
  if ($role === 'applicant') {
      $sql = "SELECT a.application_id, j.title, j.location, a.applied_at, a.status,
                      au.interview_date, au.interview_time, au.message, au.address,
                      c.company_name
              FROM applications a
              JOIN jobs j ON a.job_id = j.job_id
              JOIN companies c ON j.company_id = c.company_id
              LEFT JOIN application_updates au ON a.application_id = au.application_id
              WHERE a.user_id = '$user_id'
              ORDER BY a.applied_at DESC";
  } else {
      $sql = "SELECT a.application_id, u.name, j.title, a.applied_at, a.status,
                      au.interview_date, au.interview_time, au.message, au.address,
                      c.company_name, up.resume
              FROM applications a
              JOIN users u ON a.user_id = u.user_id
              JOIN jobs j ON a.job_id = j.job_id
              JOIN companies c ON j.company_id = c.company_id
              LEFT JOIN user_profiles up ON u.user_id = up.user_id
              LEFT JOIN application_updates au ON a.application_id = au.application_id
              WHERE c.user_id = '$user_id'
              ORDER BY a.applied_at DESC";
  }

  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
          $status = $row['status'];
          echo "<div class='app-card'>";

          if ($role === 'applicant') {
              echo "<p><strong><i class='fas fa-building'></i> Company:</strong> " . htmlspecialchars($row['company_name']) . "</p>";
              echo "<p><strong><i class='fas fa-briefcase'></i> Job:</strong> " . htmlspecialchars($row['title']) . "</p>";
              echo "<p><strong><i class='fas fa-map-marker-alt'></i> Location:</strong> " . htmlspecialchars($row['location']) . "</p>";
              echo "<p><strong><i class='fas fa-calendar-alt'></i> Applied on:</strong> " . date("d M Y, h:i A", strtotime($row['applied_at'])) . "</p>";
              echo "<p><strong><i class='fas fa-info-circle'></i> Status:</strong> <span class='status $status'>" . ucfirst($status) . "</span></p>";

              if ($status === 'accepted' && $row['interview_date']) {
                  $formattedTime = date("h:i A", strtotime($row['interview_time']));
                  echo "<p><strong><i class='fas fa-calendar-check'></i> Interview Date:</strong> " . htmlspecialchars($row['interview_date']) . "</p>";
                  echo "<p><strong><i class='fas fa-clock'></i> Time:</strong> " . $formattedTime . "</p>";
                  if (!empty($row['message'])) {
                      echo "<p><strong><i class='fas fa-comment'></i> Message:</strong> " . htmlspecialchars($row['message']) . "</p>";
                  }
                  if (!empty($row['address'])) {
                      echo "<p><strong><i class='fas fa-location-dot'></i> Address:</strong> " . htmlspecialchars($row['address']) . "</p>";
                  }
              }
          } else {
              echo "<p><strong><i class='fas fa-user'></i> Applicant:</strong> " . htmlspecialchars($row['name']) . "</p>";
              echo "<p><strong><i class='fas fa-building'></i> Company:</strong> " . htmlspecialchars($row['company_name']) . "</p>";
              echo "<p><strong><i class='fas fa-briefcase'></i> Job:</strong> " . htmlspecialchars($row['title']) . "</p>";
              echo "<p><strong><i class='fas fa-calendar-alt'></i> Date:</strong> " . date("d M Y, h:i A", strtotime($row['applied_at'])) . "</p>";

              if (!empty($row['resume'])) {
                  echo "<div class='resume-box'><i class='fas fa-file-alt'></i>
                               <a href='" . htmlspecialchars($row['resume']) . "' target='_blank'>View Resume</a>
                             </div>";
              } else {
                  echo "<div class='resume-box'><i class='fas fa-file-slash'></i> Resume not uploaded</div>";
              }
              echo "<form class='form-inline' method='post' action='update_status.php'>
                        <input type='hidden' name='application_id' value='" . htmlspecialchars($row['application_id']) . "'>
                        <label for='status-" . $row['application_id'] . "'><strong>Update Status:</strong></label>
                        <select name='status' id='status-" . $row['application_id'] . "' data-application-id='" . htmlspecialchars($row['application_id']) . "' required>
                            <option value='applied' " . ($status === 'applied' ? 'selected' : '') . ">Applied</option>
                            <option value='accepted' " . ($status === 'accepted' ? 'selected' : '') . ">Accepted</option>
                            <option value='rejected' " . ($status === 'rejected' ? 'selected' : '') . ">Rejected</option>
                        </select>";

              echo "<div id='interviewFields" . htmlspecialchars($row['application_id']) . "' style='display:" . ($status === 'accepted' ? 'block' : 'none') . ";'>
                            <input type='date' name='interview_date' placeholder='Interview Date' value='" . ($row['interview_date'] ? htmlspecialchars($row['interview_date']) : '') . "'>
                            <input type='time' name='interview_time' placeholder='Interview Time' value='" . ($row['interview_time'] ? htmlspecialchars($row['interview_time']) : '') . "'>
                            <textarea name='interview_message' placeholder='Message to applicant'>" . (!empty($row['message']) ? htmlspecialchars($row['message']) : '') . "</textarea>
                            <input type='text' name='interview_address' placeholder='Interview Address' value='" . (!empty($row['address']) ? htmlspecialchars($row['address']) : '') . "'>
                        </div>";

              echo "<button type='submit'><i class='fas fa-save'></i> Update</button>
                        </form>";

              echo "<script>
                            document.querySelectorAll('select[name=\"status\"]').forEach(select => {
                                select.addEventListener('change', function() {
                                    const applicationId = this.dataset.applicationId;
                                    const interviewFields = document.getElementById('interviewFields' + applicationId);
                                    if (this.value === 'accepted') {
                                        interviewFields.style.display = 'block';
                                        interviewFields.querySelectorAll('input, textarea').forEach(field => {
                                            field.setAttribute('required', 'required');
                                        });
                                    } else {
                                        interviewFields.style.display = 'none';
                                        interviewFields.querySelectorAll('input, textarea').forEach(field => {
                                            field.removeAttribute('required');
                                        });
                                    }
                                });

                                const applicationId = select.dataset.applicationId;
                                const interviewFields = document.getElementById('interviewFields' + applicationId);
                                if (select.value === 'accepted') {
                                    interviewFields.style.display = 'block';
                                    interviewFields.querySelectorAll('input, textarea').forEach(field => {
                                        field.setAttribute('required', 'required');
                                    });
                                } else {
                                    interviewFields.style.display = 'none';
                                }
                            });
                        </script>";
          }

          echo "</div>";
      }
  } else {
      echo "<p class='no-apps'><i class='fas fa-folder-open'></i> No applications found.</p>";
  }
  ?>
</div>
</body>
</html>