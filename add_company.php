<?php
session_start();
include 'config.php';

$msg = '';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['company_name'];
    $location = $_POST['location'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $checkQuery = "SELECT * FROM companies WHERE email = '$email'";
    $result = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($result) > 0) {
        $msg = "⚠️ Company with this email already exists!";
    } else {
        $sql = "INSERT INTO companies (user_id, company_name, location, email, password)
                VALUES ('$user_id', '$name', '$location', '$email', '$password')";

        if (mysqli_query($conn, $sql)) {
            $msg = "✅ Company added successfully!";
        } else {
            $msg = "❌ Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Company</title>
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
            background: url('../job-portal-website/images/add_company.jpeg') no-repeat center center fixed;
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
            background: linear-gradient(to right, rgba(15, 32, 39, 0.7), rgba(32, 58, 67, 0.7), rgba(44, 83, 100, 0.7));
            z-index: 0;
        }

        .form-container {
            background: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(12px);
            border-radius: 18px;
            padding: 45px;
            width: 100%;
            max-width: 600px;
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
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }
        h2 .fas {
            font-size: 28px;
            color: #00ffaa;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 14px;
            margin: 15px 0;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            background-color: rgba(255, 255, 255, 0.2);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
        }

        input::placeholder {
            color: #eee;
            opacity: 0.8;
        }

        input:focus {
            outline: none;
            background-color: rgba(255, 255, 255, 0.3);
            border-color: #00BFFF;
            box-shadow: 0 0 0 3px rgba(0, 191, 255, 0.3);
        }

        button {
            width: 100%;
            padding: 14px;
            background-color: #00BFFF;
            border: none;
            border-radius: 10px;
            color: white;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 25px;
            transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 191, 255, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        button:hover {
            background-color: #008DCC;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 191, 255, 0.6);
        }

        .msg {
            text-align: center;
            margin-top: 20px;
            font-weight: 600;
            font-size: 16px;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        }
        .msg .fas {
            font-size: 18px;
        }
        .msg.success {
            color: #d4edda;
            background-color: rgba(40, 167, 69, 0.2);
            border-color: rgba(40, 167, 69, 0.4);
        }
        .msg.error-msg {
            color: #ff6b6b;
            background-color: rgba(220, 53, 69, 0.2);
            border-color: rgba(220, 53, 69, 0.4);
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
            transition: 0.3s ease, transform 0.2s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }

        .back-btn:hover {
            background-color: rgba(0, 0, 0, 0.6);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.4);
        }

        @media (max-width: 600px) {
            .form-container {
                padding: 30px 20px;
            }
            h2 {
                font-size: 28px;
            }
            input, button {
                padding: 12px;
                font-size: 15px;
            }
        }

        @media (max-width: 480px) {
            .form-container {
                padding: 25px 15px;
            }
            h2 {
                font-size: 24px;
            }
            .back-btn {
                padding: 8px 14px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

    <div class="form-container">
        <a href="recruiter_dashboard.php" class="back-btn"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
        <h2><i class="fas fa-building"></i> Add Company Details</h2>
        <form method="POST">
            <input type="text" name="company_name" placeholder="Company Name" required>
            <input type="text" name="location" placeholder="Company Location" required>
            <input type="email" name="email" placeholder="Company Email" required>
            <input type="password" name="password" placeholder="Company Password" required>
            <button type="submit"><i class="fas fa-plus-circle"></i> Add Company</button>
        </form>
        <?php if ($msg): ?>
            <p class="msg <?= (strpos($msg, '✅') !== false) ? 'success' : 'error-msg' ?>"><?= htmlspecialchars($msg) ?></p>
        <?php endif; ?>
    </div>

</body>
</html>