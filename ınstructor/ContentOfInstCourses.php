 <!-- Content -->
 <div class="content">
     <?php
        include 'HeaderInst.php';
        ?>
     <?php
        
        $courses = array(
            array("id" => 1, "name" => "Web Prog", "numOfStudents" => 12, "numOfExams" => 2),
            array("id" => 2, "name" => "Algorithm", "numOfStudents" => 99, "numOfExams" => 3)
        );
        ?>
     <div class="container">
         <table class="table table-bordered table-striped table-hover text-center mt-5">
             <thead class="table-primary">
                 <tr>
                     <th style="width: 25%;">ID</th>
                     <th style="width: 25%;">Name</th>
                     <th style="width: 25%;">Number of Students</th>
                     <th style="width: 25%;">Number of Exams</th>
                 </tr>
             </thead>
             <tbody>
                 <?php foreach ($courses as $course) { ?>
                     <tr>
                         <td><?php echo $course["id"]; ?></td>
                         <td><?php echo $course["name"]; ?></td>
                         <td><?php echo $course["numOfStudents"]; ?></td>
                         <td><?php echo $course["numOfExams"]; ?></td>
                     </tr>
                 <?php } ?>
             </tbody>
         </table>

         <button class="btn btn-success mb-3 float-end">
             <i class="bi bi-plus-circle"></i> Add New Course
         </button>
     </div>
     <?php
        include 'Footer.php';
        ?>

 </div>
 <!-- Contentf -->