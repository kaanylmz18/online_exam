<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Online Exam</title>
    <link rel="shortcut icon" type="image/x-icon" href="https://cdn-icons-png.freepik.com/256/3178/3178285.png?ga=GA1.1.2125020956.1709586637&" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .total-exam-count {
            text-align: right;
            padding: 10px;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .total-exam-count span {
            font-weight: bold;
            color: #007bff;
 
        }
        .message-container {
        display: none;
        color: #fff;
        background-color: #EE9BA3; 
        padding: 10px; 
        margin-top: 10px;  
        border-radius: 5px; 
        font-size: 16px;
        font-weight: bold;
        text-align: center;
    }
    </style>
</head>

<body>
<?php
include 'HeaderInst.php';
include 'connection.php';

// Function to delete an exam by ID
function deleteExam($exam_id, $connection) {
    $query_delete_exam = mysqli_query($connection, "DELETE FROM exam WHERE pk = $exam_id");
    return $query_delete_exam ? true : false;
}

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
            echo "<table class='table table-bordered table-striped' id='exam-table'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>Exam ID</th>";
            echo "<th>Exam Date</th>";
            echo "<th>Type of Exam</th>";
            echo "<th>Grade</th>";
            echo "<th>Grade Percent</th>";
            echo "<th>Actions</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";

            while ($exam = mysqli_fetch_assoc($query_exams)) {
                echo "<tr id='exam-row-" . $exam['pk'] . "'>";
                echo "<td>" . $exam['pk'] . "</td>";
                echo "<td>" . $exam['date'] . "</td>";
                echo "<td>" . $exam['type'] . "</td>";
                echo "<td>" . $exam['grade'] . "</td>";
                echo "<td>" . $exam['grade_percent'] . "%</td>";
                echo "<td>
                    <a href='UpdateExam.php?examPK=" . $exam['pk'] . "' class='btn btn-primary btn-sm'>Update</a>
                    <button class='btn btn-danger btn-sm delete-exam' data-exam-id='" . $exam['pk'] . "'>Delete</button>
                </td>";
                echo "</tr>";
            }

            echo "</tbody>";
            echo "</table>";
            echo "</div>";
            echo "<div id='message-container' class='message-container'></div>";
            echo "<div class='total-exam-count '>Total Exams: <span>$exams_count</span></div>";
        } else {
            echo "<p>No exams found for this course.</p>";
        }
        echo "<a href='CreateExam.php?courseFK=$course_id' class='btn btn-success float-end mx-2'>Add Exam</a>";
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

// Process deletion if deleteExam parameter is present
if (isset($_GET['deleteExam'])) {
    $exam_id = $_GET['deleteExam'];
    if (deleteExam($exam_id, $connection)) {
        
        echo "<script>alert('Exam deleted successfully.'); window.location.href = 'CourseDetails.php?coursePK=$course_id';</script>";
        exit;
    } else {
        echo "<script>alert('Failed to delete exam.'); window.location.href = 'CourseDetails.php?coursePK=$course_id';</script>";
        exit;
    }
}
?>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add event listener to delete exam buttons
        document.querySelectorAll('.delete-exam').forEach(item => {
            item.addEventListener('click', event => {
                const examId = event.target.getAttribute('data-exam-id');
                if (confirm('Are you sure you want to delete this exam?')) {
                    fetch(`?coursePK=<?php echo $course_id; ?>&deleteExam=${examId}`)
                        .then(response => {
                            if (response.ok) {
                                return response.text();
                            } else {
                                throw new Error('Network response was not ok.');
                            }
                        })
                        .then(data => {
                            const rowToRemove = document.getElementById(`exam-row-${examId}`);
                            rowToRemove.parentNode.removeChild(rowToRemove);
                            // Display the message in a container
                            const messageContainer = document.getElementById('message-container');
                            messageContainer.innerText = "Exam deleted.";
                            messageContainer.style.display = 'block';
                        })
                        .catch(error => {
                            alert('An error occurred while deleting the exam.');
                            console.error('Error:', error);
                        });
                }
            });
        });
    });
</script>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>