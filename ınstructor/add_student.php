<?php
session_start(); // Start the session to access session variables
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['user_name'];
    include 'partities/connection.php';

    $query = "SELECT * FROM user WHERE user_name = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if ($user["role"] == "Student") {
            // Get the student's primary key (pk) from the STUDENT table
            $query_student_pk = "SELECT pk FROM STUDENT WHERE userFK = " . $user['pk'];
            $result_student_pk = mysqli_query($connection, $query_student_pk);
            $student_pk_row = mysqli_fetch_assoc($result_student_pk);
            $student_pk = $student_pk_row['pk'];

            // Insert the course-student relationship
            $course_id = $_GET['courseFK'];
            // Retrieve the updated_by information from the session
            $updated_by = $_SESSION["user_firstname"] . " " . $_SESSION["user_lastname"];
            $updated_by = mysqli_real_escape_string($connection, $updated_by);
            $query_insert_course_student = "INSERT INTO `course_student`(`courseFK`, `studentFK`, `updated_by`) VALUES ($course_id, $student_pk, '$updated_by')";
            $result_insert_course_student = mysqli_query($connection, $query_insert_course_student);

            if ($result_insert_course_student) {
                header("Location: ContentOfAddStudent.php");
                exit();
            } else {
                echo "Error inserting course-student relationship: " . mysqli_error($connection);
            }
        } else {
            echo "Kullanıcı bir öğrenci değil.";
            echo "Error: " . mysqli_error($connection);
        }
    } else {
        echo "Kullanıcı bulunamadı.";
        echo "Error: " . mysqli_error($connection);
    }
    header("Location: ContentOfAddStudent.php");
}

?>