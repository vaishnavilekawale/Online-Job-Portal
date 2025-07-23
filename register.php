<?php
session_start();
include "config.php";

$name = $email = $password = $role = "";
$msg = $error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = mysqli_real_escape_string($conn, $_POST['name']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role     = $_POST['role'];

    $check = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
    if (mysqli_num_rows($check) > 0) {
        $error = "This email is already registered. Try logging in.";
    } else {
        $sql = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')";
        if (mysqli_query($conn, $sql)) {
            $msg = "Registered successfully. You can now <a href='login.php'>login</a>.";
        } else {
            $error = "Registration failed. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Register - Job Portal</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <style>
    * {
      box-sizing: border-box;
      
    }

    body {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', sans-serif;
      background: url('../job-portal-website/images/register.avif') no-repeat center center fixed;
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

    .form-box {
      background: rgba(0, 0, 0, 0.75);
      backdrop-filter: blur(12px);
      border-radius: 18px;
      padding: 45px;
      width: 100%;
      max-width: 450px;
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
      color: #fff;
      text-shadow: 2px 2px 6px #000;
      letter-spacing: 1px;
    }

    input, select {
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

    input:focus, select:focus {
      outline: none;
      background-color: black;
      border-color: #00BFFF;
      box-shadow: 0 0 0 3px rgba(0, 191, 255, 0.3);
    }

    select {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http://www.w3.org/2000/svg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23eeeeee%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13.2-6.4H18.6c-5%200-9.3%201.8-13.2%206.4-3.9%204.5-6%2010-6%2016v144c0%206%202.1%2011.5%206%2016%203.9%204.5%208.7%206.4%2013.2%206.4h255.2c5%200%209.3-1.8%2013.2-6.4%203.9-4.5%206-10%206-16V85.4c0-6-2.1-11.5-6-16z%22/%3E%3C/svg%3E');
        background-repeat: no-repeat;
        background-position: right 10px center;
        background-size: 10px;
        padding-right: 30px;
    }

    .btn {
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
    }

    .btn:hover {
      background-color: #008DCC;
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(0, 191, 255, 0.6);
    }

    .back-link {
      position: absolute;
      top: 30px;
      left: 30px;
      color: #fff;
      text-decoration: none;
      font-weight: bold;
      background-color: rgba(0, 0, 0, 0.5);
      padding: 10px 18px;
      border-radius: 8px;
      transition: 0.3s ease, transform 0.2s ease;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
      display: inline-flex;
      align-items: center;
      gap: 8px;
      z-index: 2;
    }

    .back-link:hover {
      background-color: rgba(0, 0, 0, 0.7);
      transform: translateY(-2px);
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.4);
    }

    .msg {
      color: #d4edda;
      text-align: center;
      margin-top: 20px;
      font-weight: bold;
      font-size: 16px;
      background-color: rgba(40, 167, 69, 0.2);
      padding: 10px;
      border-radius: 8px;
      border: 1px solid rgba(40, 167, 69, 0.4);
    }

    .error {
      color: #ff6b6b;
      text-align: center;
      margin-top: 20px;
      font-weight: bold;
      font-size: 16px;
      background-color: rgba(220, 53, 69, 0.2);
      padding: 10px;
      border-radius: 8px;
      border: 1px solid rgba(220, 53, 69, 0.4);
    }

    @media (max-width: 480px) {
      .form-box {
        margin: 20px;
        padding: 30px 25px;
      }

      h2 {
        font-size: 28px;
      }

      input, select, .btn {
        padding: 12px;
        font-size: 15px;
      }

      .back-link {
        padding: 8px 14px;
        font-size: 14px;
        top: 20px;
        left: 20px;
      }
    }
  </style>
</head>
<body>

  <a class="back-link" href="index.html"><i class="fas fa-arrow-left"></i> Back to Home</a>

  <div class="form-box">
    <h2>Register</h2>

    <form method="POST" action="">
      <input type="text" name="name" placeholder="Full Name" required>
      <input type="email" name="email" placeholder="Email Address" required>
      <input type="password" name="password" placeholder="Password" required>

      <select name="role" required>
        <option value="">-- Select Role --</option>
        <option value="applicant">Applicant</option>
        <option value="recruiter">Recruiter</option>
      </select>

      <input type="submit" value="Register" class="btn">
    </form>

    <?php if ($msg): ?><p class="msg"><?php echo $msg; ?></p><?php endif; ?>
    <?php if ($error): ?><p class="error"><?php echo $error; ?></p><?php endif; ?>
  </div>

</body>
</html>