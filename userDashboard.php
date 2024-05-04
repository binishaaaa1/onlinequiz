<?php

session_start();
if (!isset($_SESSION["username"])) {
  header("Location: userLogin.php");
  exit;
}
$userID=$_SESSION['userid'];

include 'connection.php';



$query = "SELECT * FROM categories";
$result = mysqli_query($con, $query);


if ($result) {
  $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
  echo "Error: " . mysqli_error($con);
}

$currentDate = date('Y-m-d');
$query = "SELECT score FROM daily_score WHERE user_id = $userID AND date(submission_time) = '$currentDate'";
$result = mysqli_query($con, $query);


if ($result) {
  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $dailyScore = $row['score'];
    $_SESSION['daily_score'] = $dailyScore; // Store the daily score in a session variable
} else {
    $_SESSION['daily_score'] = 0; // If no daily score is found, set it to 0
}
}

mysqli_close($con);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Quiz System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            
            height: 100vh;
            overflow: hidden;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .category-list {
            list-style: none;
            padding: 0;
            margin-bottom: 10px;
            text-align: center;
        
            gap: 20px;
        }

        .category-item {
            margin-bottom:10px;
            align-items: center;
            justify-content: center;
        }

        .category-link {
            display: block;
            padding: 10px 20px;
            background-color: #60009b;
            color: #fff;
            font-size: 18px;
            font-weight: bold;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .category-link:hover {
            background-color: #9909f2;
        }

        .navbar {
            background-color: #9909f2;
            color: #fff;
            padding: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between; /* Add this line to distribute items evenly */
        }

        .navbar h1 {
            font-size: 24px;
            margin: 0;
            padding: 0 20px;
        }
        .navbar ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            margin-left: auto; /* This pushes the content to the right side */
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
            padding: 10px;
            color: black;
        }

        .score-container p {
            margin: 0;
        }

        .logout-container {
        
            display: flex;
  justify-content: center;
        
        }

        .logout-container a {
            /* display: inline-block; */
            padding: 5px 10px;
            background-color: #555;
            color: #fff;
            border-radius: 4px;
          
           
    
        }


        .profile-icon {
            position: relative;
            cursor: pointer;
            font-size: 24px;
        }

        .profile-info {
            display: none;
            position: absolute;
            margin-left: 10px;
            background-color: #fff;
            padding: 10px;
            border-radius: 4px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            top: 100%;
            right: 0;
            color: black;

            width: 200px;
        }

        .profile-icon:hover .profile-info {
            display: block;
        }
    </style>
</head>

<body>
    <div class="navbar">
     <h1>Brainly </h1>
      <ul>
            <li><a href="userDashboard.php">Home</a></li>
            <li><a href="scoreboard.php">Scoreboard</a></li>

            <li class="profile-icon">
                <span>&#128100;</span>
                <div class="profile-info">
                    <p><?php echo "Hello, " . $_SESSION['username']; ?></p>
                    <p>Daily Score: <?php echo $_SESSION['daily_score']; ?></p>
                    <div class="logout-container">
                    <a href="logout.php">Logout</a>
                    </div>
                </div>
            </li>
        </ul>
    </div>

    <div class="container">
        <div class="header">
            <h1 class="title">Welcome to the Online Quiz System</h1>
            <p>Select a category</p>
        </div>
        <ul class="category-list">
            <?php foreach ($categories as $category): ?>
            <li class="category-item">
                <a href="topicSelection.php?category_id=<?php echo $category['category_id']; ?>"
                    class="category-link"><?php echo $category['category_name']; ?></a>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>

</html>