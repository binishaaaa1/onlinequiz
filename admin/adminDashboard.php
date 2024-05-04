<?php
session_start();
include '..//connection.php';
if(!isset($_SESSION['adminid'])){
    header('location:index.php');
}
$query = "SELECT * FROM categories";
$result = mysqli_query($con, $query);
$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
$query2="select * from user";
$result2=mysqli_query($con,$query2);
$user=mysqli_fetch_all($result2,MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard | Online Quiz System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }
        
        .navbar {
    background-color: #333;
    color: #fff;
    padding: 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .navbar ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    display: flex;
    align-items: center;
  }

  .navbar li {
    margin-right: 10px;
  }

  .navbar li:last-child {
    margin-right: 0;
  }

  .navbar li a {
    color: #fff;
    text-decoration: none;
  }

  .navbar li a:hover {
    background-color: #555;
    padding: 5px;
    color: red;
  }
  .logout-container {
    margin-left: 10px;
    
  }

  .logout-container a {
    display: inline-block;
    padding: 8px 16px;

    background-color: #555;
    color: #fff;
    border-radius: 4px;
    transition: background-color 0.3s;
  }

  .logout-container a:hover {
    background-color: #000;
  }
        .card-container {
            display: flex;
            justify-content: space-around;
            align-items: center;
            margin-top: 50px;
        }

        .card {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
            padding: 20px;
            text-align: center;
            width: 200px;
            transition: box-shadow 0.3s ease-in-out;
            cursor: pointer;
        }

        .card:hover {
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }

        .card h2 a {
            margin-bottom: 20px;
        }
        
        .card-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .card-icon {
            font-size: 48px;
            margin-bottom: 10px;
            color: black; /* Update the color here */
        }
        .card-icon:hover{
            color: red;
        }

        .card-number {
            font-size: 24px;
            font-weight: bold;
        }

    </style>
</head>
<body>
    <div class="navbar">
        <ul>
            <li><a href="adminDashboard.php">Home</a></li>
            <li><a href="category.php">Category</a></li>
            <li><a href="leaderboard.php">Scoreboard</a></li>
            <li><a href="users.php">User list</a></li>
            <li><a href="questionList.php">Question</a></li>
        </ul>    
        <div class="logout-container">
    <a href="logout.php">Logout</a>
  </div>
    </div>
    <div class="card-container">
        <div class="card">
            <h2>Total Number of Users</h2>
            <div class="card-content">
                <a href="users.php">
                    <i class="fas fa-user card-icon"></i>
                </a>
                <p class="card-number">
                    <?php  
                    $totalUser = count($user);
                    echo "$totalUser"; 
                    ?>
                </p>
            </div>
        </div>

        <div class="card">
            <h2>Total Number of Categories</h2>
            <div class="card-content">
            <a href="category.php">
                    <i class="fas fa-user card-icon"></i>
                </a>
                <p class="card-number">
                    <?php  
                    $totalCategories = count($categories);
                    echo "$totalCategories"; 
                    ?>
                </p>
            </div>
        </div>
    </div>
</body>
</html>