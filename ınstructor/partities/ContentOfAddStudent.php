
<div class="content">
    
<?php
include 'HeaderInst.php';
include 'connection.php';

if (isset($_GET['courseFK'])) {
    $course_id = $_GET['courseFK'];

    // Fetch student primary keys from the course_student table
    $query_course_student = "SELECT cs.studentFK, u.first_name, u.last_name FROM course_student cs INNER JOIN student s ON cs.studentFK = s.pk INNER JOIN user u ON s.userFK = u.pk WHERE cs.courseFK = $course_id";
    $result_course_student = mysqli_query($connection, $query_course_student);

    if ($result_course_student) {
        if (mysqli_num_rows($result_course_student) > 0) {
            // Display the list of registered students in a Bootstrap table
            echo "<h2>List of Registered Students</h2>";
            echo '<div class="container">';
            echo '<div class="table-responsive float-left">';
            echo '<table class="table table-striped">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>First Name</th>';
            echo '<th>Last Name</th>';
            echo '<th>Action</th>'; 
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            while ($row = mysqli_fetch_assoc($result_course_student)) {
                echo '<tr>';
                echo '<td>' . $row['first_name'] . '</td>';
                echo '<td>' . $row['last_name'] . '</td>';
                // Delete button
                echo '<td><form method="post" action="partities/delete_student.php">';
                echo '<input type="hidden" name="courseFK" value="' . $course_id . '">';
                echo '<input type="hidden" name="studentFK" value="' . $row['studentFK'] . '">';
                echo '<button type="button" class="btn btn-danger" onclick="confirmDelete(' . $row['studentFK'] . ')">Delete</button>';
                echo '</form></td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
            echo '</div>';
            echo '</div>';
        } else {
            echo "<p>No students registered yet for this course.</p>";
        }
    } else {
        echo "Error fetching course-student data: " . mysqli_error($connection);
    }
} else {
    echo 'Course ID is not provided.';
}

?>
<h2>Add a Student</h2>
<form method="post" action="add_student.php?courseFK=<?php echo $course_id ?>">
    <div class="form-group">
        <label for="user_name">Student Username:</label>
        <input type="text" id="user_name" name="user_name" required>
    </div>
    <button type="submit">Add Student</button>
</form>

<?php
include 'Footer.php';
?>
</div>
<script>
function confirmDelete(studentID) {
    if (confirm("Are you sure you want to delete this student?")) {
        // If user confirms, submit the form
        document.querySelector('input[name="studentFK"]').value = studentID;
        document.querySelector('form').submit();
    }
}
</script>