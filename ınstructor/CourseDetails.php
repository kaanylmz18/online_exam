<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Online Exam</title>
    <link rel="shortcut icon" type="image/x-icon" href="https://cdn-icons-png.freepik.com/256/3178/3178285.png?ga=GA1.1.2125020956.1709586637&" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body>
    <?php
    include 'HeaderInst.php';
    include 'connection.php';
    // Fetch course details


    if (isset($_GET['coursePK'])) {
        $course_id = $_GET['coursePK'];

        $query_course = mysqli_query($connection, "SELECT * FROM courses WHERE pk = $course_id");
        $course = mysqli_fetch_assoc($query_course);

        if ($course) {
            echo "<div class='container mt-5'>";
            echo "<h2>Kurs Detayları</h2>";
            echo "<div class='mb-4'>";
            echo "<p><strong>ID:</strong> " . $course_id . "</p>";
            echo "<p><strong>Ad:</strong> " . $course['name'] . "</p>";
            echo "<p><strong>Kod:</strong> " . $course['code'] . "</p>";
            echo "</div>";
   
            // Fetch exams related to the course
            $query_exams = mysqli_query($connection, "SELECT * FROM exam WHERE courseFK = $course_id");
            $exams_count = mysqli_num_rows($query_exams);

            if ($exams_count > 0) {
                echo "<h3>Exams</h3>";
                echo "<div class='table-responsive'>";
                echo "<table class='table table-bordered table-striped'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th>Exam ID</th>";
                echo "<th>Exam Date</th>";
                echo "<th>Type of Exam</th>";
                echo "<th>Grade</th>";
                echo "<th>Grade Percent</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";

                while ($exam = mysqli_fetch_assoc($query_exams)) {
                    echo "<tr>";
                    echo "<td>" . $exam['pk'] . "</td>";
                    echo "<td>" . $exam['date'] . "</td>";
                    echo "<td>" . $exam['type'] . "</td>";
                    echo "<td>" . $exam['grade'] . "</td>";
                    echo "<td>" . $exam['grade_percent'] . "%</td>";
                    echo "</tr>";
                }

                echo "</tbody>";
                echo "</table>";
                echo "</div>";
            } else {
                echo "<p>No exams found for this course.</p>";
            }
            echo "<a href='CreateExam.php?courseFK=" . $course_id . "' class='btn btn-success float-end mx-2'>Add Exam</a>";
            //echo "<form action='CreateExam.php' method='post'>";
            //echo "<input type='hidden' name='courseFK' value='$course_id'>";
            //echo "<button type='' class='btn btn-success float-end mx-2'>Add Exam</button>";
            //echo "</form>";

            echo "<a href='InstructorCourses.php' class='btn btn-primary float-end'>Back To Page</a>";

            echo "</div>";
            echo "<br>";
        } else {
            echo "<div class='container'>";
            echo "<p>Kurs bulunamadı.</p>";
            echo "</div>";
        }
    } else {
        echo "<div class='container'>";
        echo "<p>Geçersiz istek. Lütfen bir kurs kimliği sağlayın.</p>";
        echo "</div>";
    }

    include 'Footer.php';
    ?>
    




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>