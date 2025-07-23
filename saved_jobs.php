<?php
session_start();
include "config.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'applicant') {
    header("Location: user_login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT jobs.* FROM saved_jobs 
        JOIN jobs ON saved_jobs.job_id = jobs.job_id 
        WHERE saved_jobs.user_id = '$user_id' 
        ORDER BY saved_jobs.saved_at DESC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Saved Jobs</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: url('../job-portal-website/images/saved_jobs.avif') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 30px 20px;
            position: relative;
            overflow-y: auto; 
            color: #fff;
        }

        body::before {
            content: '';
            position: fixed; 
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to right, rgba(15, 32, 39, 0.6), rgba(32, 58, 67, 0.6), rgba(44, 83, 100, 0.6));
            z-index: 0;
        }

        .container {
            width: 100%;
            max-width: 950px;
            margin: 80px auto 40px auto; 
            padding: 40px;
            background: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(12px);
            border-radius: 20px;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            z-index: 1;
            animation: fadeInScale 0.8s ease-out forwards;
        }

        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.95) translateY(20px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .back-link {
            position: fixed; 
            top: 30px; 
            left: 30px; 
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #00ffaa;
            text-decoration: none;
            font-weight: 600;
            background-color: rgba(0, 0, 0, 0.3);
            padding: 10px 18px;
            border-radius: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            z-index: 10; 
        }

        .back-link:hover {
            background-color: rgba(0, 0, 0, 0.5);
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.4);
        }

        h2 {
            text-align: center;
            margin-bottom: 40px;
            font-size: 38px;
            color: #ffd700;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.6);
            letter-spacing: 1px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }

        .message {
            text-align: center;
            color: #00ffaa;
            font-weight: 600;
            margin-bottom: 25px;
            font-size: 18px;
            background-color: rgba(0, 255, 170, 0.1);
            padding: 10px 15px;
            border-radius: 8px;
            border: 1px solid rgba(0, 255, 170, 0.3);
        }

        .job-card {
            background: rgba(255, 255, 255, 0.08);
            padding: 30px;
            border-radius: 18px;
            margin-bottom: 25px;
            border-left: 6px solid #00eaff;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .job-card:hover {
            transform: translateY(-5px);
            background-color: rgba(255, 255, 255, 0.12);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
        }

        .job-card h3 {
            margin: 0 0 12px;
            color: #00eaff;
            font-size: 26px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .job-card p {
            margin: 8px 0;
            color: #e0e0e0;
            font-size: 17px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .job-card p strong {
            color: #00eaff;
        }

        .job-actions {
            display: flex;
            justify-content: flex-end;
            gap: 20px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .action-btn {
            text-decoration: none;
            padding: 12px 25px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .apply-btn {
            background: linear-gradient(135deg, #28a745, #218838);
            color: white;
        }

        .apply-btn:hover {
            background: linear-gradient(135deg, #218838, #1e7e34);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(40, 167, 69, 0.5);
        }

        .unsave-btn {
            background: linear-gradient(135deg, #dc3545, #c82333);
            color: white;
        }

        .unsave-btn:hover {
            background: linear-gradient(135deg, #c82333, #bd2130);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(220, 53, 69, 0.5);
        }

        .no-jobs {
            text-align: center;
            font-size: 22px;
            margin-top: 60px;
            color: #ffd700;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        @media (max-width: 768px) {
            .container {
                padding: 30px;
                margin-top: 70px; 
            }
            h2 {
                font-size: 30px;
                margin-bottom: 30px;
            }
            .job-card {
                padding: 25px;
            }
            .job-card h3 {
                font-size: 22px;
            }
            .job-card p {
                font-size: 16px;
            }
            .job-actions {
                flex-direction: column;
                gap: 10px;
            }
            .action-btn {
                width: 100%;
                justify-content: center;
            }
            .back-link {
                top: 20px;
                left: 20px;
                padding: 8px 15px;
                font-size: 15px;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 20px;
                margin-top: 60px; 
            }
            h2 {
                font-size: 26px;
                gap: 10px;
            }
            .job-card {
                padding: 20px;
            }
            .job-card h3 {
                font-size: 20px;
            }
            .job-card p {
                font-size: 15px;
            }
            .no-jobs {
                font-size: 18px;
                margin-top: 40px;
            }
            .back-link {
                top: 20px;
                left: 20px;
                padding: 7px 12px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

    <a href="applicant_dashboard.php" class="back-link"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>

    <div class="container">
        <h2><i class="fas fa-bookmark"></i> My Saved Jobs</h2>

        <?php if (isset($_GET['message'])): ?>
            <p class="message"><?= htmlspecialchars($_GET['message']) ?></p>
        <?php endif; ?>

        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($job = mysqli_fetch_assoc($result)) {
                echo "<div class='job-card'>";
                echo "<h3><i class='fas fa-briefcase'></i> " . htmlspecialchars($job['title']) . "</h3>";
                echo "<p><i class='fas fa-map-marker-alt'></i> <strong>Location:</strong> " . htmlspecialchars($job['location']) . "</p>";
                echo "<p><i class='fas fa-tags'></i> <strong>Category:</strong> " . htmlspecialchars($job['category']) . "</p>";
                echo "<p><i class='fas fa-dollar-sign'></i> <strong>Salary:</strong> " . htmlspecialchars($job['salary_range']) . "</p>";
                echo "<div class='job-actions'>";
                echo "<a class='action-btn apply-btn' href='apply_job.php?job_id=" . $job['job_id'] . "'><i class='fas fa-paper-plane'></i> Apply Now</a>";
                echo "<a class='action-btn unsave-btn' href='unsave_job.php?job_id=" . $job['job_id'] . "' onclick=\"return confirm('Are you sure you want to unsave this job?')\"><i class='fas fa-trash-alt'></i> Unsave</a>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<p class='no-jobs'>You haven’t saved any jobs yet. Start exploring the <a href='jobs.php' style='color:#00eaff; text-decoration: underline;'>Available Jobs</a>!</p>";
        }
        ?>
    </div>
</body>
</html>