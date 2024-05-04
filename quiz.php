<?php
session_start();
include 'connection.php';

if (isset($_SESSION['daily_score'])) {
    $_SESSION['daily_score'] = '';  // Assign an empty value
}
if (isset($_GET['topic_id'])) {
    $topicID = $_GET['topic_id'];

    // Fetch the topic name from the database
    $query = "SELECT topic_name FROM quiz_topics WHERE topic_id = '$topicID'";
    $result = mysqli_query($con, $query);

    if ($result) {
        $topic = mysqli_fetch_assoc($result);
        $topicName = $topic['topic_name'];
    } else {
        echo "Error: " . mysqli_error($con);
    }
    $randomSeed = time();
    $query = "SELECT * FROM questions WHERE topic_id = '$topicID' ORDER BY RAND($randomSeed) LIMIT 10";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $questions = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        echo "No questions found for the selected topic.";
    }
} else {
    echo "No topic selected.";
}
$deleteQuery = "DELETE FROM user_responses WHERE user_id = {$_SESSION['userid']}";
$deleteResult = mysqli_query($con, $deleteQuery);

if (!$deleteResult) {
    echo "Error deleting user responses: " . mysqli_error($con);
}

mysqli_close($con);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Quiz System - Quiz</title>
    <style>
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.container {
    max-width: auto;
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

.question {
    margin-bottom: 20px;
    background-color: #f2f2f2;
    padding: 20px;
    border-radius: 5px;
}

.question-text {
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 10px;
}

.options {
    margin-bottom: 10px;
    background-color: #ffffff;
    padding: 10px;
    border-radius: 5px;
}

.option {
    margin-bottom: 10px;
}

.option-label {
    display: inline-block;
    font-weight: bold;
    margin-right: 10px;
}

.submit-btn {
    display: block;
    margin-top: 1px;
    padding: 10px 6px;
    background-color: #0d61bb;
    color: #fff;
    font-size: 20px;
    font-weight: bold;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s;
}

.submit-btn:hover {
    background-color: #0056b3;
}

#countdown {
    color: red;
    text-align: top;
    font-size: 20px;
    font-weight: bold;
    margin-bottom: 20px;
}
.navigation-btns {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 20px;
    position: fixed; /* Add this line to make the buttons fixed */
    bottom: 20px; /* Adjust the desired bottom spacing */
    width: 10%; /* Add this line to make the buttons span the full width */
    padding: 0 20px; /* Add horizontal padding if needed */
    box-sizing: border-box; /* Include padding in the width calculation */
}
.navigation-btns {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 20px;
    position: fixed;
    bottom: 20px;
    left: 50%; /* Add this line to horizontally center the buttons */
    transform: translateX(-50%); /* Add this line to adjust the horizontal position */
    width: 30%; /* Adjust the desired width */
    padding: 0 20px;
    box-sizing: border-box;
    z-index: 999; /* Add this line to ensure the buttons are on top of other elements */
}

.navigation-btn {
    display: inline-block;
    padding: 10px 10px;
    background-color: #f2f2f2;
    color: #333;
    font-size: 16px;
    font-weight: bold;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s;
    margin: 1px;
}

