 <!-- Content -->
 <div class="content">
     <?php
        include 'HeaderInst.php';
        include 'connection.php';



        // Check if the user is logged in as an instructor
        if (isset($_SESSION["user_id"]) && $_SESSION["user_role"] == "Instructor") {
            $instructor_id = $_SESSION["user_id"];
            // Fetch courses associated with the logged-in instructor
            $query = mysqli_query($connection, "SELECT * FROM courses WHERE instructorFK = $instructor_id");
        } else {
            // Redirect to login page if not logged in or not an instructor
            header("Location: Login.php");
            exit();
        }
        ?>
     <div class="container">
         <table class="table table-bordered table-striped table-hover text-center mt-5">
             <thead class="table-primary">
                 <tr>
                     <th style="width: 33%;">ID</th>
                     <th style="width: 33%;">Name</th>
                     <th style="width: 33%;">Code</th>

                 </tr>
             </thead>
             <tbody>
                 <?php while ($row = mysqli_fetch_assoc($query)) { ?>
                     <tr>
                         <td><?php echo "$row[pk]"; ?></td>
                         <td><?php echo "$row[name]"; ?></td>
                         <td><a href="CourseDetails.php?coursePK=<?php echo $row['pk']; ?>"><?php echo "$row[code]"; ?></a> </td>
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