<?php
session_start();
include 'connection.php';
$username=$_SESSION['username'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userID = $_SESSION['userid'];
    $userAnswers = $_POST['answer'];
    $topicID = $_POST['topic_id'];

    $query = "SELECT question_id, correct_option FROM questions WHERE topic_id = '$topicID'";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $correctAnswers = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        echo "No correct answers found for the selected topic.";
        echo "Error: " . mysqli_error($con);
        exit;
    }

    foreach ($userAnswers as $questionID => $selectedOption) {
        $correctOption = '';

        foreach ($correctAnswers as $answer) {
            if ($answer['question_id'] == $questionID) {
                $correctOption = $answer['correct_option'];
                break;
            }
        }

        // If the selected option is empty, set it to null
        $selectedOption = empty($selectedOption) ? null : $selectedOption;

        $query = "INSERT INTO user_responses (user_id, question_id, selected_option, submission_time) VALUES ('$userID', '$questionID', '$selectedOption', NOW())";
        $result = mysqli_query($con, $query);

        if (!$result) {
            echo "Error storing user response: " . mysqli_error($con);
            echo "Query: " . $query;
            exit;
        }
    }
    
    // Update or add the daily score here
    $correctCount = calculateCorrectCount($userAnswers, $correctAnswers);
    $score = $correctCount; // Use the correct count as the score

    $currentDate = date('Y-m-d');

    $query = "SELECT score FROM daily_score WHERE user_id = $userID AND DATE(submission_time) = '$currentDate'";
    $result = mysqli_query($con, $query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            // User has already submitted a score today, update the existing score
            $row = mysqli_fetch_assoc($result);
            $currentScore = $row['score'];
            $newScore = $currentScore + $score;

            $updateQuery = "UPDATE daily_score SET score = $newScore WHERE user_id = $userID AND DATE(submission_time) = '$currentDate'";
            $updateResult = mysqli_query($con, $updateQuery);

            if ($updateResult) {
                echo "Daily score updated successfully for user: $username";
            } else {
                echo "Error updating daily score: " . mysqli_error($con);
            }
        } else {
            // User has not submitted a score today, insert a new row
            $insertQuery = "INSERT INTO daily_score (user_id, score, submission_time) VALUES ($userID, $score, NOW())";
            $insertResult = mysqli_query($con, $insertQuery);

            if ($insertResult) {
                echo "Daily score added successfully for user: $username";
            } else {
                echo "Error adding daily score: " . mysqli_error($con);
            }
        }
    } else {
        echo "Error executing query: " . mysqli_error($con);
    }

    mysqli_close($con);
    header("Location: quiz_result.php?topic_id=$topicID");
    exit;
}

// Function to calculate the correct count
function calculateCorrectCount($userAnswers, $correctAnswers) {
    $correctCount = 0;

    foreach ($userAnswers as $questionID => $selectedOption) {
        foreach ($correctAnswers as $answer) {
            if ($answer['question_id'] == $questionID && $answer['correct_option'] == $selectedOption) {
                $correctCount++;
                break;
            }
        }
    }

    return $correctCount;
}
?>
