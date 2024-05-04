<?php
include '..//connection.php';
session_start();
if(!isset($_SESSION['adminid'])){
    header('location:index.php');
}

if (isset($_GET['id'])) {
    $questionID = $_GET['id'];
    $query = "SELECT * FROM questions WHERE question_id = '$questionID'";
    $result = mysqli_query($con, $query);
    $question = mysqli_fetch_assoc($result);

    if (!$question) {
        echo "Question not found.";
        exit();
    }
} else {
    echo "Invalid question ID.";
    exit();
}

if (isset($_POST['delete'])) {
    // User confirmed the deletion
    $deleteQuery = "DELETE FROM questions WHERE question_id = '$questionID'";
    mysqli_query($con, $deleteQuery);
    header("Location: questions.php");
    exit();
} elseif (isset($_POST['cancel'])) {
    // User cancelled the deletion
    header("Location: questions.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Delete Question | Online Quiz System</title>
    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete the question?");
        }
    </script>
</head>
<body>
    <h2>Delete Question</h2>
    <p>Are you sure you want to delete the following question?</p>
    <p><strong>Question:</strong> <?php echo $question['question']; ?></p>
    <p><strong>Options:</strong></p>
    <ul>
        <li>1. <?php echo $question['option1']; ?></li>
        <li>2. <?php echo $question['option2']; ?></li>
        <li>3. <?php echo $question['option3']; ?></li>
        <li>4. <?php echo $question['option4']; ?></li>
    </ul>
    <form action="" method="post">
        <button type="submit" name="delete" onclick="return confirmDelete()">Delete</button>
        <button type="submit" name="cancel">Cancel</button>
    </form>
</body>
</html>
