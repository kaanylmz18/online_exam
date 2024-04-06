<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Exam</title>
    <link rel="shortcut icon" type="image/x-icon" href="https://cdn-icons-png.freepik.com/256/3178/3178285.png?ga=GA1.1.2125020956.1709586637&" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .sidebar {
            height: 100%;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #212529;
            padding-top: 20px;
        }

        .nav-link {
            color: #ffffff;
        }

        .main-content {
            margin-left: 250px;

            padding: 20px;
        }
    </style>
</head>

<body>

<?php
include 'partities/SidebarInstructor.php';
include 'partities/connection.php';

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = test_input($_POST['date']);
    $type = test_input($_POST['type']);
    $grade_percent = test_input($_POST['grade_percent']);

    // Retrieve courseFK from the URL parameter
    if (isset($_GET['courseFK'])) {
        $courseFK = $_GET['courseFK'];

        // Check if there are already final exams for the course
        $query = "SELECT COUNT(*) AS final_exam_count FROM exam WHERE courseFK = ? AND type = 'final'";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, "i", $courseFK);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        $final_exam_count = $row['final_exam_count'];

        if ($type == 'final' && $final_exam_count > 0) {
            echo "<div class='alert alert-danger' role='alert'>Final exam already exists for this course. Cannot create another final exam.</div>";
        } else {
            // Fetch existing exam records for the course
            $query = "SELECT SUM(grade_percent) AS total_grade FROM exam WHERE courseFK = ?";
            $stmt = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($stmt, "i", $courseFK);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);
            $total_grade = $row['total_grade'];

            // Calculate total grade percentage including the new exam
            $new_total_grade = $total_grade + $grade_percent;

            // Check if the total grade percentage exceeds 100%
            if ($new_total_grade <= 100) {
                // Insert the new exam record
                $query = "INSERT INTO `exam`(`date`, `type`, `courseFK`, `grade_percent`) VALUES (?, ?, ?, ?)";
                $stmt = mysqli_prepare($connection, $query);
                mysqli_stmt_bind_param($stmt, "ssii", $date, $type, $courseFK, $grade_percent);
                $result = mysqli_stmt_execute($stmt);

                if ($result) {
                    // Fetch instructor name from the database
                    $instructor_query = "SELECT name FROM ınstructor WHERE id = (SELECT instructorFK FROM courses WHERE pk = ?)";
                    $stmt = mysqli_prepare($connection, $instructor_query);
                    mysqli_stmt_bind_param($stmt, "i", $courseFK);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    $instructor_row = mysqli_fetch_assoc($result);
                    $instructor_name = $instructor_row['name'];

                    // Update the updated_by column with the course instructor's name
                    $query_update = "UPDATE exam SET updatedBy = ? WHERE courseFK = ? AND date = ?";
                    $stmt = mysqli_prepare($connection, $query_update);
                    mysqli_stmt_bind_param($stmt, "sds", $instructor_name, $courseFK, $date);
                    $result_update = mysqli_stmt_execute($stmt);

                    if ($result_update) {
                        echo "<div class='alert alert-success' role='alert'>Exam created successfully and updated by $instructor_name!</div>";
                    } else {
                        echo "<div class='alert alert-warning' role='alert'>Exam created successfully, but failed to update updated_by column.</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger' role='alert'>Error: " . mysqli_error($connection) . "</div>";
                }
            } else {
                echo "<div class='alert alert-danger' role='alert'>Total grade percentage exceeds 100%. Please adjust the grade percentage.</div>";
            }
        }
    } else {
        echo "<div class='alert alert-danger' role='alert'>CourseFK parameter not found in the URL.</div>";
    }
}
?>




    <div class="main-content">
        <?php include 'partities/HeaderInst.php'; ?>
        <div class="container mt-5">
            <h2>Create Exam</h2>
            <form id="examForm" method="post" onsubmit="return validateForm()">
                <div class="mb-3">
                    <label for="type" class="form-label">Type of Exam *</label>
                    <select class="form-select" id="type" name="type" required>
                        <option value="midterm">Midterm</option>
                        <option value="final">Final</option>
                        <option value="project">Project</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="date" class="form-label">Exam Date *</label>
                    <input type="date" class="form-control" id="date" name="date" required>
                </div>
                <div class="mb-3">
                    <label for="grade_percent" class="form-label">Grade Percentage (%) *</label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="grade_percent" name="grade_percent" min="5" max="100" value="0" required>
                        <button class="btn btn-outline-secondary" type="button" id="increaseBtn">Up</button>
                    </div>
                </div><br>
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <?php
                        $course_id = $_GET['courseFK'];
                        ?>
                        <a href='CourseDetails.php?coursePK=<?php echo $course_id; ?>' class='btn btn-secondary'>Back To Page</a>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary">Create Exam</button>
                    </div>
                </div>
            </form>
        </div>
        <?php include 'partities/Footer.php'; ?>
    </div>

    <script>
        function validateForm() {
            var type = document.getElementById("type").value;
            var date = document.getElementById("date").value;
            var grade_percent = document.getElementById("grade_percent").value;

            if (type == "") {
                alert("Please select the type of exam.");
                return false;
            }

            if (date == "") {
                alert("Please select the exam date.");
                return false;
            }

            if (grade_percent == "" || isNaN(grade_percent) || grade_percent < 5 || grade_percent > 100) {
                alert("Please enter a valid grade percentage between 5 and 100.");
                return false;
            }

            return true;
        }

        document.getElementById('increaseBtn').addEventListener('click', function() {
            var input = document.getElementById('grade_percent');
            var value = parseInt(input.value);
            if (!isNaN(value)) {
                input.value = value + 10;
            }
        });
    </script>

</body>

</html>