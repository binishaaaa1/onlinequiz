<?php
session_start();
include 'connection.php';
if (!isset($_SESSION["username"])) {
    header("Location: userLogin.php");
    exit;
  }
  $userID = $_SESSION['userid'];
  


$query = "SELECT * FROM quiz_topics";
$result = mysqli_query($con, $query);

if ($result) {
    $topics = mysqli_fetch_all($result, MYSQLI_ASSOC);
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
    <title>Online Quiz System - Topics</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('topic.png');
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

        .navbar {
            background-color: rgba(0, 0, 0, 0.5);
      
            color: white;
            padding: 10px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar h1 {
            font-size: 24px;
            margin: 0;
        }

        .container {
            max-width: 800px;
            padding: 40px 40px;
            text-align: center;
            background-color: rgba(193, 193, 255, 0.8);
            /* Transparent background color */
            box-shadow: 10px 19px 8px 13px rgba(0, 0, 0, 0.3);
            margin-top: 60px;
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

        .topic-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .topic-card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin: 15px;
            padding: 20px;
            width: 250px;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .topic-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .topic-link {
            display: block;
            text-decoration: none;
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }

        .topic-link:hover {
            color: #007bff;
        }

        .no-topics {
            text-align: center;
            margin-top: 20px;
        }

        .navbar {
            background-color: #333;
            color: #fff;
            padding: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            /* Add this line to distribute items evenly */
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

        .score-container p {
            margin: 0;
        }

        .logout-container {
            display: flex;
            justify-content: center;

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

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            /* Semi-transparent black overlay */
            display: none;
            /* Hide overlay by default */
            justify-content: center;
            align-items: center;
            z-index: 9999;
            /* Ensure the overlay is above other content */
        }

        /* Show overlay by adding this class */
        .show-overlay {
            display: flex;
        }

        /* Message styles */
        .message {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            font-size: 18px;
            color: #333;
        }
    </style>
</head>

<body>
    <div class="navbar">
        <h1>Quizze</h1>
        <ul>
            <li><a href="homepage.php">Home</a></li>
            <li><a href="leaderboard.php">Scoreboard</a></li>
            <li><a href="category.php">category</a></li>

            <li class="profile-icon">
                <span>&#128100;</span>
                <div class="profile-info">
                    <p><?php echo "Hello, " . $_SESSION['username']; ?></p>
                    <p>Daily Score: <?php echo $_SESSION['daily_score']; ?></p>
                    <p><a href="userDashboard.php">userDetails</a></p>
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
            <p>Choose to play</p>

        </div>
        <?php if (isset($topics) && count($topics) > 0) : ?>
            <ul class="topic-list">
                <?php foreach ($topics as $topic) : ?>
                    <li class="topic-card">
                        <a href="#" class="topic-link"  data-topic-id="<?php echo $topic['topic_id']; ?>"><?php echo $topic['topic_name']; ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else : ?>
            <p class="no-topics">No topics found for the selected category.</p>
        <?php endif; ?>
    </div>

    <div class="overlay" id="overlay">
        <div class="message" id="message">
        </div>


        <script>
            const topicLinks = document.querySelectorAll('.topic-link');
            const overlay = document.getElementById('overlay');
            const message = document.getElementById('message');
            const rules = "Here are the rules for the quiz:<br>1. At least 1 question must be attempted.<br>2. You have 10 minutes to solve the quiz.<br>3. ..."; // Replace with your quiz rules

            topicLinks.forEach((link) => {
                link.addEventListener('click', showRulesAndRedirect);
            });

            function showRulesAndRedirect(e) {
                e.preventDefault(); // Prevent the default link behavior

                // Display rules in the message element
                message.innerHTML = rules;

                overlay.classList.add('show-overlay');

                setTimeout(() => {
                    overlay.classList.remove('show-overlay'); // Hide overlay after 3 seconds
                    const topicId = this.getAttribute('data-topic-id');
                    const quizUrl = `quiz.php?topic_id=${topicId}`;
                    window.location.href = quizUrl;
                }, 4000); // 3000 milliseconds = 3 seconds
            }
        </script>
</body>

</html>