<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Exam</title>
    <link rel="shortcut icon" type="image/x-icon" href="https://cdn-icons-png.freepik.com/256/3178/3178285.png?ga=GA1.1.2125020956.1709586637&" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>

    <?php
    include 'partities/HeaderInst.php';
    include 'partities/connection.php';
    
    function test_input($data){
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
    
            // Fetch existing exam records for the course
            $query = "SELECT SUM(grade_percent) AS total_grade FROM exam WHERE courseFK = '$courseFK'";
            $result = mysqli_query($connection, $query);
            $row = mysqli_fetch_assoc($result);
            $total_grade = $row['total_grade'];
    
            // Calculate total grade percentage including the new exam
            $new_total_grade = $total_grade + $grade_percent;
    
            // Check if the total grade percentage exceeds 100%
            if ($new_total_grade <= 100) {
                // Insert the new exam record
                $query = "INSERT INTO `exam`(`date`, `type`, `courseFK`, `grade_percent`) VALUES ('$date', '$type', '$courseFK', '$grade_percent')";
                $result = mysqli_query($connection, $query);
    
                if ($result) {
                    echo "<div class='alert alert-success' role='alert'>Exam created successfully!</div>";
                } else {
                    echo "<div class='alert alert-danger' role='alert'>Error: " . mysqli_error($connection) . "</div>";
                }
            } else {
                echo "<div class='alert alert-danger' role='alert'>Total grade percentage exceeds 100%. Please adjust the grade percentage.</div>";
            }
        } else {
            echo "<div class='alert alert-danger' role='alert'>CourseFK parameter not found in the URL.</div>";
        }
    }
    ?>


    <div class="container mt-5">
        <h2>Create Exam</h2>
        <form method="post"  >
            <div class="mb-3">
                <label for="type" class="form-label">Type of Exam</label>
                <select class="form-select" id="type" name="type">
                    <option value="midterm">Midterm</option>
                    <option value="final">Final</option>
                    <option value="project">Project</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Exam Date</label>
                <input type="date" class="form-control" id="date" name="date" required>
            </div>
            <div class="mb-3">
                <label for="grade_percent" class="form-label">Grade Percentage (%)</label>
                <div class="input-group">
                    <input type="number" class="form-control" id="grade_percent" name="grade_percent" min="0" max="100" value="0" required>
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