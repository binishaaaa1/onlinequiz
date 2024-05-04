<?php

session_start();
if(!isset($_SESSION['adminid'])){
    header('location:index.php');
}

$adminid=$_SESSION['adminid'];
$topicID = $_GET['topic_id'];
include '..//connection.php';

if (isset($_POST['submit'])) {

    $question = $_POST['question'];
    $option1 = $_POST['option1'];
    $option2 = $_POST['option2'];
    $option3 = $_POST['option3'];
    $option4 = $_POST['option4'];
    $correctOption = $_POST['Answer'];

    $query = "INSERT INTO questions (topic_id, question, option1, option2, option3, option4, correct_option,addedBy) 
              VALUES ('$topicID', '$question', '$option1', '$option2', '$option3', '$option4', '$correctOption','$adminid')";
    mysqli_query($con, $query);
    header("Location: ".$_SERVER['PHP_SELF']."?topic_id=".$topicID);
    exit();
}

$query = "SELECT * FROM quiz_topics";
$result = mysqli_query($con, $query);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $topicName = $row['topic_name'];

    }
} else {
    echo "Error executing query: " . mysqli_error($con);
}



$query = "SELECT * FROM categories";
$result = mysqli_query($con, $query);

// Check if the query execution was successful
if ($result) {
    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
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
    <title>Dashboard | Online Quiz System</title>
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

        .question-list {
            margin-top: 20px;
        }

        .question-list select {
            padding: 5px;
        }

        .question-list table {
            margin-top: 10px;
        }

        .question-list th,
        .question-list td {
            padding: 8px;
        }

        .question-list td.options {
            white-space: pre-wrap;
        }

        .question-list td.actions {
            text-align: center;
        }

        .question-list a {
            color: #333;
            text-decoration: none;
            margin-right: 5px;
        }

        .add-question-form textarea,
        .add-question-form input[type="text"],
        .add-question-form select {
            width: 100%;
            padding: 5px;
            margin-bottom: 10px;
        }

        .add-question-form button[type="submit"] {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
    <script>
        function updateSelectOption() {
            var opt1Value = document.getElementById('opt1').value;
            var opt2Value = document.getElementById('opt2').value;
            var opt3Value = document.getElementById('opt3').value;
            var opt4Value = document.getElementById('opt4').value;
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
</head>
<body>
<div class="navbar">
        <ul>
            <li><a href="adminDashboard.php">Home</a></li>
            <li><a href="category.php">Category</a></li>
            <li><a href="leaderboard.php">Leaderboard</a></li>
            <li><a href="users.php">User list</a></li>
            <li><a href="questionList.php">Question</a></li>
        </ul>    
        <div class="logout-container">
    <a href="logout.php">Logout</a>
  </div>
    </div>

<div class="container">
    <div class="card add-question-form">
        <h2>Add Question in <?php echo $topicName; ?></h2>
        <form action="" method="post">
 
           
            </select>
            <br>
            <label for="question">Question:</label>
            <textarea name="question" rows="4" required></textarea>
            <br>
            <label for="option1">Option 1:</label>
            <input type="text" name="option1" id="opt1" oninput="updateSelectOption()" required>
            <br>
            <label for="option2">Option 2:</label>
            <input type="text" name="option2" id="opt2" oninput="updateSelectOption()" required>
            <br>
            <label for="option3">Option 3:</label>
            <input type="text" name="option3" id="opt3" oninput="updateSelectOption()" required>
            <br>
            <label for="option4">Option 4:</label>
            <input type="text" name="option4" id="opt4" oninput="updateSelectOption()" required>
            <br>
            <label for="correctOption">Correct Option:</label>
            <select name="Answer" id="Answer">
                <option value="">Select correct answer</option>
            </select>
            <br>
            <input type="hidden" name="topic_id" value="<?php $topicID?>">
            <button type="submit" name="submit">Add Question</button>
        </form>
    </div>

    <div class="card question-list">
        <h2>Question List</h2>

        <table>
            <tr>
                <th>sn</th>
                <th>Question</th>
                <th>Options</th>
                <th>Answer</th>
                <th>Action</th>
            </tr>
            <?php
  $query = "SELECT * FROM questions";
  if (isset($_GET['topic_id'])) {
      $topicID = $_GET['topic_id'];
      $query .= " WHERE topic_id = '$topicID'";
  }
  $result = mysqli_query($con, $query);
  $count = 1;
  
  if ($result && mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
          $questionID = $row['question_id'];
          $question = $row['question'];
          $option1 = $row['option1'];
          $option2 = $row['option2'];
          $option3 = $row['option3'];
          $option4 = $row['option4'];
          $correctOption = $row['correct_option'];
          ?>
          <tr>
              <td><?php echo $count?></td>
              <td><?php echo $question; ?></td>
              <td>
                  1. <?php echo $option1; ?><br>
                  2. <?php echo $option2; ?><br>
                  3. <?php echo $option3; ?><br>
                  4. <?php echo $option4; ?><br>
              </td>
              <td><?php echo $correctOption; ?></td>
              <td>
                  <a href="edit_question.php?id=<?php echo $questionID; ?>">Edit</a>
                  <a href="delete_question.php?id=<?php echo $questionID; ?>">Delete</a>
              </td>
          </tr>
          <?php
          $count++;
      }
  } else {
      echo "<tr><td colspan='4'>No questions found.</td></tr>";
  }
  
            ?>
        </table>
    </div>
</div>
</body>
</html>

