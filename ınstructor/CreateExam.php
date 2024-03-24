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
    include 'HeaderInst.php';
    include 'connection.php';

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $date = $_POST['date'];
        $type = $_POST['type'];
        $grade_percent = $_POST['grade_percent'];

        // Retrieve courseFK from the URL parameter
        if(isset($_GET['courseFK'])) {
            $courseFK = $_GET['courseFK'];


        // Retrieve courseFK from POST parameter
        //if (isset($_POST['courseFK'])) {
        //    $courseFK = $_POST['courseFK'];
            

            // Insert the exam into the database
            $query = "INSERT INTO `exam`(`date`, `type`, `courseFK`, `grade_percent`) VALUES ('$date', '$type', '$courseFK', '$grade_percent')";
            $result = mysqli_query($connection, $query);

            if ($result) {
                echo "<div class='alert alert-success' role='alert'>Exam created successfully!</div>";
            } else {
                echo "<div class='alert alert-danger' role='alert'>Error: " . mysqli_error($connection) . "</div>";
            }
        } else {
            echo "<div class='alert alert-danger' role='alert'>CourseFK parameter not found in the URL.</div>";
        }
    }
    ?>


    <div class="container mt-5">
        <h2>Create Exam</h2>
        <form method="post">

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
            </div>

            <button type="submit" class="btn btn-primary">Create Exam</button>
        </form>
    </div>



    <?php
    include 'Footer.php';
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