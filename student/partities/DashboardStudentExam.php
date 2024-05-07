<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Course Information</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <table class="table table-bordered table-striped table-hover text-center mt-5">
            <thead class="table-primary">
                <tr>
                    <th>ID</th>
                    <th>Course</th>
                    <th>Type</th>
                    <th>Date</th>
                    <th>Percent</th>
                </tr>
            </thead>
            <tbody>
                <?php

                include 'connection.php';

                $userPK = $_SESSION["user_id"];

                // Fetch student_fk from the database using the user_pk
                $query_student_fk = "SELECT pk FROM student WHERE userFK = ?";
                $stmt_student_fk = $connection->prepare($query_student_fk);
                $stmt_student_fk->bind_param("i", $userPK);
                $stmt_student_fk->execute();
                $result_student_fk = $stmt_student_fk->get_result();

                if ($result_student_fk->num_rows == 1) {
                    $row_student_fk = $result_student_fk->fetch_assoc();
                    $studentFK = $row_student_fk['pk'];

                    // Fetch courses and exams associated with the student_fk
                    $query_courses_exams = "SELECT e.pk, c.name, e.type, e.date, e.grade_percent
                    FROM course_student cs
                    JOIN courses c ON cs.courseFK = c.pk
                    JOIN exam e ON c.pk = e.courseFK
                    WHERE cs.studentFK = ?";
                    $stmt_courses_exams = $connection->prepare($query_courses_exams);
                    $stmt_courses_exams->bind_param("i", $studentFK);
                    $stmt_courses_exams->execute();
                    $result_courses_exams = $stmt_courses_exams->get_result();

                    // Display the fetched data in the table
                    while ($row_courses_exams = $result_courses_exams->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row_courses_exams['pk'] . "</td>";
                        echo "<td>" . $row_courses_exams['name'] . "</td>";
                        echo "<td>" . $row_courses_exams['type'] . "</td>";
                        echo "<td>" . $row_courses_exams['date'] . "</td>";
                        echo "<td>" . $row_courses_exams['grade_percent'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "Student information not found.";
                }
                ?>

            </tbody>
        </table>
    </div>
</body>

</html>