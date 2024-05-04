
<style>
    .start-button {
        display: block;
        width: 200px;
        margin: 0 auto;
        padding: 10px 20px;
        text-align: center;
        background-color: #60009b;
        color: #fff;
        font-size: 18px;
        font-weight: bold;
        text-decoration: none;
        border-radius: 5px;
    }

    .start-button:hover {
        background-color: #9909f2;
    }
</style>

<?php
  include 'header.php';
?>
  <div class="main-wrapper">
    <?php
    if (isset($_SESSION['invalid-pw'])) {
      echo '<h1 class="title">Invalid password!</h1>';
    } else if (isset($_SESSION['logged-in'])) {
            $type = $_SESSION['type'];
      if ($type == 1) {
        include 'admin.php';
      } else if ($type == 2) {
        include 'teacher.php';
        echo '
        <a href="create.php">Create Quiz</a><br />
        <a href="quiz_edit.php">Edit Quiz</a>';
      } else if ($type == 3) {
        include 'student.php';
      }
    }
    ?>
  <?php if (!isset($_SESSION['logged-in'])) { ?>
  <section class="hero">
  <h1>Welcome To Quiz</h1>
  <h2>Play and test your Knowledes with our quizzes.</h2>
        <a href="userLogin.php" class="start-button">Start Quiz</a>

</section>
<section id="quest">
    
</section>
</div>
<?php } ?>