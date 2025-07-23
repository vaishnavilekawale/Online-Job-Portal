<?php
session_start();
include "config.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Available Jobs - Job Portal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            background: url('../job-portal-website/images/jobs.avif') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Poppins', sans-serif;
            color: #fff;
            min-height: 100vh;
            padding: 30px 0;
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
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
        .top-bar {
            width: 100%;
            max-width: 1100px;
            margin: 0 auto 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
            z-index: 1;
        }
        .top-bar a {
            color: #00ffaa;
            text-decoration: none;
            font-weight: 600;
            font-size: 17px;
            padding: 8px 15px;
            border-radius: 8px;
            transition: all 0.3s ease;
            background-color: rgba(0, 0, 0, 0.3);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        .top-bar a:hover {
            color: #ffffff;
            background-color: rgba(0, 0, 0, 0.5);
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
        }
        .container {
            width: 95%;
            max-width: 1100px;
            margin: auto;
            background: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(12px);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.2);
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
        h2 {
            text-align: center;
            font-size: 38px;
            margin-bottom: 45px;
            color: #00eaff;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.6);
            letter-spacing: 1px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }
        .job-card {
            background-color: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 18px;
            padding: 30px;
            margin-bottom: 30px;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }
        .job-card:hover {
            transform: translateY(-5px);
            background-color: rgba(255, 255, 255, 0.12);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
        }
        .job-card h3 {
            margin-bottom: 15px;
            color: #ffd700;
            font-size: 26px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .job-card p {
            margin: 10px 0;
            color: #e0e0e0;
            font-size: 17px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .job-card p strong {
            color: #00eaff;
        }
        .job-buttons {
            margin-top: 25px;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: flex-end;
        }
        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 16px;
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
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(40, 167, 69, 0.5);
        }
        .save-btn {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
        }
        .save-btn:hover {
            background: linear-gradient(135deg, #0056b3, #004080);
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0, 123, 255, 0.5);
        }
        .no-jobs {
            text-align: center;
            color: #ffd700;
            font-size: 22px;
            margin-top: 60px;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        @media (max-width: 768px) {
            .top-bar {
                flex-direction: column;
                gap: 15px;
                margin-bottom: 20px;
            }
            .top-bar a {
                width: 90%;
                justify-content: center;
            }
            .container {
                padding: 25px;
            }
            h2 {
                font-size: 30px;
                margin-bottom: 35px;
            }
            .job-card {
                padding: 20px;
            }
            .job-card h3 {
                font-size: 22px;
            }
            .job-card p {
                font-size: 15px;
            }
            .job-buttons {
                flex-direction: column;
                gap: 10px;
            }
            .btn {
                width: 100%;
            }
        }
        @media (max-width: 480px) {
            .container {
                padding: 15px;
            }
            h2 {
                font-size: 26px;
                gap: 10px;
            }
            .job-card h3 {
                font-size: 20px;
            }
            .job-card p {
                font-size: 14px;
            }
            .no-jobs {
                font-size: 18px;
                margin-top: 40px;
            }
        }
    </style>
</head>
<body>

    <div class="top-bar">
        <a href="applicant_dashboard.php"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
        <a href="index.html">Home <i class="fas fa-home"></i></a>
    </div>

    <div class="container">
        <h2><i class="fas fa-briefcase"></i> Available Jobs</h2>

        <?php
        $sql = "SELECT jobs.*, companies.company_name
                FROM jobs
                INNER JOIN companies ON jobs.company_id = companies.company_id
                ORDER BY jobs.created_at DESC";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($job = mysqli_fetch_assoc($result)) {
                echo "<div class='job-card'>";
                echo "<h3><i class='fas fa-building'></i> " . htmlspecialchars($job['title']) . "</h3>";
                echo "<p><strong>🏢 Company:</strong> " . htmlspecialchars($job['company_name']) . "</p>";
                echo "<p><strong>📍 Location:</strong> " . htmlspecialchars($job['location']) . "</p>";
                echo "<p><strong>📂 Category:</strong> " . htmlspecialchars($job['category']) . "</p>";
                echo "<p><strong>💰 Salary:</strong> " . htmlspecialchars($job['salary_range']) . "</p>";
                echo "<div class='job-buttons'>";
                echo "<a class='btn apply-btn' href='apply_job.php?job_id=" . $job['job_id'] . "'><i class='fas fa-paper-plane'></i> Apply Now</a>";
                echo "<a class='btn save-btn' href='save_job.php?job_id=" . $job['job_id'] . "'><i class='fas fa-bookmark'></i> Save Job</a>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<p class='no-jobs'>No jobs posted yet.</p>";
        }
        ?>
    </div>

</body>
</html>