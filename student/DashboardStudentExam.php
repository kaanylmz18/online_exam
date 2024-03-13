<?php

class StudentExam {
    public $name;
    public $id;
    public $date;

    public function __construct($name, $id, $date) {
        $this->name = $name;
        $this->id = $id;
        $this->date = $date;
    }

    public function getName() {
        return $this->name;
    }

    public function getId() {
        return $this->id;
    }

    public function getDate() {
        return $this->date;
    }
}

$exams = array(
    new StudentExam("Course 1", 101, "2024-03-10"),
    new StudentExam("Course 2", 102, "2024-03-15"),
    new StudentExam("Course 3", 103, "2024-03-20"),
    new StudentExam("Course 4", 104, "2024-03-25"),
    new StudentExam("Course 5", 105, "2024-03-30")
);

$jsonExams = json_encode($exams);

echo $jsonExams;

    
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
                    <td><?php echo $exam->getName(); ?></td>
                    <td><?php echo $exam->getId(); ?></td>
                    <td><?php echo $exam->getDate(); ?></td>
                    <td><button class="btn btn-success btn-sm">Start Exam</button></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div> 