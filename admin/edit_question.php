<?php
include '..//connection.php';
session_start();
if(!isset($_SESSION['adminid'])){
    header('location:index.php');
}


if (isset($_POST['submit'])) {
    $questionID = $_POST['question_id'];
    $topicID = $_POST['topic'];
    $question = $_POST['question'];
    $option1 = $_POST['option1'];
    $option2 = $_POST['option2'];
    $option3 = $_POST['option3'];
    $option4 = $_POST['option4'];
    $correctOption = $_POST['Answer'];

    $query = "UPDATE questions SET topic_id = '$topicID', question = '$question', option1 = '$option1', option2 = '$option2', option3 = '$option3', option4 = '$option4', correct_option = '$correctOption' WHERE question_id = '$questionID'";
    mysqli_query($con, $query);
    header("Location: questions.php");
    exit();
}

if (isset($_GET['id'])) {
    $questionID = $_GET['id'];
    $query = "SELECT * FROM questions WHERE question_id = '$questionID'";
    $result = mysqli_query($con, $query);
    $question = mysqli_fetch_assoc($result);
} else {
    header("Location: questions.php");
    exit();
}

$query = "SELECT * FROM quiz_topics";
$result = mysqli_query($con, $query);

// Check if the query execution was successful
if ($result) {
    $topics = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    echo "Error: " . mysqli_error($con);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Question | Online Quiz System</title>
    <script>
        function updateSelectOption() {
            var opt1Value = document.getElementById('option1').value;
            var opt2Value = document.getElementById('option2').value;
            var opt3Value = document.getElementById('option3').value;
            var opt4Value = document.getElementById('option4').value;
            var selectBox = document.getElementById('Answer');

            // Remove existing options
            selectBox.innerHTML = '';

            // Create new options based on input values
            var option1 = document.createElement('option');
            option1.value = opt1Value;
            option1.textContent = 'Option 1';
            selectBox.appendChild(option1);

            var option2 = document.createElement('option');
            option2.value = opt2Value;
            option2.textContent = 'Option 2';
            selectBox.appendChild(option2);

            var option3 = document.createElement('option');
            option3.value = opt3Value;
            option3.textContent = 'Option 3';
            selectBox.appendChild(option3);

            var option4 = document.createElement('option');
            option4.value = opt4Value;
            option4.textContent = 'Option 4';
            selectBox.appendChild(option4);
        }
    </script>
    <Style>
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}

h2 {
    text-align: center;
    margin-top: 20px;
}

form {
    max-width: 500px;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f9f9f9;
}

label {
    display: block;
    margin-top: 10px;
    font-weight: bold;
}

select,
textarea,
input[type="text"] {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

textarea {
    resize: vertical;
}

button[type="submit"] {
    display: block;
    width: 100%;
    padding: 10px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
}

button[type="submit"]:hover {
    background-color: #0056b3;
}
    </Style>
</head>
<body>
    <h2>Edit Question</h2>
    <form action="" method="post">
        <input type="hidden" name="question_id" value="<?php echo $question['question_id']; ?>">
        <label for="topic">Select Quiz Topic:</label>
        <select name="topic" id="topic">
            <?php
            foreach ($topics as $topic) {
                $topicID = $topic['topic_id'];
                $topicName = $topic['topic_name'];
                $selected = ($topicID == $question['topic_id']) ? 'selected' : '';
                echo "<option value='$topicID' $selected>$topicName</option>";
            }
            ?>
        </select>
        <br>
        <label for="question">Question:</label>
        <textarea name="question" rows="4" required><?php echo $question['question']; ?></textarea>
        <br>
        <label for="option1">Option 1:</label>
        <input type="text" name="option1" id="option1" value="<?php echo $question['option1']; ?>" oninput="updateSelectOption()" required>
        <br>
        <label for="option2">Option 2:</label>
        <input type="text" name="option2" id="option2" value="<?php echo $question['option2']; ?>" oninput="updateSelectOption()" required>
        <br>
        <label for="option3">Option 3:</label>
        <input type="text" name="option3" id="option3" value="<?php echo $question['option3']; ?>" oninput="updateSelectOption()" required>
        <br>
        <label for="option4">Option 4:</label>
        <input type="text" name="option4" id="option4" value="<?php echo $question['option4']; ?>" oninput="updateSelectOption()" required>
        <br>
        <label for="correctOption">Correct Option:</label>
        <select name="Answer" id="Answer">
    <option value="">Select correct answer</option>
    <?php
    $options = array($question['option1'], $question['option2'], $question['option3'], $question['option4']);
    foreach ($options as $index => $option) {
        $selected = ($option == $question['correct_option']) ? 'selected' : '';
        echo "<option value='$option' $selected>Option " . ($index + 1) . "</option>";
    }
    ?>
</select>
        <br>
        <button type="submit" name="submit">Update Question</button>
    </form>
</body>
</html>
