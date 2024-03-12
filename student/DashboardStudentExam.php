<?php
$exams = array(
    array("name" => "Course 1", "id" => 101, "date" => "2024-03-10"),
    array("name" => "Course 2", "id" => 102, "date" => "2024-03-15"),
    array("name" => "Course 3", "id" => 103, "date" => "2024-03-20"),
    array("name" => "Course 4", "id" => 104, "date" => "2024-03-25"),
    array("name" => "Course 5", "id" => 105, "date" => "2024-03-30")
);
?>

<div class="container">
    <table class="table table-bordered table-striped table-hover text-center mt-5">
        <thead class="table-primary">
            <tr>
                <th>Course</th>
                <th>ID</th>
                <th>Date</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($exams as $exam) { ?>
                <tr>
                    <td><?php echo $exam["name"]; ?></td>
                    <td><?php echo $exam["id"]; ?></td>
                    <td><?php echo $exam["date"]; ?></td>
                    <td><button class="btn btn-success btn-sm">Start Exam</button></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>