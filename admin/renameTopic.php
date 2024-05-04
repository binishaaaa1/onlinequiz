<?php
session_start();
if (!isset($_SESSION['adminid'])) {
    header('location:index.php');
}

$adminid = $_SESSION['adminid'];
include '..//connection.php';

$topicID = $_GET['topic_id'];

if (isset($_POST['submit'])) {
    $newTopic = $_POST['new_topic'];

    $query = "UPDATE quiz_topics SET topic_name = '$newTopic' WHERE topic_id = '$topicID'";
    mysqli_query($con, $query);
    header("Location: quizTopic.php?category_id=$categoryID && topic_id=$topic_id");

    exit();
}

$query = "SELECT topic_name FROM quiz_topics WHERE topic_id = '$topicID'";
$result = mysqli_query($con, $query);

// Check if the query execution was successful
if ($result) {
    $topicData = mysqli_fetch_assoc($result);
    $currentTopic = $topicData['topic_name'];
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
        }
        
        .navbar {
            background-color: #333;
            color: #fff;
            padding: 10px;
        }

        .navbar ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }

        .navbar li {
            float: left;
        }

        .navbar li a {
            display: block;
            color: #fff;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        .navbar li a:hover {
            background-color: #555;
            color: red;
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
    </style>
</head>
<body>
    <div class="navbar">
        <ul>
            <li><a href="adminDashboard.php">Home</a></li>
            <li><a href="Category.php">Category</a></li>
            <li><a href="questions.php">Question</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
    <div class="container">
        <div class="card">
            <h2>Rename Topic</h2>
            <form action="" method="post">
                <label for="new_topic">Enter New Quiz Topic:</label>
                <input type="text" name="new_topic" placeholder="Enter new quiz topic" value="<?php echo $currentTopic; ?>" required>
                <input type="submit" name="submit" value="Rename Topic">
            </form>
        </div>
    </div>
</body>
</html>
