<?php
session_start();
include "config.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'applicant') {
    header("Location: user_login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$job_id = $_GET['job_id'] ?? null;

if ($job_id) {
    $check = mysqli_query($conn, "SELECT * FROM saved_jobs WHERE job_id='$job_id' AND user_id='$user_id'");
    
    if (mysqli_num_rows($check) == 0) {
        $sql = "INSERT INTO saved_jobs (job_id, user_id) VALUES ('$job_id', '$user_id')";
        if (mysqli_query($conn, $sql)) {
            $msg = "✅ Job saved successfully!";
            $msg_class = "success";
        } else {
            $msg = "❌ Something went wrong.";
            $msg_class = "error";
        }
    } else {
        $msg = "⚠️ You have already saved this job.";
        $msg_class = "warning";
    }
} else {
    $msg = "❌ Invalid job ID.";
    $msg_class = "error";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Save Job</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            background: url('../job-portal-website/images/save_job.avif') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
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
            background: linear-gradient(to right, rgba(15, 32, 39, 0.6), rgba(32, 58, 67, 0.6), rgba(44, 83, 100, 0.6));
            z-index: 0;
        }

        .container {
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(12px);
            padding: 45px;
            border-radius: 20px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.6);
            text-align: center;
            max-width: 480px;
            width: 90%;
            position: relative;
            z-index: 1;
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
            font-size: 36px;
            color: #ffd700;
            letter-spacing: 1.5px;
            text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.7);
            margin-bottom: 25px;
        }

        p {
            font-size: 20px;
            margin: 30px 0;
            line-height: 1.5;
            font-weight: 500;
        }

        .success {
            color: #00ff99;
        }

        .error {
            color: #ff4c4c;
        }

        .warning {
            color: #ffc107;
        }

        a {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-top: 20px;
            padding: 14px 28px;
            background: linear-gradient(135deg, #00BFFF, #008DCC);
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-size: 18px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 6px 15px rgba(0, 191, 255, 0.4);
        }

        a:hover {
            background: linear-gradient(135deg, #008DCC, #0056b3);
            transform: translateY(-2px);
            box-shadow: 0 9px 20px rgba(0, 191, 255, 0.6);
        }

        @media (max-width: 600px) {
            .container {
                padding: 30px;
            }
            h2 {
                font-size: 30px;
            }
            p {
                font-size: 18px;
            }
            a {
                padding: 12px 20px;
                font-size: 16px;
            }
        }

        @media (max-width: 400px) {
            .container {
                padding: 25px;
            }
            h2 {
                font-size: 26px;
            }
            p {
                font-size: 16px;
            }
            a {
                padding: 10px 18px;
                font-size: 15px;
                gap: 8px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Save Job Status</h2>
        <p class="<?= $msg_class ?>"><?= $msg ?></p>
        <a href="jobs.php"><i class="fas fa-arrow-left"></i> Back to Jobs</a>
    </div>
</body>
</html>