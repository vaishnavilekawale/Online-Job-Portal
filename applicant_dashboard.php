<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'applicant') {
    header("Location: user_login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Applicant Dashboard</title>
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
            background: url('../job-portal-website/images/applicant_dashboard.avif') no-repeat center center fixed;
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
            background-color: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(15px);
            padding: 50px;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.5);
            text-align: center;
            max-width: 550px;
            width: 90%;
            position: relative;
            z-index: 1;
            border: 1px solid rgba(255, 255, 255, 0.2); 
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
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }
        h2 .wave {
            font-size: 32px;
            color: #00ffaa;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            margin: 25px 0;
        }

        .btn-link {
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

        .btn-link:hover {
            background-color: #008DCC;
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 191, 255, 0.6);
        }

        .home-link {
            position: absolute;
            top: 30px;
            left: 30px;
            font-size: 15px;
            text-decoration: none;
            color: #00ffaa;
            background-color: rgba(0, 0, 0, 0.4);
            padding: 10px 18px;
            border-radius: 8px;
            transition: 0.3s ease, transform 0.2s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-weight: bold;
            z-index: 2;
        }

        .home-link:hover {
            background-color: rgba(0, 0, 0, 0.6);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.4);
        }

        @media (max-width: 600px) {
            .dashboard {
                padding: 40px 25px;
            }

            h2 {
                font-size: 30px;
                margin-bottom: 30px;
            }

            .btn-link {
                padding: 14px;
                font-size: 16px;
            }

            .home-link {
                top: 20px;
                left: 20px;
                padding: 8px 14px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <a href="index.html" class="home-link"><i class="fas fa-home"></i> Home</a>
    <div class="dashboard">
        <!-- <h2>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?> <span class="👋">👋</span></h2> -->
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?> <span class="wave">👋</span></h2>
        <ul>
            <li><a class="btn-link" href="jobs.php"><i class="fas fa-briefcase"></i> View Jobs</a></li>
            <li><a class="btn-link" href="view_applications.php"><i class="fas fa-list-alt"></i> My Applications</a></li>
            <li><a class="btn-link" href="upload_resume.php"><i class="fas fa-file-upload"></i> Upload Resume</a></li>
            <li><a class="btn-link" href="saved_jobs.php"><i class="fas fa-bookmark"></i> My Saved Jobs</a></li>
            <li><a class="btn-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>
</body>
</html>