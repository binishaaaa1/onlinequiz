<?php
session_start();
include 'connection.php';
$topicID = $_GET['topic_id'];
// Retrieve the user's submitted answers
$query = "SELECT u.question_id, u.selected_option, q.correct_option, u.submission_time 
          FROM user_responses u 
          JOIN questions q ON u.question_id = q.question_id
          WHERE u.user_id = {$_SESSION['userid']}
          ORDER BY u.submission_time DESC
          LIMIT 10"; // Change the limit to the number of questions in a quiz

$result = mysqli_query($con, $query);

$userAnswers = array();
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $questionID = $row['question_id'];
        $selectedOption = $row['selected_option'];
        $correctOption = $row['correct_option'];
        $submissionTime = $row['submission_time'];

        $questionQuery = "SELECT question FROM questions WHERE question_id = $questionID";
        $questionResult = mysqli_query($con, $questionQuery);

        if ($questionResult) {
            $questionRow = mysqli_fetch_assoc($questionResult);
            $questionText = $questionRow['question'];

            $userAnswers[] = array(
                'question' => $questionText,
                'selected_option' => $selectedOption,
                'correct_option' => $correctOption,
                'submission_time' => $submissionTime
            );
        } else {
            echo "Error retrieving question text: " . mysqli_error($con);
        }
    }
} else {
    echo "Error retrieving user responses: " . mysqli_error($con);
}

if (empty($userAnswers)) {
    echo "You haven't submitted any answers.";
    exit;
}

$correctCount = 0;
$wrongCount = 0;

foreach ($userAnswers as $answer) {
    if ($answer['selected_option'] === $answer['correct_option']) {
        $correctCount++;
    } else {
        $wrongCount++;
    }
}


$userID = $_SESSION["userid"];
$username = $_SESSION["username"];
$score = $correctCount; 


$query = "SELECT username, score FROM leaderboard WHERE user_id = $userID";
$result = mysqli_query($con, $query);

if ($result) {
    if (mysqli_num_rows($result) > 0) {
   
        $row = mysqli_fetch_assoc($result);
        $username = $row['username'];
        $currentScore = $row['score'];
        $newScore = $currentScore + $score;

        $updateQuery = "UPDATE leaderboard SET score = $newScore, submission_time = NOW() WHERE user_id = $userID";
        $updateResult = mysqli_query($con, $updateQuery);

        if ($updateResult) {
            echo "<script>console.log('Update successful');</script>";
        } else {
            echo "Error updating score: " . mysqli_error($con);
        }
    } else {
        // User does not exist in the leaderboard, insert a new row
        $insertQuery = "INSERT INTO leaderboard (user_id, username, score, submission_time) VALUES ($userID, '$username', $score, NOW())";
        $insertResult = mysqli_query($con, $insertQuery);

        if ($insertResult) {
            echo "Score added successfully for user: $username";
        } else {
            echo "Error adding score: " . mysqli_error($con);
        }
    }
} else {
    echo "Error executing query: " . mysqli_error($con);
}

$currentDate = date('Y-m-d');
$query = "SELECT score FROM daily_score WHERE user_id = $userID AND DATE(submission_time) = '$currentDate'";
$result = mysqli_query($con, $query);

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $dailyScore = $row['score'];
        $_SESSION['daily_score'] = $dailyScore; 
    } else {
        $_SESSION['daily_score'] = 0; 
    }
} else {
    echo "Error retrieving daily score: " . mysqli_error($con);
}

mysqli_close($con);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
            color: #000000;
        }

        h1 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        td.incorrect {
            color: red;
  }

        th {
            background-color: #f2f2f2;
        }
        .center {
       display: flex;
      justify-content: center;
      margin-top: 20px;
        }

        .navbar {
            background-color: #333;
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
    display: inline-block;
    padding: 8px 16px;
    text-decoration: none;
    
    background-color: #555;
    color: #fff;
    border-radius: 4px;
    transition: background-color 0.3s;
}

.logout-container a:hover {

    background-color: wheat;
  }
  .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
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
    </style>
</head>

<body>
<div class="navbar">
     <h1>Brainly</h1>
      <ul>
            <li><a href="userDashboard.php">Home</a></li>
            <li><a href="leaderboard.php">Scoreboard</a></li>

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
    <h1>Quiz Results</h1>


    <h2>Score: <?php echo $correctCount; ?>/<?php echo count($userAnswers); ?></h2>
    <div class="container">
        <?php if (!empty($userAnswers)) {
        
            $previousSubmissionTime = null;
         
        
        ?>
                <table>
                    <tr>
                        <th>Question</th>
                        <th>Your Answer</th>
                        <th>Correct Answer</th>
                    </tr>
                    <?php foreach ($userAnswers as $answer) {
                        $question = $answer['question'];
                        $selectedOption = $answer['selected_option'];
                        $correctOption = $answer['correct_option'];
                        echo "<tr>";
                        echo "<td>" . $question . "</td>";
        
                        if ($selectedOption == $correctOption) {
        
                            echo "<td style='color: green'>" . $selectedOption . "</td>";
                        } else {
        
                            echo "<td class='incorrect'>" . $selectedOption . "</td>";
                        }
                        echo "<td style='color: green'>" . $correctOption . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </table>
                <div class='center'>
                    <form action="quiz.php" method="get">
                        <input type="hidden" name="topic_id" value="<?php echo $topicID; ?>">
                        <button type="submit">Try again</button>
                    </form>
                </div>
        <?php }else {
            echo "You haven't submitted any answers.";
        } ?>
    </div>
</body>

</html>
