 <!-- Content -->
 <div class="content">
     <?php
        include 'HeaderInst.php';
        include 'connection.php';
        $query = mysqli_query($connection, "SELECT * FROM courses WHERE (instructorFK=1)");


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
                         <td><?php echo "$row[code]"; ?></td>
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