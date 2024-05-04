
<?php
include "..//connection.php";

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
            
            $checkQuery = "SELECT email FROM admin WHERE email = '$email'";
            $checkResult = mysqli_query($con, $checkQuery);

            if (mysqli_num_rows($checkResult) > 0) {
                echo "<script>alert('Sorry.. This email is already registered.');</script>";
            } else {
                $insertQuery = "INSERT INTO admin (email, password, name) VALUES ('$email', '$hashedPassword', '$userName')";
                if (mysqli_query($con, $insertQuery)) {
                    echo "<script>alert('admin added');
                    window.href=window.href;
                    </script>";
                 
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
    <title>Document</title>
    <link rel="stylesheet" href="css/register.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f1f1f1;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
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
            box-sizing: border-box;
            margin-bottom: 20px;
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
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        p {
            margin-top: 20px;
            text-align: center;
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

            // Other validation logic for email and other fields

            return true; // Proceed with form submission if all validations pass
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
        <h1>REGISTER ADMIN</h1>
        <hr>
        <div>
            <label for="email">Email:</label>
            <input type="text" name="email" id="email"> 
        </div>
        <div>
            <label for="userName">Name:</label>
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
        <input type="submit" name="submit" value="ADD">

    </form>
</body>
</html>

