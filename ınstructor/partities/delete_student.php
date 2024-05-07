<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['courseFK']) && isset($_POST['studentFK'])) {
        $course_id = $_POST['courseFK'];
        $student_id = $_POST['studentFK'];

        // Delete the student from the course_student table
        $query_delete_student = "DELETE FROM course_student WHERE courseFK = $course_id AND studentFK = $student_id";
        $result_delete_student = mysqli_query($connection, $query_delete_student);

        if ($result_delete_student) {
            session_start();
            $_SESSION['success_message'] = "Student successfully deleted.";
            header("Location: {$_SERVER['HTTP_REFERER']}");
            exit();
        } else {
            echo "Error deleting student: " . mysqli_error($connection);
        }
    } else {
        echo "Invalid request.";
    }
}
?>