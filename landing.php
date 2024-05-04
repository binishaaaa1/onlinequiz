<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <style>
   * {
  padding: 0;
  margin: 0;
  box-sizing: border-box;
  scroll-behavior: smooth;
}

body {
  /* background-color: #F5F7FA; */
  color: black;
  font-family: Arial, Helvetica, sans-serif;
  /* background-image: url('background.jpg'); */
  background-size: cover;
  background-image: linear-gradient(to right, #6a11cb, #ff8a00);

}

.main-nav {
  background-color: #333;
  position: fixed;
  width: 100%;
  z-index: 999;
}

.main-nav ul {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px;
  list-style: none;
}

.main-nav ul li {
  margin: 0 10px;
}

.main-nav ul li a {
  color: #fff;
  text-decoration: none;
  font-weight: bold;
  transition: color 0.3s ease;
}

.main-nav ul li a:hover {
  color: #C21E56;
}

.ui {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 80px;
  text-align: center;
}

.ui h1 {
  font-size: 2.5rem;
  margin-top: 24px;
  color: #C21E56;
}

.ui h1 span {
  padding: 40px;
}

.ui img {
  width: 100%;
  max-width: 600px;
  margin-top: 40px;
}

#About {
  padding: 80px;
  text-align: center;
}

#About h1 {
  font-size: 2.5rem;
  margin-bottom: 24px;
  color: #C21E56;
}

#About p {
  font-size: 1.5rem;
  max-width: 800px;
  margin: 0 auto 40px;
border-radius: 15px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 1.2);
  background: linear-gradient(to right, #ff7e5f, #feb47b);

}



#Topic {
  padding: 80px;
  text-align: center;
}

#Topic h1 {
  font-size: 2.5rem;
  margin-bottom: 24px;
  color: #C21E56;
}

#Topic .topic-list {
  display: flex;
  justify-content: center;
  align-items: flex-start;
  margin-top: 40px;
  border-radius: 15px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 1.2);
  background: linear-gradient(to right, #ff7e5f, #feb47b);  
}

#Topic .topic-list .bca,
#Topic .topic-list .bbs {
  flex: 1;
  padding: 20px;
  border: 1px solid #000;
  margin: 0 20px;
  max-width: 300px;
}

#Topic .topic-list h2 {
  font-size: 1.5rem;
  margin-bottom: 10px;
}

#Topic .topic-list ul {
  list-style: none;
  padding: 0;
}

#Topic .topic-list ul li {
  padding: 5px 0;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

#Topic .topic-list ul li:hover {
  background-color: #C21E56;
}

footer {
  background-color: #333;
  padding: 10px 0;
  text-align: center;
  color: #fff;
}

footer h2,
footer p {
  margin-bottom: 10px;
}

  </style>
</head>

<body>
  <div class="main-nav">
    <ul>
      <li><a href="#Home">Home</a></li>
      <li><a href="#Topic">Topics</a></li>
      <li><a href="#About">About</a></li>
      <li class="right"><a href="userRegister.php">Sign Up</a></li>
      <li class="right"><a href="userLogin.php">Login</a></li>
    </ul>
  </div>

  <section id="Home">
    <div class="ui">
      <h1>Welcome <span>to</span> Quiz World</h1>
      <img src="quizee.png" alt="">
    </div>
  </section>

  <section id="About">
      <h1>About Us</h1>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus voluptate alias cupiditate sunt magni
        provident saepe pariatur enim! Quis ipsam excepturi ex animi quam aperiam architecto, vero beatae similique
        officia. Maiores, quisquam commodi ea libero ipsam ut. Molestiae expedita quaerat officia nisi a ratione
        provident?Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus voluptate alias cupiditate
        sunt magni provident saepe pariatur enim! Quis ipsam excepturi ex animi quam aperiam architecto, vero beatae
        similique officia. Maiores, quisquam commodi ea libero ipsam ut. Molestiae expedita quaerat officia nisi a
        ratione provident?Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus voluptate alias
        cupiditate sunt magni provident saepe pariatur enim! Quis ipsam excepturi ex animi quam aperiam architecto,
        vero beatae similique officia. Maiores, quisquam commodi ea libero ipsam ut. Molestiae expedita quaerat
        officia nisi a ratione provident?Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus
        voluptate alias cupiditate sunt magni provident saepe pariatur enim! Quis ipsam excepturi ex animi quam
        aperiam architecto, vero beatae similique officia. Maiores, quisquam commodi ea libero ipsam ut. Molestiae
        expedita quaerat officia nisi a ratione provident?</p>
    </div>
  </section>

  <section id="Topic">
    <div style="background-color: #f7f7f7;">
      <h1>Topics</h1>
      <div class="topic-list">
        <div class="bca">
          <h2>Bca</h2>
          <hr>
          <ul>
            <li>DBMS</li>
            <li>JAVA</li>
            <li>WEB</li>
          </ul>
        </div>
        <div class="bbs">
          <h2>BBS</h2>
          <hr>
          <ul>
            <li>DBMS</li>
            <li>JAVA</li>
            <li>WEB</li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <footer>
    <h2>&copy; Ajay & Sayal</h2>
  </footer>
</body>

</html>
