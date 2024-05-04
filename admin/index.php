<?php
session_start();

include '..//connection.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['submit'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Server-side validation
        if (empty($email) || empty($password)) {
            echo "<script>alert('Please enter both email and password.');</script>";
        } else {
            $email = mysqli_real_escape_string($con, $email);
            $password = mysqli_real_escape_string($con, $password);

            $result = mysqli_query($con, "SELECT * FROM admin WHERE email = '$email'") or die('Error');
            
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                if (password_verify($password, $row['password'])) {
                    $_SESSION["adminid"] = $row["id"];
                    header('Location: adminDashboard.php');
                    exit();
                } else {
                    echo "<script>alert('Wrong email or password.');</script>";
                }
            } else {
                echo "<script>alert('Wrong email or password.');</script>";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>admin login</title>
    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById("password");
            var toggleIcon = document.getElementById("toggle-icon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleIcon.className = "fas fa-eye-slash";
            } else {
                passwordInput.type = "password";
                toggleIcon.className = "fas fa-eye";
            }
        }
    </script>
    <style>
   * {
    padding: 0;
    margin: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    background-image: url('background.jpg');
    background-color: #F5F7FA;
    color: #333;
}

.main-nav {
    background-color: #333;
    padding: 10px;
}

.main-nav ul {
    display: flex;
    justify-content: space-between;
    align-items: center;
    list-style: none;
}

.main-nav ul li {
    margin: 0 10px;
}

.main-nav ul li a {
    color: #fff;
    text-decoration: none;
    font-weight: bold;
    font-size: 16px;
    transition: color 0.3s ease;
}

.main-nav ul li a:hover {
    color: #C21E56;
}

.container {
    max-width: 400px;
    margin: 50px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 14px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.container h1 {
    text-align: center;
    margin-bottom: 30px;
    color: #C21E56;
}

.container hr {
    border: none;
    height: 1px;
    background-color: #ddd;
    margin-bottom: 30px;
}

.container form label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
}

.container form input[type="text"],
.container form input[type="password"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    margin-bottom: 20px;
    font-size: 14px;
}

.container form .password-toggle {
    position: relative;
}

.container form .password-toggle i {
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    cursor: pointer;
    color: #999;
}

.container form .password-toggle i:hover {
    color: #333;
}

.container form input[type="submit"] {
    background-color: #C21E56;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    font-size: 14px;
}

.container form input[type="submit"]:hover {
    background-color: #45a049;
}

.container form p {
    margin-top: 20px;
    text-align: center;
    font-size: 14px;
    color: #666;
}

.container form p a {
    color: #C21E56;
    text-decoration: none;
}

.container form p a:hover {
    text-decoration: underline;
}

    </style>
</head>
<body>

<div class="container">
        <form action="" method="post" name="loginForm" onsubmit="return validateForm()">
            <h1>Admin Login</h1>
            <hr>
            <div>
                <label for="email">email:</label>
                <input type="text" name="email" id="email" required>
            </div>
            <div class="password-toggle">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
                <i id="toggle-icon" class="fas fa-eye" onclick="togglePasswordVisibility()"></i>
            </div>
            <input type="submit" value="Login" name="submit">
   
        </form>
    </div>
    
</body>
</html>
