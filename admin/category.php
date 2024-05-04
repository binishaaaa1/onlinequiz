<?php

session_start();
if(!isset($_SESSION['adminid'])){
    header('location:index.php');
}

 $adminid=$_SESSION['adminid'];
include '..//connection.php';


if (isset($_POST['submit'])) {
    $category = $_POST['category'];


    $query = "INSERT INTO categories (category_name,addedBy) VALUES ('$category',$adminid)";
    mysqli_query($con, $query);
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}


$query = "SELECT * FROM categories";
$result = mysqli_query($con, $query);
$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
<title>category</title>
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
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        .card {
            margin-bottom: 20px;
        }

        .card h2 {
            margin-top: 0;
            margin-bottom: 10px;
            font-size: 24px;
        }

        .card form {
            margin-bottom: 10px;
        }

        .card table {
            width: 100%;
            border-collapse: collapse;
        }

        .card th,
        .card td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        .card th {
            background-color: #f2f2f2;
        }

        .card td:last-child {
            text-align: center;
        }

        .card a {
            color: #333;
            text-decoration: none;
            margin-right: 10px;
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

    <div class="container">
    
        
 
        <div class="card">
            <h2>Add Category</h2>
            <form action="" method="post">
                <input type="text" name="category" placeholder="Enter category name" required>
                <input type="submit" name="submit" value="Add Category">
            </form>
        </div>

        <div class="card">
            <h2>Categories</h2>
            <table>
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Category Name</th>
                        <th colspan="2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count=1;
                    foreach ($categories as $category) {
                        $categoryID = $category['category_id'];
                        $categoryName = $category['category_name'];
                        echo "<tr>";
                        echo "<td>$count</td>";
                        echo "<td>$categoryName</td>";
                        echo "<td><a href='quizTopic.php?category_id=$categoryID'>View Topics</a></td>";
                        echo "<td><a href='deleteCategory.php?id=$categoryID'>Delete</a></td>";
                        echo "</tr>";
                        $count++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
