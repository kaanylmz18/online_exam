 <!-- Content -->
 <div class="content">
     <?php
        include 'HeaderInst.php';
        ?>
     <?php
// Define an array of exam objects
$exams = array(
    array("name" => "Course 1", "id" => 101, "date" => "2024-03-10", "duration" => "1 hr"),
    array("name" => "Course 2", "id" => 102, "date" => "2024-03-15", "duration" => "45 min"),
    array("name" => "Course 3", "id" => 103, "date" => "2024-03-20", "duration" => "1 hr 15 min"),
    array("name" => "Course 4", "id" => 104, "date" => "2024-03-25", "duration" => "1 hr 30 min"),
    array("name" => "Course 5", "id" => 105, "date" => "2024-03-30", "duration" => "2 hrs")
);
?>

<div class="container">
    <table class="table table-bordered table-striped table-hover text-center mt-5">
        <thead class="table-primary">
            <tr>
                <th style="width: 20%;">Exam</th>
                <th style="width: 15%;">ID</th>
                <th style="width: 20%;">Date</th>
                <th style="width: 20%;">Exam Duration (min)</th>
                <th style="width: 25%;"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($exams as $exam) { ?>
                <tr>
                    <td><?php echo $exam["name"]; ?></td>
                    <td><?php echo $exam["id"]; ?></td>
                    <td><?php echo $exam["date"]; ?></td>
                    <td><?php echo $exam["duration"]; ?></td>
                    <td>
                        <button class="btn btn-primary btn-sm">
                            <i class="bi bi-pencil"></i> Edit Exam
                        </button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <button class="btn btn-success mb-3 float-end">
        <i class="bi bi-plus-circle"></i> Create New Exam
    </button>
</div>
     <?php
        include 'Footer.php';
        ?>



 </div>
 <!-- Content -->