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
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h2>Student Course Information</h2>
    <table>
        <thead>
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
                echo "<td>" . $row['instructorFK'] . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</body>

</html>
