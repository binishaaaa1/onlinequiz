<?php
session_start();
if (!isset($_SESSION['adminid'])) {
    header('location:index.php');
}
include '..//connection.php';

// Make sure $con is defined and is the database connection variable

$topicID = $_GET['topic_id'];
echo $topicID;

$query = "DELETE FROM quiz_topics WHERE topic_id='$topicID'";
$result = mysqli_query($con, $query);
if ($result) {
    // Deletion successful, redirect to the desired page
    header("Location: category.php");
    exit();
} else {
    // Error occurred during deletion
    echo "Error: " . mysqli_error($con);
}
    ?>