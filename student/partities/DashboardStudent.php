<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Course Information</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-4">
        <div class="row">
            <div class="custom-header">
                <p>Good Morning <?php echo $_SESSION["user_firstname"] ?>...</p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        The Next 3 Exam
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col"> ID </th>
                                        <th scope="col">Course</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Grade Percent</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php include 'connection.php';

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
                                        WHERE cs.studentFK = ?
                                        ORDER BY e.date ASC
                                        LIMIT 3";
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
                                    } else { ?>
                                        <tr>
                                            <td colspan="5">No upcoming exams.</td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-4">
        <div class="row p-3">
            <div class="col-4 offset-2">
                <div style="box-shadow: rgba(0, 0, 0, 0.07) 0px 1px 2px, rgba(0, 0, 0, 0.07) 0px 2px 4px, rgba(0, 0, 0, 0.07) 0px 4px 8px, rgba(0, 0, 0, 0.07) 0px 8px 16px, rgba(0, 0, 0, 0.07) 0px 16px 32px, rgba(0, 0, 0, 0.07) 0px 32px 64px;box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px;" class="card text-bg-primary mb-3">
                    <div class="card-header"><strong>Total Exam Taken</strong></div>
                    <div class="card-body">
                        <p class="card-text text-center"><b>5</b></p>
                    </div>
                </div>
            </div>
            <div class="col-4 ">
                <div style="box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px;" class="card text-bg-success mb-3">
                    <div class="card-header"><strong>Total Score</strong></div>
                    <div class="card-body">
                        <p class="card-text text-center"><b>42/75 || %54</b></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>