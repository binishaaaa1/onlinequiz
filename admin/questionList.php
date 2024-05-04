<?php

session_start();
if(!isset($_SESSION['adminid'])){
    header('location:index.php');
}

$adminid=$_SESSION['adminid'];
include '..//connection.php';

$query = "SELECT * FROM quiz_topics";
$result = mysqli_query($con, $query);

// Check if the query execution was successful
if ($result) {
    $topics = mysqli_fetch_all($result, MYSQLI_ASSOC);
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Question List</title>
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
    

<div class="card question-list">
    <h2>Question List</h2>
    <form action="" method="get">
        <label for="topic">Filter by Quiz Topic:</label>
        <select name="topic_id" id="topic" onchange="this.form.submit()">
        <option value="all">All Topics</option>
            <?php
            foreach ($topics as $topic) {
                $topicID = $topic['topic_id'];
                $topicName = $topic['topic_name'];
                $selected = ($topicID == $_GET['topic_id']) ? 'selected' : '';
                echo "<option value='$topicID' $selected>$topicName</option>";
            }
            ?>
        </select>
    </form>
    <table>
        <tr>
            <th>sn</th>
            <th>Question</th>
            <th>Options</th>
            <th>Answer</th>
            <th>Action</th>
        </tr>
        <?php
   if (isset($_GET['topic_id'])) {
    $topicID = $_GET['topic_id'];
    if ($topicID == "all") {
        $query = "SELECT * FROM questions";
    } else {
        $query = "SELECT * FROM questions WHERE topic_id = '$topicID'";
    }
} else {
    $query = "SELECT * FROM questions";
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
                    <td><?php echo $count ?></td>
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
</body>
</html>
