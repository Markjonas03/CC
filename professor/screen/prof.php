<?php
    include '../../include/config.php';
    session_start();

    if(!isset($_SESSION['prof_name']) && (!isset($_SESSION['user_prof']))){
        header('Location: ../../login.php'); 
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Home</title>

   <link href="../../assets/image/LOGO.png" rel="icon">

   <link href="../../assets/css/font.css" rel="stylesheet">
   <link href="../../assets/css/bootstrap.min.css" rel="stylesheet">
   <link href="../../assets/css/bootstrap-icons.css" rel="stylesheet">
   <link href="../../assets/css/boxicons.min.css" rel="stylesheet">
   <link href="../../assets/css/remixicon.css" rel="stylesheet">
   <link href="../../assets/css/simple-datatables.css" rel="stylesheet">
   <link href="../../assets/font-awesome/all.min.css" rel="stylesheet">
   <link href="../../assets/css/style.css" rel="stylesheet">

</head>
<body>
   <header id="header" class="header fixed-top d-flex align-items-center">
      <div class="d-flex align-items-center justify-content-between"> 
         <a href="prof.php" class="logo d-flex align-items-center"> 
            <img src="../../assets/image/LOGO.png" alt=""> 
            <span class="d-none d-lg-block">Professor</span> 
         </a> 
         <i class="bi bi-list toggle-sidebar-btn"></i>
      </div>
      
      <nav class="header-nav ms-auto">
         <ul class="d-flex align-items-center">
            <li class="nav-item dropdown pe-3">
               <?php
               $id = $_SESSION['user_id'];
               $query = "SELECT * FROM tbl_users WHERE id ='$id'";
               $result = mysqli_query($conn,$query);
               if($result){
                  if(mysqli_num_rows($result) > 0){
                     while($row = mysqli_fetch_assoc($result)){
               ?>
               <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown"> 
                  <img src="../../assets/image-profile/<?php echo $row['image']; ?>" alt="Profile" class="rounded-circle"> 
                  <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $row['email']?></span> 
               </a>
               
               <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                  <li class="dropdown-header">
                     <h6><?php echo $row['email']?></h6>
                     <span><?php echo $row['role']?></span>
                  </li>

                  <li><hr class="dropdown-divider"></li>
                    
                  <li> 
                     <a class="dropdown-item d-flex align-items-center" href="../profile/prof-profile.php"> 
                        <i class="bi bi-person"></i> 
                        <span>My Profile</span> 
                     </a>
                  </li>

                  <li><hr class="dropdown-divider"></li>
                  
                  <li> 
                     <a class="dropdown-item d-flex align-items-center" href="../../include/logout.php"> 
                        <i class="bi bi-box-arrow-right"></i> 
                        <span>Logout</span> 
                     </a>
                  </li>
               </ul>

            </li>
               <?php
                     }
                  }
               }
               ?>
         </ul>
      </nav>
   </header>
 

   <aside id="sidebar" class="sidebar">
      <ul class="sidebar-nav" id="sidebar-nav">
         <li class="nav-item"> 
            <a class="nav-link " href="prof.php"> 
               <i class="bi bi-grid"></i> 
               <span>Dashboard</span> 
            </a>
         </li>
        
         <li class="nav-item"> 
            <a class="nav-link collapsed" href="../profile/prof-profile.php"> 
               <i class="fa fa-id-card"></i> 
               <span>Profile</span> 
            </a>
         </li>
         <li class="nav-item"> 
            <a class="nav-link collapsed" href="add_notes.php"> 
               <i class="bi bi-stickies"></i> 
               <span>Notes</span> 
            </a>
         </li>
         <li class="nav-item">
                <a class="nav-link collapsed" href="../classroom/add_task.php">
                    <i class="bi bi-bell"></i>
                    <span>Task Reminders</span>
                </a>
         </li>
         <li class="nav-item"> 
            <a class="nav-link collapsed" href="../classroom/prof-myClass.php"> 
               <i class="ri-file-list-3-fill"></i> 
               <span>My Class</span> 
            </a>
         </li>
        

         <li class="nav-item"> 
            <a class="nav-link collapsed" href="../../include/logout.php"> 
               <i class="fa fa-power-off"></i> 
               <span>Logout</span> 
            </a>
         </li>
      </ul>
   </aside>


   <main id="main" class="main">
      <div class="pagetitle">
         <nav>
            <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="prof.php">Home</a></li>
               <li class="breadcrumb-item active">Dashboard</li>
            </ol>
         </nav>
      </div>
      
      <!-- PROFESSOR SCREEN SECTION -->
      <section class="section dashboard">
         <div class="row">
            <div class="col-lg-12">
                 
               <div class="row">

                  <div class="col-xxl-3 col-md-6">

                     <div class="card info-card student-card">
                        <div class="card-body">
                           <h5 class="card-title">Students</h5>
                           <div class="d-flex align-items-center">
                              <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"> 
                                 <i class="fa fa-user-graduate"></i>
                              </div>
                              
                              <div class="ps-3">
                                 <?php
                                 $id = $_SESSION['user_id']; 
                                 $sql = "SELECT * FROM tbl_professor p 
                                          JOIN tbl_student s ON s.advisory_id = p.id WHERE p.prof_id ='$id'";
                                 $query = mysqli_query($conn,$sql);
                                 if($total = mysqli_num_rows($query)){
                                    echo '<h6>'.$total.'</h6>';
                                 } else {
                                    echo '<h6> No Data </h6>';
                                 }
                                 ?>
                              </div>
                           </div>
                        </div>
                     </div>

                  </div>
                  
                  <div class="col-xxl-3 col-md-6">
                     
                     <div class="card info-card professor-card">
                        <div class="card-body">
                           <h5 class="card-title">Subject</h5>
                           <div class="d-flex align-items-center">
                              <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"> 
                                 <i class="fa fa-book"></i>
                              </div>
                                
                              <div class="ps-3">
                                 <?php
                                 $id = $_SESSION['user_id'];
                                 $sql = "SELECT * FROM tbl_professor p JOIN tbl_subjects s ON s.id = p.subject_id WHERE p.prof_id = '$id'";
                                 $query = mysqli_query($conn,$sql);
                                 if($total = mysqli_num_rows($query)){
                                    echo '<h6>'.$total.'</h6>';
                                 } else {
                                    echo '<h6> No Data </h6>';
                                 }
                                 ?>
                              </div>
                           </div>
                        </div>
                     </div>

                  </div>
                    
                  <div class="col-xxl-3 col-xl-12">
                       
                     <div class="card info-card admin-card">
                        <div class="card-body">
                           <h5 class="card-title">My Class</h5>
                           <div class="d-flex align-items-center">
                              <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"> 
                                 <i class="ri-file-text-fill"></i>
                              </div>
                                
                              <div class="ps-3">
                                 <?php
                                 $id = $_SESSION['user_id'];
                                 $sql = "SELECT * FROM tbl_professor p JOIN tbl_class c ON c.id = p.class_id WHERE p.prof_id='$id'";
                                 $query = mysqli_query($conn,$sql);
                                 if($total = mysqli_num_rows($query)){
                                    echo '<h6>'.$total.'</h6>';
                                 } else {
                                    echo '<h6> No Data </h6>';
                                 }
                                 ?>
                              </div>
                           </div>
                        </div>
                     </div>

                  </div>
                    
                  <div class="col-xxl-3 col-xl-12">
                     
                     <div class="card info-card student-card">
                        <div class="card-body">
                           <h5 class="card-title">Result</h5>
                           <div class="d-flex align-items-center">
                              <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"> 
                                 <i class="ri-file-text-fill"></i>
                              </div>
                              
                              <div class="ps-3">
                                 <?php
                                 $id = $_SESSION['user_id'];
                                 $sql = "SELECT * FROM tbl_result r 
                                          JOIN tbl_student s ON r.student_id = s.id 
                                          JOIN tbl_professor p ON p.id = s.advisory_id WHERE p.prof_id='$id'";
                                 $query = mysqli_query($conn,$sql);
                                 if($total = mysqli_num_rows($query)){
                                    echo '<h6>'.$total.'</h6>';
                                 } else {
                                    echo '<h6> No Data </h6>';
                                 }
                                 ?>
                              </div>
                           </div>
                        </div>
                     </div>

                  </div>

               </div>

            </div>
         </div>
      </section>
      <!-- Add Note Modal -->
<div class="modal fade" id="addNoteModal" tabindex="-1" aria-labelledby="addNoteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNoteLabel">Add a Note</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="../../include/server.php" method="POST">
                    <div class="mb-3">
                        <label for="class" class="form-label">Class</label>
                        <select name="class_id" class="form-select" required>
                            <option value="" disabled selected>Select Class</option>
                            <?php
                            $sql = "SELECT * FROM tbl_class";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='{$row['id']}'>{$row['course']} - {$row['year']} - {$row['section']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="student" class="form-label">Student</label>
                        <select name="student_id" class="form-select" required>
                            <option value="" disabled selected>Select Student</option>
                            <?php
                            $sql = "SELECT * FROM tbl_student";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='{$row['id']}'>{$row['lname']}, {$row['fname']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="note_text" class="form-label">Note</label>
                        <textarea name="note_text" class="form-control" rows="4" required></textarea>
                    </div>
                    <button type="submit" name="add_note" class="btn btn-primary">Add Note</button>
                </form>
            </div>
        </div>
    </div>
</div>

   </main>


   <footer id="footer" class="footer">
      <?php
      $sql = "SELECT * FROM tbl_sy";
      $query = mysqli_query($conn,$sql);
      while($row = mysqli_fetch_assoc($query)){
      ?> 
      <div class="col-12">
         <div class="card">
            <div class="card-body">
               
               <div class="col-md-5"> 
                  <div class="bd-callout bd-callout-info">
                     <h4> Welcome <?php echo $_SESSION['profs'] ?>!</h4>
                     <h5><b>Academic Year: <?php echo $row['school_year'] ?></b></h5>
                  </div>
               </div>     
            </div>
         </div>
      </div>
      <?php
         }
      ?>
   </footer>

   <a href="#" class="back-to-top d-flex align-items-center justify-content-center">
      <i class="bi bi-arrow-up-short"></i>
   </a>
     
   <script src="../../assets/js/bootstrap.bundle.min.js"></script>
   <script src="../../assets/js/chart.min.js"></script>
   <script src="../../assets/js/echarts.min.js"></script>
   <script src="../../assets/js/simple-datatables.js"></script>
   <script src="../../assets/js/main.js"></script>
            
</body>
</html>