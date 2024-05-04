<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name=viewport content="width=device-width, initial-scale=1">
    <title></title>
    <link rel="stylesheet" href="s1.css">
    <link rel="stylesheet" href="s2.css">
    <style>
      li {
        list-style: none;
      }
    </style>
  </head>
  <body>
  <nav>
    <img src="thought-leadership.png" alt="thought-leadership.png">
    <h1>Brainly : Online Quiz</h1>
    <ul class="menu-links">
      <li><a href="index.php" class="menu">Home</a></li>
      <?php if (isset($_SESSION['logged-in'])) { ?>
          <li><a href="quiz.php">Quizzes</a></li>
          <?php $id = $_SESSION['uid'];?>
          <li><a href="courses.php?id=<?php echo $id; ?>">Courses</a></li>
     <?php } else {?>
      <li><a href="userLogin.php" class="menu">LogIn</a></li>
      <li><a href="userRegister.php" class="menu">Register</a></li>
      <?php } ?>
    </ul>
  </nav> 
    <header>
      <div class="header-login">
        <?php
          if (isset($_SESSION['logged-in'])) {
            $user = $_SESSION['uname'];
            echo '
                  <a href="account.php?user=' . $user . '">Welcome, ' . $user . '</a>
                  <form action="inc/logout.inc.php" method="post">
                  <button type="submit" name="logout-submit">Logout</button>
                  </form>';
          }
         ?>

      </div>
    </header>
  </body>
</html>
