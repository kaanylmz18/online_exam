<!-- Content -->
<div class="content">
    <?php
    include 'HeaderInst.php';
    include 'connection.php';
    if (isset($_GET['courseFK'])) {
        $course_id = $_GET['courseFK'];

        // Fetch student primary keys from the course_student table
        $query_course_student = "SELECT studentFK FROM course_student WHERE courseFK = $course_id";
        $result_course_student = mysqli_query($connection, $query_course_student);

        if ($result_course_student) {
            // Array to store student primary keys
            $student_pks = array();
            while ($row_course_student = mysqli_fetch_assoc($result_course_student)) {
                $student_pks[] = $row_course_student['studentFK'];
            }

            if (!empty($student_pks)) {
                // Fetch student user keys from the student table
                $student_pks_str = implode(',', $student_pks);
                $query_students = "SELECT userFK FROM student WHERE pk IN ($student_pks_str)";
                $result_students = mysqli_query($connection, $query_students);

                if ($result_students) {
                    // Array to store user keys
                    $user_pks = array();
                    while ($row_students = mysqli_fetch_assoc($result_students)) {
                        $user_pks[] = $row_students['userFK'];
                    }

                    if (!empty($user_pks)) {
                        // Fetch first names and last names from the user table
                        $user_pks_str = implode(',', $user_pks);
                        $query_users = "SELECT first_name, last_name FROM user WHERE pk IN ($user_pks_str)";
                        $result_users = mysqli_query($connection, $query_users);

                        if ($result_users) {
                            if (mysqli_num_rows($result_users) > 0) {
                                // Display the list of registered students
                                echo "<h2>List of Registered Students</h2>";
                                echo "<ul>";
                                while ($row_users = mysqli_fetch_assoc($result_users)) {
                                    echo "<li>" . $row_users['first_name'] . " " . $row_users['last_name'] . "</li>";
                                }
                                echo "</ul>";
                            } else {
                                echo "<p>No students registered yet for this course.</p>";
                            }
                        } else {
                            echo "Error fetching user data: " . mysqli_error($connection);
                        }
                    } else {
                        echo "No user keys found for the registered students.";
                    }
                } else {
                    echo "Error fetching student data: " . mysqli_error($connection);
                }
            } else {
                echo "No students registered yet for this course.";
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
<!-- Contentf -->
