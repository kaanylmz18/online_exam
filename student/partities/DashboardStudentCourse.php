<?php
// Include the database connection
include 'connection.php';

// Fetch the student's userPK from the session
$userPK = $_SESSION["user_id"];

$query = "SELECT c.name, c.code, c.instructorFK
FROM courses c
JOIN course_student cs ON c.pk = cs.courseFK
JOIN student s ON cs.studentFK = s.pk
JOIN user u ON s.userFK = u.pk
WHERE u.pk = $userPK;";

// Execute the query
$result = $connection->query($query);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Course Information</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <br>
    <div class="container">
        <table class="table table-bordered table-striped table-hover text-center mt-5">
            <thead class="table-primary">
                <tr>
                    <th>Course Name</th>
                    <th>Course Code</th>
                    <th>Course's Instructor</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop through each enrolled course and display it in a table row
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['code'] . "</td>";
                    $query = "SELECT name FROM ınstructor WHERE id = " . $row['instructorFK'];
                    $instructorResult = $connection->query($query);
                    // Fetch the data from the result object
                    $instructorRow = $instructorResult->fetch_assoc();
                    // Output the instructor's name
                    echo "<td>" . $instructorRow['name'] . "</td>";
                    echo "</tr>";
                }
                ?>

            </tbody>
        </table>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
