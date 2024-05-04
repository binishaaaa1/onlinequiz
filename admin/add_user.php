<?php
include '..//connection.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['submit'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $userName = $_POST['userName'];

        // Server-side validation
        if (empty($email) || empty($password) || empty($userName)) {
            echo "<script>alert('All fields are required.');</script>";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<script>alert('Invalid email format.');</script>";
        } elseif (strlen($password) < 6) {
            echo "<script>alert('Password must be at least 6 characters long.');</script>";
        } elseif ($_POST['password'] !== $_POST['rePassword']) {
            echo "<script>alert('Passwords do not match.');</script>";
        } else {
            $email = mysqli_real_escape_string($con, $email);
            $userName = mysqli_real_escape_string($con, $userName);
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hash the password

            $checkQuery = "SELECT email FROM user WHERE email = '$email' OR username = '$userName'";
            $checkResult = mysqli_query($con, $checkQuery);

            if (mysqli_num_rows($checkResult) > 0) {
                echo "<script>alert('Sorry.. This email or username is already registered.');</script>";
            } else {
                $insertQuery = "INSERT INTO user (email, password, userName) VALUES ('$email', '$hashedPassword', '$userName')";
                if (mysqli_query($con, $insertQuery)) {
                    echo "<script>alert('Congrats.. You have successfully registered!');</script>";
                    header('Location: users.php');
                    exit();
                } else {
                    echo "<script>alert('Error: " . mysqli_error($con) . "');
                    windwon
                    </script>";
                }
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
    <title>add user</title>
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #F5F7FA;
            color: #333;
            font-family: Arial, sans-serif;
            background-image: url('background.jpg');
            background-size: cover;
        }

        .main-nav {
            background-color: #333;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
        }

        .main-nav ul {
            display: flex;
            justify-content: space-between;
            font-weight: bold;
            align-items: center;
            list-style: none;
            padding: 10px;
        }

        .main-nav ul li {
            margin: 0 10px;
        }

        .main-nav ul li a {
            color: #fff;
            text-decoration: none;
            font-size: 14px;
            padding: 5px;
            transition: color 0.3s ease;
        }

        .main-nav ul li a:hover {
            color: #C21E56;
        }

        .right {
            margin-left: auto;
        }

        form {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 14px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #C21E56;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .password-toggle {
            position: relative;
        }

        .password-toggle i {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #999;
        }

        .password-toggle i:hover {
            color: #C21E56;
        }

        input[type="submit"] {
            background-color: #C21E56;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-size: 14px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        p {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
        }

        p a {
            color: #C21E56;
            text-decoration: none;
        }

        p a:hover {
            text-decoration: underline;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
    <script>
        function validateForm() {
            var userNameInput = document.register.userName;
            var passwordInput = document.register.password;
            var rePasswordInput = document.register.rePassword;

            if (userNameInput.value === "") {
                alert("Username can't be blank");
                return false;
            } else if (userNameInput.value.length < 3) {
                alert("Username must be at least 3 characters long.");
                return false;
            }

            if (passwordInput.value.length < 6) {
                alert("Password must be at least 6 characters long.");
                return false;
            }

            if (rePasswordInput.value !== passwordInput.value) {
                alert("Passwords do not match.");
                return false;
            }


            return true; 
        }

        function togglePasswordVisibility(inputId) {
            var passwordInput = document.getElementById(inputId);
            var toggleIcon = document.getElementById("toggle-" + inputId);

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleIcon.classList.remove("fa-eye");
                toggleIcon.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "password";
                toggleIcon.classList.remove("fa-eye-slash");
                toggleIcon.classList.add("fa-eye");
            }
        }
    </script>
</head>
<body>
    <form name="register" action="" method="post" onsubmit="return validateForm()">
        <h1>Add User</h1>
        <hr>
        <div>
            <label for="email">Email:</label>
            <input type="text" name="email" id="email">
        </div>
        <div>
            <label for="userName">Username:</label>
            <input type="text" name="userName" id="userName">
        </div>
        <div class="password-toggle">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password">
            <i id="toggle-password" class="fas fa-eye" onclick="togglePasswordVisibility('password')"></i>
        </div>
        <div class="password-toggle">
            <label for="rePassword">Confirm Password:</label>
            <input type="password" name="rePassword" id="rePassword">
            <i id="toggle-repassword" class="fas fa-eye" onclick="togglePasswordVisibility('rePassword')"></i>
        </div>
        <input type="submit" name="submit" value="Add user">
    </form>
</body>
</html>