.navigation-btn:hover {
    background-color: #ddd;
}
#countdown {
  font-size: 30px;
  font-weight: bold;
  color: #ffffff;
  background-color: #333333;
  padding: 10px 20px;
  border-radius: 5px;
  display: inline-block;
  margin-bottom: 20px;
}
#home{
    text-decoration: none;
    color: black;
    background: #fff;
    padding: 15px;
    position: absolute;
    top:37%;
}

    </style>
    <script>
 
        var minutes = 10;
        var seconds = 00;

        function startTimer() {
            var countdownElement = document.getElementById("countdown");

            function updateTimer() {
                var minutesDisplay = minutes < 10 ? "0" + minutes : minutes;
                var secondsDisplay = seconds < 10 ? "0" + seconds : seconds;
                countdownElement.innerHTML = minutesDisplay + ":" + secondsDisplay;

                if (minutes === 0 && seconds === 0) {
                    clearInterval(timerInterval);
                    document.getElementById("quizForm").submit(); // Automatically submit the quiz when the time is up
                } else if (seconds === 0) {
                    minutes--;
                    seconds = 59;
                } else {
                    seconds--;
                }
            }

            updateTimer();
            var timerInterval = setInterval(updateTimer, 1000);
        }

        window.addEventListener("load", startTimer);


        var currentQuestionIndex = 0;
        var questionsCount = <?php echo count($questions); ?>;

        function showQuestion() {
    var questionsContainer = document.getElementById("questionsContainer");
    var question = document.getElementsByClassName("question");
    for (var i = 0; i < question.length; i++) {
        question[i].style.display = "none";
    }
    question[currentQuestionIndex].style.display = "block";
    

    var prevBtn = document.getElementById("prevBtn");
    prevBtn.style.display = currentQuestionIndex === 0 ? "none" : "inline-block";
    
    adjustButtonPosition();
}
        function adjustButtonPosition() {
    var navigationBtns = document.getElementById("navigationBtns");
    var questionsContainer = document.getElementById("questionsContainer");
    var containerHeight = questionsContainer.offsetHeight + navigationBtns.offsetHeight;
    document.body.style.minHeight = containerHeight + "px";
}

        function navigateToNextQuestion() {
  currentQuestionIndex++;
  if (currentQuestionIndex >= questionsCount) {
    currentQuestionIndex = questionsCount - 1;
    document.getElementById("nextBtn").style.backgroundColor = "red"; // Change the color of the button to red
        document.getElementById("nextBtn").innerText = "✗"; // Display a cross symbol
   
  }
  showQuestion();
  return false; // Prevent form submission
}

function navigateToPreviousQuestion() {
    if (currentQuestionIndex === questionsCount - 1) {
        document.getElementById("nextBtn").style.backgroundColor = "#f2f2f2"; // Revert the background color of the button
        document.getElementById("nextBtn").innerText = "Next"; // Revert the text of the button
    }
    currentQuestionIndex--;
    if (currentQuestionIndex < 0) {
        currentQuestionIndex = 0;
    }
    showQuestion();
    return false; // Prevent form submission
}
        // Show the first question on page load
        window.addEventListener("load", function() {
    showQuestion();
    adjustButtonPosition(); // Call the function to adjust button position
});
    </script>
</head>
<body>
    <div class="container">
    <a href="userDashboard.php" id="home">Home</a>
    <div class="header">
        <div id="countdown"></div>
        <h1 class="title">
            <?php echo $topicName; ?> Quiz
        </h1>
    </div>
    <form action="submit_quiz.php" id="quizForm" method="post">
        <div id="questionsContainer">
            <?php if (isset($questions) && count($questions) > 0): ?>
                <?php foreach ($questions as $index => $question): ?>
                    <div class="question" style="<?php echo $index > 0 ? 'display: none;' : ''; ?>">
                        <p class="question-text">
                        <?php echo ($index + 1) . '. ' . $question['question']; ?>
                        </p>
                        <ul class="options">
                            <li class="option">
                                <label class="option-label">
                                    <input type="radio" name="answer[<?php echo $question['question_id']; ?>]"
                                           value="<?php echo $question['option1']; ?>">
                                    <?php echo $question['option1']; ?>
                                </label>
                            </li>
                            <li class="option">
                                <label class="option-label">
                                    <input type="radio" name="answer[<?php echo $question['question_id']; ?>]"
                                           value="<?php echo $question['option2']; ?>">
                                    <?php echo $question['option2']; ?>
                                </label>
                            </li>
                            <li class="option">
                                <label class="option-label">
                                    <input type="radio" name="answer[<?php echo $question['question_id']; ?>]"
                                           value="<?php echo $question['option3']; ?>">
                                    <?php echo $question['option3']; ?>
                                </label>
                            </li>
                            <li class="option">
                                <label class="option-label">
                                    <input type="radio" name="answer[<?php echo $question['question_id']; ?>]"
                                           value="<?php echo $question['option4']; ?>">
                                    <?php echo $question['option4']; ?>
                                </label>
                            </li>
                        </ul>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div class="navigation-btns">
                <input type="hidden" name="topic_id" value="<?php echo $topicID; ?>">
                <button id="prevBtn" class="navigation-btn" onclick="navigateToPreviousQuestion()" type="button">Previous</button>
                <button id="nextBtn" class="navigation-btn" onclick="navigateToNextQuestion()" type="button">Next</button>
                <input type="submit" value="Submit" name="submit" class="submit-btn">
            </div>
    </form>
</div>
</body>
</html>
