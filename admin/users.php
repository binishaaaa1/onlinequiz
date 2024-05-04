<?php
// Assuming you have established a database connection
include '..//connection.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>User List</title>
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

h2 {
  text-align: center;
  margin-bottom: 20px;
}

table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

th, td {
  padding: 10px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}

th {
  background-color: #f2f2f2;
}

a.button {
  display: inline-block;
  padding: 8px 16px;
  background-color: #555;
  color: #fff;
  border-radius: 4px;
  transition: background-color 0.3s;
  text-decoration: none;
}

a.button:hover {
  background-color: #000;
}

a.view-link {
  display: inline-block;
  padding: 5px 10px;
  background-color: #007bff;
  color: #fff;
  border-radius: 4px; 
  text-decoration: none;
}

a.view-link:hover {
  background-color: #0056b3;
}

a.delete-link {
  display: inline-block;
  padding: 5px 10px;
  background-color: #ff0000;
  color: #fff;
  border-radius: 4px;
  text-decoration: none;
}

a.delete-link:hover {
  background-color: #b30000;
}
    </style>
      <script>
        function confirmDelete(userId) {
            var result = confirm("Are you sure you want to delete this user?");
            if (result) {
                window.location.href = "users.php?delete_user=" + userId;
            }
        }
    </script>
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
    <div style="text-align: center; margin-top: 20px;">
        <a href="add_user.php" style="display: inline-block; padding: 8px 16px; background-color: #555; color: #fff; border-radius: 4px; transition: background-color 0.3s; text-decoration: none;">Add New User</a>
    </div>

    <?php
// Assuming you have established a database connection
include '..//connection.php';

// Function to delete a user
function deleteUser($con, $userId) {
    $query = "DELETE FROM user WHERE user_id = $userId";
    $result = mysqli_query($con, $query);
    return $result;
}

// Check if a user deletion is requested
if (isset($_GET['delete_user']) && is_numeric($_GET['delete_user'])) {
    $userIdToDelete = $_GET['delete_user'];
    if (deleteUser($con, $userIdToDelete)) {
        echo "<script>alert('User deleted successfully.'); window.location.href = 'users.php';</script>";
    } else {
        echo "<script>alert('Error deleting user.');</script>";
    }
}

// Retrieve all users from the database
$query = "SELECT * FROM user";
$result = mysqli_query($con, $query);

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        echo "<h2>User List:</h2>";
        echo "<table>";
        echo "<tr><th>SN</th><th>Username</th><th>Email</th><th>Action</th><th>View</th></tr>";

        // Loop through the user records and display the information in a table
        $count = 1; // Initialize the count variable outside the loop
        while ($row = mysqli_fetch_assoc($result)) {
            $userId = $row['user_id'];
            $username = $row['username'];
            $email = $row['email'];

            echo "<tr>";
            echo "<td>$count</td>";
            echo "<td>$username</td>";
            echo "<td>$email</td>";
            echo "<td><a href='javascript:void(0);' onclick='confirmDelete($userId)'>delete</a></td>";
            echo "<td><a href='edit_user.php?user_id=$userId'>view</a></td>";
            echo "</tr>";

            $count++; // Increment the count variable after each user
        }

        echo "</table>";
    } else {
        echo "No users found in the database.";
    }
} else {
    echo "Error executing query: " . mysqli_error($con);
}

mysqli_close($con);
?>
</body>
</html>
