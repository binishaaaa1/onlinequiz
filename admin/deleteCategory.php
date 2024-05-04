<?php
include '..//connection.php';
session_start();
if(!isset($_SESSION['adminid'])){
    header('location:index.php');
}

$categoryID=$_GET['id'];
echo $categoryID;
$query="delete  from categories where category_id='$categoryID'";
$result=mysqli_query($con,$query);
if ($result) {
    // Deletion successful, redirect to the desired page
    header("Location: category.php");
    exit();
} else {
    // Error occurred during deletion
    echo "Error: " . mysqli_error($con);
}

?>
