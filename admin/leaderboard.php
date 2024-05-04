<?php
session_start();
include '..//connection.php';

// Retrieve the scores from the leaderboard table
$query = "SELECT u.username, l.score 
          FROM leaderboard l
          JOIN user u ON l.user_id = u.user_id
          ORDER BY l.score DESC";
$result = mysqli_query($con, $query);

$scores = array();
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $username = $row['username'];
        $score = $row['score'];

        $scores[] = array(
            'username' => $username,
            'score' => $score
        );
    }
} else {
    echo "Error executing query: " . mysqli_error($con);
}

// Close the database connection
mysqli_close($con);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scoreboard</title></title>
       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
            color: #000000;
        }

        h1 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
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
    padding: 10px;
    background-color:chocolate;
    color: black;
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
    .ranking {
            display: flex;
            align-items: center;
        }

        .ranking-icon {
            margin-right: 10px;
        }
        .gold {
    color: gold;
}

.silver {
    color: silver;
}

.bronze {
    color: #cd7f32;
}

.ranking-icon i {
    font-size: 16px;
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
    <h1>Scoreboard</h1>

   <table>
        <tr>
            <th>Rank</th>
            <th>Username</th>
            <th>Score</th>
        </tr>
        <?php $rank = 1; ?>
        <?php foreach ($scores as $score): ?>
    <tr>
        <td class="ranking">
            <?php
            $rankingClass = '';
            if ($rank == 1) {
                $rankingClass = 'gold';
            } elseif ($rank == 2) {
                $rankingClass = 'silver';
            } elseif ($rank == 3) {
                $rankingClass = 'bronze';
            }
            ?>
            <span class="ranking-icon <?php echo $rankingClass; ?>">
                <?php
                if ($rankingClass == 'gold') {
                    echo '<i class="fas fa-trophy gold"></i>';
                } elseif ($rankingClass == 'silver') {
                    echo '<i class="fas fa-trophy silver"></i>';
                } elseif ($rankingClass == 'bronze') {
                    echo '<i class="fas fa-trophy bronze"></i>';
                }
                ?>
            </span>
            <?php echo $rank; ?>
        </td>
        <td>
            <?php echo $score['username']; ?>
        </td>
        <td>
            <?php echo $score['score']; ?>
        </td>
    </tr>
    <?php $rank++; ?>
<?php endforeach; ?>

    </table>
</body>

</html>