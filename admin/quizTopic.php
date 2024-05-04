<?php
session_start();
if (!isset($_SESSION['adminid'])) {
    header('location:index.php');
}

$adminid = $_SESSION['adminid'];
include '..//connection.php';

$categoryID = $_GET['category_id'];

if (isset($_POST['submit'])) {
    $categoryID = $_POST['category'];
    $topic = $_POST['topic'];

    $query = "INSERT INTO quiz_topics (category_id, topic_name, addedBy) VALUES ('$categoryID', '$topic','$adminid')";
    mysqli_query($con, $query);
    header("Location: " . $_SERVER['PHP_SELF'] . "?category_id=$categoryID");
    exit();
}

$categoryID = isset($_POST['category']) ? $_POST['category'] : $categoryID;

$query = "SELECT categories.category_id, categories.category_name, GROUP_CONCAT(quiz_topics.topic_name ORDER BY quiz_topics.topic_name SEPARATOR ', ') AS topics
          FROM categories
          LEFT JOIN quiz_topics ON categories.category_id = quiz_topics.category_id";

if (!empty($categoryID)) {
    $query .= " WHERE categories.category_id = '$categoryID'";
}

$query .= " GROUP BY categories.category_id";

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
        /* CSS styles */
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
            background-color: #fff;
            padding: 20px;
        }

        .card {
            margin-bottom: 20px;
        }

        .card h2 {
            margin-top: 0;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
        }

        input[type="submit"] {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .actions a {
            margin-right: 5px;
            color: blue;
        }

        .actions a:hover {
            color: red;
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
    </div>
    <div class="container">
    <div class="card">
    <h2>Add Topics in <?php echo !empty($categories) ? $categories[0]['category_name'] : ''; ?></h2>
    <form action="" method="post">
        <label for="topic">Enter Quiz Topic:</label>
        <input type="text" name="topic" placeholder="Enter quiz topic" required>
        <input type="hidden" name="category" value="<?php echo $categoryID; ?>">
        <input type="submit" name="submit" value="Add Topic">
    </form>
</div>

<div class="card">
    <h2>Topics</h2>
    <?php if (!empty($categories)) : ?>
        <table>
            <thead>
                <tr>
                    <th>Number</th>
                    <th>Quiz Topic</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $count = 1;
                foreach ($categories as $category) {
                    $topics = $category['topics'];

                    // Check if there are topics available
                    if (!empty($topics)) {
                        // Split the topics into an array
                        $topicArray = explode(', ', $topics);

                        foreach ($topicArray as $topic) {
                            $topicID = ""; // Initialize the topic_id variable

                            // Retrieve the topic_id from the query result
                            $topicQuery = "SELECT topic_id FROM quiz_topics WHERE topic_name = '$topic' AND category_id = '$categoryID'";
                            $topicResult = mysqli_query($con, $topicQuery);

                            if ($topicResult) {
                                $topicData = mysqli_fetch_assoc($topicResult);
                                $topicID = $topicData['topic_id'];
                            }

                            echo "<tr>";
                            echo "<td>$count</td>";
                            echo "<td>$topic</td>";
                            echo "<td class='actions'>";
                            echo "<a href='questions.php?topic_id=$topicID'>addQuestions</a>";
                            echo "<a href='deleteQuizTopic.php?topic_id=$topicID'>Delete</a>";
                         
                            echo "</td>";
                            echo "</tr>";
                            $count++;
                        }
                    }
                }
                ?>
            </tbody>
        </table>
    <?php else : ?>
        <p>No topics available for the selected category.</p>
    <?php endif; ?>
</div>
    </div>
</body>
</html>
