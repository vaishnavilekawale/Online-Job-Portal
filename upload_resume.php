<?php
session_start();
include "config.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'applicant') {
    header("Location: user_login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["resume"])) {
    if (!empty($_FILES["resume"]["name"])) {
        $targetDir = "uploads/";

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $fileName = basename($_FILES["resume"]["name"]);
        $targetFilePath = $targetDir . $fileName;

        if (move_uploaded_file($_FILES["resume"]["tmp_name"], $targetFilePath)) {
            $check = mysqli_query($conn, "SELECT * FROM user_profiles WHERE user_id = '$user_id'");
            if (mysqli_num_rows($check) > 0) {
                $sql = "UPDATE user_profiles SET resume = '$targetFilePath' WHERE user_id = '$user_id'";
            } else {
                $sql = "INSERT INTO user_profiles (user_id, resume) VALUES ('$user_id', '$targetFilePath')";
            }

            $msg = mysqli_query($conn, $sql)
                ? "<span style='color: #00ff99;'>✅ Resume uploaded successfully!</span>"
                : "<span style='color: #ff4d4d;'>❌ Database error.</span>";
        } else {
            $msg = "<span style='color: #ff4d4d;'>❌ File upload failed.</span>";
        }
    } else {
        $msg = "<span style='color: orange;'>⚠️ Please select a file.</span>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload Resume</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: url('../job-portal-website/images/upload_resume.avif') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
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

        .back-link {
            position: absolute;
            top: 30px; 
            left: 30px; 
            color: #00ffaa; 
            text-decoration: none;
            font-weight: 600; 
            background-color: rgba(0, 0, 0, 0.3); 
            padding: 10px 18px; 
            border-radius: 8px; 
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3); 
            display: inline-flex;
            align-items: center;
            gap: 8px;
            z-index: 2; 
        }

        .back-link:hover {
            background-color: rgba(0, 0, 0, 0.5); 
            transform: translateY(-2px); 
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.4);
        }

        .container {
            max-width: 480px; 
            width: 90%; 
            margin: auto; 
            padding: 45px; 
            background: rgba(0, 0, 0, 0.75); 
            backdrop-filter: blur(12px); 
            border-radius: 20px; 
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.5); 
            border: 1px solid rgba(255, 255, 255, 0.2); 
            position: relative;
            z-index: 1;
            animation: fadeIn 0.8s ease-out forwards; 
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
            color: #ffd700; 
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.6); 
            letter-spacing: 1px;
        }

        input[type="file"] {
            width: 100%;
            padding: 14px; 
            border: none;
            border-radius: 10px; 
            background: rgba(255, 255, 255, 0.15); 
            color: #fff;
            margin-bottom: 25px; 
            border: 1px solid rgba(255, 255, 255, 0.2); 
            font-size: 16px; 
            cursor: pointer;
            transition: all 0.3s ease;
        }
        input[type="file"]:hover {
            background-color: rgba(255, 255, 255, 0.25);
            border-color: #00BFFF; 
        }

        ::file-selector-button {
            background: linear-gradient(135deg, #00BFFF, #008DCC); 
            color: white;
            border: none;
            border-radius: 8px; 
            padding: 8px 15px; 
            cursor: pointer;
            font-size: 15px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 3px 8px rgba(0, 191, 255, 0.3);
        }

        ::file-selector-button:hover {
            background: linear-gradient(135deg, #008DCC, #0056b3);
            transform: translateY(-1px);
            box-shadow: 0 5px 10px rgba(0, 191, 255, 0.4);
        }

        input[type="submit"] {
            width: 100%;
            background: linear-gradient(135deg, #28a745, #218838); 
            color: white;
            padding: 15px; 
            border: none;
            border-radius: 10px; 
            font-size: 18px; 
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.4); 
        }

        input[type="submit"]:hover {
            background: linear-gradient(135deg, #218838, #1e7e34);
            transform: translateY(-2px); 
            box-shadow: 0 8px 20px rgba(40, 167, 69, 0.6); 
        }

        p {
            text-align: center;
            margin-top: 25px; 
            font-weight: 600; 
            font-size: 17px;
        }

        @media (max-width: 600px) {
            .container {
                padding: 30px;
            }
            h2 {
                font-size: 28px;
                margin-bottom: 25px;
            }
            input[type="file"], input[type="submit"] {
                padding: 12px;
                font-size: 16px;
            }
            p {
                font-size: 15px;
            }
            .back-link {
                top: 20px;
                left: 20px;
                padding: 8px 14px;
                font-size: 14px;
            }
        }

        @media (max-width: 400px) {
            .container {
                padding: 25px;
            }
            h2 {
                font-size: 24px;
            }
            input[type="file"], input[type="submit"] {
                padding: 10px;
                font-size: 14px;
            }
            ::file-selector-button {
                padding: 6px 10px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

    <a href="applicant_dashboard.php" class="back-link"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>

    <div class="container">
        <h2>Upload Your Resume</h2>
        <form method="POST" enctype="multipart/form-data">
            <input type="file" name="resume" required><br>
            <input type="submit" value="Upload Resume">
        </form>
        <p><?php echo $msg; ?></p>
    </div>
</body>
</html>