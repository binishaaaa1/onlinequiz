<?php

session_start();
if (!isset($_SESSION["username"])) {
  header("Location: userLogin.php");
  exit;
}
$userID = $_SESSION['userid'];

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
    $_SESSION['daily_score'] = $dailyScore; 
  } else {
    $_SESSION['daily_score'] = 0; 
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
    /* Reset default margins and paddings */

    body {
      font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('dash.png');
            /* Replace with your image path */
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center center;
            /* Center the background image */
            color: #000;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            overflow: hidden;
    }

    /* Navbar */

    .navbar {
      position: fixed;
  top: 0;
  left: 0;
  width: 99%;
  background-color: #333;
  color: #fff;
  padding: 10px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  z-index: 999; /* Ensure it's above other elements */
 
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
      margin-left: auto;
      /* This pushes the content to the right side */
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
            background-color: chocolate;
            color: black;
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
      background-color: rgba(44, 130, 201);
      width: 200px;
    }

    .profile-icon:hover .profile-info {
      display: block;
    }


    /* Container */
    .container {
      max-width: 800px;
      padding: 20px;
      text-align: center;
      margin-top: 60px;
      /* Adjust this value to create the desired spacing */
      background-color: #c1c1ff;
      background-color: rgba(193, 193, 255, 0.5);
      box-shadow: 10px 19px 8px 13px rgba(0, 0, 0, 0.3);

    }

    .category-list {
      list-style: none;
      padding: 0;
      margin: 0;
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
    }

    .category-card {
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      margin: 15px;
      padding: 20px;
      width: 250px;
      transition: transform 0.2s, box-shadow 0.2s;
    }

    .category-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    .category-link {
      display: block;
      text-decoration: none;
      font-size: 18px;
      font-weight: bold;
      color: #333;
    }

    .category-link:hover {
      color: #007bff;
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
      transform: translateY(-2px);
      /* Add a subtle lift effect */
    }
  </style>
</head>
</style>
</head>

<body>
<div class="navbar">
        <h1>Quizze</h1>
        <ul>
            <li><a href="homepage.php">Home</a></li>
            <li><a href="category.php">category</a></li>
            <li><a href="leaderboard.php">Scoreboard</a></li>

            <li class="profile-icon">
                <span>&#128100;</span>
                <div class="profile-info">
                    <p><?php echo "Hello, " . $_SESSION['username']; ?></p>
                    <p>Daily Score: <?php echo $_SESSION['daily_score']; ?></p>
                    <p><a href="userDashboard.php">setting</a></p>
                    <div class="logout-container">
                        <a href="logout.php">Logout</a>
                    </div>
                </div>
            </li>
        </ul>
    </div>


  <div class="container">
    <div class="header">
      <h1 class="title">Category</h1>

    </div>
    <ul class="category-list">
      <?php foreach ($categories as $category) : ?>
        <li class="category-card">
          <a href="topicSelection.php?category_id=<?php echo $category['category_id']; ?>" class="category-link"><?php echo $category['category_name']; ?></a>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const settingsIcon = document.querySelector(".settings-icon");
      const profileInfo = document.querySelector(".profile-info");

      settingsIcon.addEventListener("click", function() {
        profileInfo.classList.toggle("show");
      });
    });
  </script>
</body>

</html>