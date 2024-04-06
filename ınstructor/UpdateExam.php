<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update Exam</title>
    <link rel="shortcut icon" type="image/x-icon" href="https://cdn-icons-png.freepik.com/256/3178/3178285.png?ga=GA1.1.2125020956.1709586637&" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>

<?php
include 'partities/HeaderInst.php';
include 'partities/connection.php';

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $exam_id = test_input($_POST['exam_id']);
    $date = test_input($_POST['date']);
    $type = test_input($_POST['type']);
    $grade_percent = test_input($_POST['grade_percent']);

    // Retrieve courseFK from the URL parameter
    if (isset($_GET['courseFK'])) {
        $courseFK = $_GET['courseFK'];

        // Check if the total grade percentage including the updated exam does not exceed 100%
        $query_total_grade = "SELECT SUM(grade_percent) AS total_grade FROM exam WHERE pk <> $exam_id AND courseFK = $courseFK";
        $result_total_grade = mysqli_query($connection, $query_total_grade);
        $row_total_grade = mysqli_fetch_assoc($result_total_grade);
        $total_grade = $row_total_grade['total_grade'];

        // Calculate total grade percentage including the new exam
        $new_total_grade = $total_grade + $grade_percent;

        if ($type == 'final') {
            // Check if a final exam already exists for the course
            $query_final_exam_count = "SELECT COUNT(*) AS final_exam_count FROM exam WHERE courseFK = $courseFK AND type = 'final'";
            $result_final_exam_count = mysqli_query($connection, $query_final_exam_count);
            $row_final_exam_count = mysqli_fetch_assoc($result_final_exam_count);
            $final_exam_count = $row_final_exam_count['final_exam_count'];

            if ($final_exam_count >1 ) {
                echo "<div class='alert alert-danger' role='alert'>Final exam already exists for this course. Cannot create another final exam.</div>";
                exit; // Exit the script to prevent further execution
            }
        }

        if ($new_total_grade <= 100) {
            // Update the exam record
            $query_update_exam = "UPDATE exam SET `date`='$date', `type`='$type', `grade_percent`='$grade_percent' WHERE pk=$exam_id";
            $result_update_exam = mysqli_query($connection, $query_update_exam);

            if ($result_update_exam) {
                // Fetch instructor name from the database
                $instructor_query = "SELECT name FROM ınstructor WHERE id = (SELECT instructorFK FROM courses WHERE pk = $courseFK)";
                $instructor_result = mysqli_query($connection, $instructor_query);
                $instructor_row = mysqli_fetch_assoc($instructor_result);
                $instructor_name = $instructor_row['name'];

                // Update the updated_by column with the course instructor's name
                $query_update_updated_by = "UPDATE exam SET updatedBy = '$instructor_name' WHERE pk = $exam_id";
                $result_update_updated_by = mysqli_query($connection, $query_update_updated_by);

                if ($result_update_updated_by) {
                    echo "<div class='alert alert-success' role='alert'>Exam updated successfully and updated by $instructor_name!</div>";
                } else {
                    echo "<div class='alert alert-warning' role='alert'>Exam updated successfully, but failed to update updated_by column.</div>";
                }
            } else {
                echo "<div class='alert alert-danger' role='alert'>Error: " . mysqli_error($connection) . "</div>";
            }
        } else {
            echo "<div class='alert alert-danger' role='alert'>Total grade percentage exceeds 100%. Please adjust the grade percentage.</div>";
        }
    } else {
        echo "<div class='alert alert-danger' role='alert'>CourseFK parameter not found in the URL.</div>";
    }
} else {
    // Fetch exam details based on the examPK parameter in the URL
    if (isset($_GET['examPK'])) {
        $exam_id = $_GET['examPK'];

        // Fetch exam details
        $query_get_exam = "SELECT * FROM exam WHERE pk=$exam_id";
        $result_get_exam = mysqli_query($connection, $query_get_exam);
        $exam = mysqli_fetch_assoc($result_get_exam);

        if ($exam) {
            // Exam details found, display the form for updating
?>
            <div class="container mt-5">
                <h2>Update Exam</h2>
                <form method="post" action="">
                    <input type="hidden" name="exam_id" value="<?php echo $exam_id; ?>">
                    <div class="mb-3">
                        <label for="type" class="form-label">Type of Exam</label>
                        <select class="form-select" id="type" name="type">
                            <option value="midterm" <?php if ($exam['type'] == 'midterm') echo 'selected'; ?>>Midterm</option>
                            <option value="final" <?php if ($exam['type'] == 'final') echo 'selected'; ?>>Final</option>
                            <option value="project" <?php if ($exam['type'] == 'project') echo 'selected'; ?>>Project</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Exam Date</label>
                        <input type="date" class="form-control" id="date" name="date" value="<?php echo $exam['date']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="grade_percent" class="form-label">Grade Percentage (%)</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="grade_percent" name="grade_percent" min="5" max="100" value="<?php echo $exam['grade_percent']; ?>" required>
                            <button class="btn btn-outline-secondary" type="button" id="increaseBtn">Up</button>
                        </div>
                    </div><br>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <a href="CourseDetails.php?coursePK=<?php echo $exam['courseFK']; ?>" class="btn btn-secondary">Back To Page</a>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary">Update Exam</button>
                        </div>
                    </div>
                </form>
            </div>
<?php
        } else {
            echo "<div class='alert alert-danger' role='alert'>Exam not found!</div>";
        }
    } else {
        echo "<div class='alert alert-danger' role='alert'>ExamPK parameter not found in the URL.</div>";
    }
}
?>

<?php
include 'partities/Footer.php';
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
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

