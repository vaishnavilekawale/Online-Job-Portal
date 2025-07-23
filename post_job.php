<?php
session_start();
include "config.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'recruiter') {
    header("Location: user_login.php");
    exit();
}

$msg = "";
$msg_class = "";

$recruiter_id = $_SESSION['user_id'];
$recruiter_id_escaped = mysqli_real_escape_string($conn, $recruiter_id);

$company_query = "SELECT company_id, company_name FROM companies WHERE user_id = '$recruiter_id_escaped'";
$company_result = mysqli_query($conn, $company_query);

$has_companies = mysqli_num_rows($company_result) > 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $company_id  = mysqli_real_escape_string($conn, $_POST['company_id']);
    $title       = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $location    = mysqli_real_escape_string($conn, $_POST['location']);
    $category    = mysqli_real_escape_string($conn, $_POST['category']);
    $salary      = mysqli_real_escape_string($conn, $_POST['salary']);

    $sql = "INSERT INTO jobs (company_id, title, description, location, category, salary_range) 
            VALUES ('$company_id', '$title', '$description', '$location', '$category', '$salary')";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['flash_msg'] = "✅ Job posted successfully!";
        $_SESSION['flash_class'] = "success-msg";
    } else {
        $_SESSION['flash_msg'] = "❌ Error posting job: " . mysqli_error($conn);
        $_SESSION['flash_class'] = "error-msg";
    }
    header("Location: post_job.php");
    exit();
}

if (isset($_SESSION['flash_msg'])) {
    $msg = $_SESSION['flash_msg'];
    $msg_class = $_SESSION['flash_class'];
    unset($_SESSION['flash_msg']);
    unset($_SESSION['flash_class']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post a Job</title>
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
            background: url('images/post_job.avif') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
            position: relative;
            padding: 20px;
            overflow: hidden;
        }

        html, body {
            overflow-x: hidden;
            overflow-y: auto;
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

        .form-container {
            background: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(12px);
            border-radius: 18px;
            padding: 45px 50px;
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

        .form-container h2 {
            text-align: center;
            margin-bottom: 35px;
            font-size: 32px;
            color: #00eaff;
            text-shadow: 2px 2px 6px #000;
            letter-spacing: 1px;
            font-weight: 700;
        }

        input[type="text"],
        textarea,
        select {
            width: 100%;
            padding: 14px;
            margin: 12px 0;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            background-color: rgba(255, 255, 255, 0.2);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }

        select {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23ffffff'%3E%3Cpath d='M7 10l5 5 5-5z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 18px;
            padding-right: 40px;
        }

        select option {
            background-color: #2c5364;
            color: #fff;
            padding: 10px;
        }
        select option:checked {
            background-color: #00bfff;
            color: #fff;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
            max-height: 250px;
        }

        input::placeholder,
        textarea::placeholder {
            color: #eee;
            opacity: 0.7;
        }

        input:focus,
        textarea:focus,
        select:focus {
            outline: none;
            background-color: rgba(255, 255, 255, 0.3);
            border-color: #00BFFF;
            box-shadow: 0 0 0 3px rgba(0, 191, 255, 0.3);
        }

        input[type="submit"] {
            width: 100%;
            padding: 16px;
            background-color: #00BFFF;
            border: none;
            border-radius: 10px;
            color: white;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 30px;
            transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 191, 255, 0.4);
        }

        input[type="submit"]:hover {
            background-color: #008DCC;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 191, 255, 0.6);
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
            padding: 14px 18px;
            border-radius: 10px;
            border: 1px solid;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.4);
            animation: slideFadeIn 0.6s ease-out;
        }

        .message .fas {
            font-size: 20px;
        }

        .success-msg {
            color: #d4edda;
            background-color: rgba(40, 167, 69, 0.2);
            border-color: rgba(40, 167, 69, 0.4);
        }

        .error-msg {
            color: #ff6b6b;
            background-color: rgba(220, 53, 69, 0.2);
            border-color: rgba(220, 53, 69, 0.4);
        }

        .warning-msg {
            color: #ffda6b;
            background-color: rgba(255, 218, 107, 0.2);
            border-color: rgba(255, 218, 107, 0.4);
        }

        .no-companies-msg {
            background-color: rgba(255, 165, 0, 0.2);
            border: 1px solid rgba(255, 165, 0, 0.4);
            color: #ffda6b;
            margin-top: 25px;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            font-size: 17px;
            font-weight: 500;
            box-shadow: 0 2px 8px rgba(0,0,0,0.3);
        }
        .no-companies-msg a {
            color: #00eaff;
            text-decoration: underline;
            font-weight: bold;
        }
        .no-companies-msg a:hover {
            color: #fff;
        }

        @media (max-width: 650px) {
            .form-container {
                padding: 35px 30px;
                margin: 0 15px;
            }
            h2 {
                font-size: 30px;
                margin-bottom: 30px;
            }
            input[type="text"],
            textarea,
            select {
                padding: 12px;
                font-size: 15px;
            }
            input[type="submit"] {
                padding: 14px;
                font-size: 16px;
                margin-top: 25px;
            }
            .back-btn {
                padding: 8px 15px;
                font-size: 15px;
                margin-bottom: 20px;
            }
            .message {
                font-size: 15px;
                padding: 10px;
                margin-top: 20px;
            }
        }

        @media (max-width: 480px) {
            .form-container {
                padding: 25px 20px;
            }
            h2 {
                font-size: 26px;
                margin-bottom: 25px;
            }
            input[type="text"],
            textarea,
            select {
                margin: 10px 0;
            }
        }
        @keyframes slideFadeIn {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>

    <div class="form-container">
        <a href="recruiter_dashboard.php" class="back-btn"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
        <h2><i class="fas fa-bullhorn"></i> Post a New Job</h2>

        <?php if (!$has_companies): ?>
            <p class="no-companies-msg">
                <i class="fas fa-exclamation-circle"></i> You need to add your company details first before posting a job.
                <br>
                <a href="add_company.php">Add Company Now</a>
            </p>
        <?php else: ?>
            <form method="POST">
                <select name="company_id" required>
                    <option value="">-- Select Company --</option>
                    <?php
                    mysqli_data_seek($company_result, 0); 
                    while ($row = mysqli_fetch_assoc($company_result)) : ?>
                        <option value="<?= htmlspecialchars($row['company_id']) ?>"><?= htmlspecialchars($row['company_name']) ?></option>
                    <?php endwhile; ?>
                </select>

                <input type="text" name="title" placeholder="Job Title" required>
                <textarea name="description" placeholder="Job Description" required></textarea>
                <input type="text" name="location" placeholder="Location" required>
                <input type="text" name="category" placeholder="Category (e.g., IT, Marketing, Sales)" required>
                <input type="text" name="salary" placeholder="Salary Range (e.g. ₹25,000 - ₹50,000)" required>
                <input type="submit" value="Post Job">
            </form>
        <?php endif; ?>

        <?php if ($msg): ?>
            <div class="message <?= $msg_class ?>">
                <?php
                if ($msg_class === 'success-msg') {
                    echo '<i class="fas fa-check-circle"></i> ';
                } else if ($msg_class === 'error-msg') {
                    echo '<i class="fas fa-times-circle"></i> ';
                } else {
                    echo '<i class="fas fa-info-circle"></i> ';
                }
                echo htmlspecialchars(str_replace(['✅ ', '❌ '], '', $msg));
                ?>
            </div>
        <?php endif; ?>

    </div>

</body>
</html>