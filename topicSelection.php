<?php
session_start();
$con = new mysqli('localhost', 'root', '', 'quizdb') or die("Could not connect to MySQL: " . $con->connect_error);


if (isset($_GET['category_id'])) {
    $categoryID = $_GET['category_id'];

    $query = "SELECT * FROM quiz_topics WHERE category_id = '$categoryID'";
    $result = mysqli_query($con, $query);

    if ($result) {
        $topics = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        echo "Error: " . mysqli_error($con);
    }
} else {
    echo "No category selected.";
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
            background-color: #ffffff;
            color: #000000;
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

        .topic-list {
            list-style: none;
            padding: 0;
            margin: 0;
            text-align: center;
        }

        .topic-item {
            margin: 10px;
        }

        .topic-link {
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

        .topic-link:hover {
            background-color: #9909f2;
        }

        .no-topics {
            text-align: center;
            margin-top: 20px;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 999;
            visibility: hidden;
            opacity: 0;
            transition: visibility 0s, opacity 0.5s;
        }

        .message {
            background-color: #000000;
            padding: 20px;
            border-radius: 5px;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
        }

        .show-overlay {
            visibility: visible;
            opacity: 1;
            transition-delay: 3s;
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
            width: 200px;
        }

        .profile-icon:hover .profile-info {
            display: block;
        }
    </style>
</head>

<body>
<div class="navbar">
     <h1>Brainly</h1>
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
            <h1 class="title">Select a Topic</h1>
            <p>Choose a topic from the list below</p>
        </div>
        <?php if (isset($topics) && count($topics) > 0): ?>
            <ul class="topic-list">
                <?php foreach ($topics as $topic): ?>
                    <li class="topic-item">
                        <a href="#" class="topic-link" data-topic-id="<?php echo $topic['topic_id']; ?>"><?php echo $topic['topic_name']; ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="no-topics">No topics found for the selected category.</p>
        <?php endif; ?>
    </div>

    <div class="overlay" id="overlay">
        <div class="message" id="message">
            Be ready to play
        </div>
    </div>

    <script>
        const topicLinks = document.querySelectorAll('.topic-link');
        const overlay = document.getElementById('overlay');
        const message = document.getElementById('message');

        topicLinks.forEach((link) => {
            link.addEventListener('click', showOverlay);
        });

        function showOverlay(e) {
            e.preventDefault(); // Prevent the default link behavior

            const topicId = this.getAttribute('data-topic-id');
            const quizUrl = `quiz.php?topic_id=${topicId}`;

            overlay.classList.add('show-overlay');
            setTimeout(() => {
                window.location.href = quizUrl;
            }, 10); // 3000 milliseconds = 3 seconds
        }
    </script>

</body>

</html>