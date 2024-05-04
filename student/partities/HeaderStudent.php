<nav class="navbar navbar-expand-sm bg-info-subtle ">
  <div class="container-fluid ">
    <a class="navbar-brand mb-0 h1" href="StudentHome.php">
      <img src="https://cdn-icons-png.freepik.com/256/3381/3381456.png?ga=GA1.1.2125020956.1709586637&" alt="Logo" height="40">
      Online Exam</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active " aria-current="page" href="StudentExam.php"><b>Exams</b></a>
        </li>
        <li class="nav-item">
          <a class="nav-link active " aria-current="page" href="StudentCourses.php"><b>Courses</b></a>
        </li>
      </ul>
    </div>
    <div class="p-2">
      <?php
      session_start();
      $student_name = $_SESSION["user_firstname"];
     
      echo "<h4><b>$student_name </b> </h4>";
      ?>
    </div>
    <div class="pb-2"><img src="https://cdn-icons-png.freepik.com/256/3297/3297637.png?ga=GA1.1.2125020956.1709586637&" alt="Student" height="40">
    </div>
  </div>
</nav>
