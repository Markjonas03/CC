<?php
   include '../../include/config.php';
   session_start();

   if (!isset($_SESSION['admin_name']) && (!isset($_SESSION['user_admin']))) {
       header('Location: ../../login.php'); 
   }
   $_SESSION['_token'] = bin2hex(random_bytes(32));
   $_SESSION['_token-expire'] = time() + 3600;

   // Process the form when a student is added
   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
       // Get form data
       $class_id = $_POST['class_id'];
       $id_no = $_POST['id_no'];

       // Insert the student into the database (adjust table and columns as needed)
       $query = "INSERT INTO tbl_class_students (class_id, student_id) VALUES ('$class_id', '$id_no')";
       if (mysqli_query($conn, $query)) {
           // If insertion is successful, show SweetAlert success message
           echo "<script>
                   Swal.fire({
                       icon: 'success',
                       title: 'Student Added',
                       text: 'Student has been successfully added to the class.',
                       confirmButtonText: 'Ok'
                   });
                 </script>";
       } else {
           // If insertion fails, show SweetAlert error message
           echo "<script>
                   Swal.fire({
                       icon: 'error',
                       title: 'Oops...',
                       text: 'Something went wrong, please try again.',
                       confirmButtonText: 'Ok'
                   });
                 </script>";
       }
   }
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Classes</title>

   <link href="../../assets/image/LOGO.png" rel="icon">

   <link href="../../assets/css/font.css" rel="stylesheet">
   <link href="../../assets/css/bootstrap.min.css" rel="stylesheet">
   <link href="../../assets/css/bootstrap-icons.css" rel="stylesheet">
   <link href="../../assets/css/boxicons.min.css" rel="stylesheet">
   <link href="../../assets/css/remixicon.css" rel="stylesheet">
   <link href="../../assets/css/simple-datatables.css" rel="stylesheet">
   <link href="../../assets/font-awesome/all.min.css" rel="stylesheet">
   <link href="../../assets/css/style.css" rel="stylesheet">
 
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

</head>
<body>
   <header id="header" class="header fixed-top d-flex align-items-center">
      <div class="d-flex align-items-center justify-content-between"> 
         <a href="../dashboard/admin.php" class="logo d-flex align-items-center"> 
            <img src="../../assets/image/LOGO.png" alt=""> 
            <span class="d-none d-lg-block">Admin</span> 
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
                     <a class="dropdown-item d-flex align-items-center" href="../profile/admin-profile.php"> 
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
            <a class="nav-link collapsed" href="../dashboard/admin.php"> 
               <i class="bi bi-grid"></i> 
               <span>Dashboard</span> 
            </a>
         </li>
        
         <li class="nav-item"> 
            <a class="nav-link collapsed" href="../profile/admin-profile.php"> 
               <i class="fa fa-id-card"></i> 
               <span>Profile</span> 
            </a>
         </li>
           
         <li class="nav-item"> 
            <a class="nav-link collapsed" href="../gradeReport/admin-grade.php"> 
               <i class="fa fa-envelope"></i> 
               <span>Grade Report</span> 
            </a>
         </li>
 
         <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#users-nav" data-bs-toggle="collapse" href="#"> 
               <i class="fa fa-users"></i>
               <span>Users</span>
               <i class="bi bi-chevron-down ms-auto"></i> 
            </a>
                
            <ul id="users-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
               <li> 
                  <a href="../users/admin-users-stud.php"> 
                     <i class="fa fa-user-graduate"></i>
                     <span>Students</span> 
                  </a>
               </li>
                    
               <li> 
                  <a href="../users/admin-users-prof.php"> 
                     <i class="fa fa-user-tie"></i>
                     <span>Faculty</span> 
                  </a>
               </li>
                    
               <li> 
                  <a href="../users/admin-users-ad.php"> 
                     <i class="fa fa-user-gear"></i>
                     <span>Admin</span> 
                  </a>
               </li>
                    
               <li> 
                  <a href="../users/admin-create.php"> 
                     <i class="fa fa-user-plus"></i>
                     <span>Create Account</span> 
                  </a>
               </li>
            </ul>
         </li>

         <li class="nav-item">
            <a class="nav-link " data-bs-target="#maintenance-nav" data-bs-toggle="collapse" href="#"> 
               <i class="bi-gear-wide-connected"></i>
               <span>Maintenance</span>
               <i class="bi bi-chevron-down ms-auto"></i> 
            </a>
                
            <ul id="maintenance-nav" class="nav-content collapse show" data-bs-parent="#sidebar-nav">
               <li> 
                  <a href="../sy/admin-sy.php"> 
                     <i class="fa fa-calendar-days"></i>
                     <span>School Year</span> 
                  </a>
               </li>

               <li> 
                  <a href="admin-class.php" class="active"> 
                     <i class="ri-file-list-3-fill"></i>
                     <span>Semester</span> 
                  </a>
               </li>

               <li> 
                  <a href="../subject/admin-subject.php"> 
                     <i class="fa fa-book"></i>
                     <span>Subjects</span> 
                  </a>
               </li>

               <li> 
                  <a href="../advisory/admin-advisory.php"> 
                     <i class="fa fa-user-tie"></i>
                     <span>Faculty</span> 
                  </a>
               </li>
            </ul>
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
               <li class="breadcrumb-item"><a href="../dashboard/admin.php">Home</a></li>
               <li class="breadcrumb-item">Maintenance</li>
               <li class="breadcrumb-item active">Semester</li>
           </ol>
        </nav>
     </div>

      <!-- ADMIN CLASSES SECTION -->
      <section class="section dashboard">
         <div class="row">
            <div class="col-lg-10 m-auto">
                 
               <div class="row">
                  <div class="col-12">
                       
                     <div class="card school-year overflow-auto">
                        <div class="card-body mt-1">
                           <h5 class="card-title">Manage <span>|Semester</span></h5>
                           <?php include '../../include/message.php';?>
                           <button class="btn btn-info btn-sm my-1 text-white  d-flex align-items-center" data-bs-target="#add_subj_modal" data-bs-toggle="modal">
                              <i class="bx bx-plus fs-5 me-1"></i>Class</button>
                              
                              <table class="table table-borderless table-striped mt-2 datatable">
                                 <thead>
                                    <tr>
                                       <th scope="col">Course</th>
                                       <th scope="col">Yr & Section</th>
                                       <th scope="col">Semester</th>
                                       <th scope="col">School Year</th>
                                       <th scope="col">Created</th>
                                       <th scope="col">Add Students</th>
                                       <th scope="col">Actions</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                
                                          <?php
                                             // $no = $_SESSION['user_no'];
                                             $query = "SELECT c.id, c.year, c.sem, c.section, s.school_year, c.date_created, c.course 
                                                         FROM tbl_class c 
                                                         JOIN tbl_sy s ON c.sy_id = s.id";
                                             $result = mysqli_query($conn, $query);
                                             if ($result) {
                                                   if (mysqli_num_rows($result) > 0) {
                                                      while ($row = mysqli_fetch_assoc($result)) {
                                                         $timestamp = $row['date_created'];
                                                         $sem = $row['sem'];
                                                         // Mapping year level to string representation
                                                         $year_mapping = [
                                                               1 => '1st',
                                                               2 => '2nd',
                                                               3 => '3rd',
                                                               4 => '4th',
                                                               5 => '5th',
                                                         ];
                                                         $year_level = $row['year'];
                                                         $section = $row['section'];
                                                         // Formatted year & section
                                                         $display_year_section = isset($year_mapping[$year_level]) ? $year_mapping[$year_level] . '-' . $section : $year_level . '-' . $section;
                                          ?>
                                          <tr>
                                             <th scope="row"><?php echo $row['course']?></th>
                                             <td><?php echo $display_year_section; ?></td>
                                             <td><?php echo $row['sem']?></td>
                                             <td><?php echo $row['school_year']?></td>    
                                             <td><?php echo date('D, M d, Y g:i A', strtotime($timestamp));?></td>
                                             <td>
                                                      <button class="btn btn-success btn-sm text-white" data-bs-toggle="modal" data-bs-target="#addStudentModal<?php echo $row['id']; ?>">
                                                         Add Students
                                                      </button>
                                                   </td>
                                             <td>
                                                   <a href="#" class="text-info me-3" data-bs-target="#class_up_modal<?php echo $row['id']?>" data-bs-toggle="modal">
                                                      <i class="fa-solid fa-pen-to-square fs-5" title="Edit Class"></i>
                                                   </a>
                                                   <a href="#" class="text-danger" data-bs-target="#class_del_modal<?php echo $row['id']?>" data-bs-toggle="modal">
                                                      <i class="fa-solid fa-trash fs-5" title="Delete Class"></i>
                                                   </a>
                                             </td>
                                          </tr> <!-- Add Student Modal for each Class -->
                                                <div class="modal fade" id="addStudentModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="addStudentModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
                                                <div class="modal-dialog">
                                                   <div class="modal-content">
                                                      <div class="modal-header">
                                                         <h5 class="modal-title" id="addStudentModalLabel<?php echo $row['id']; ?>">
                                                            Add Student to <?php echo $row['course'] . ' ' . $display_year_section; ?>
                                                         </h5>
                                                         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                      </div>
                                                      <div class="modal-body">
                                                         <form action="" method="POST">
                                                         <input type="hidden" name="class_id" value="<?php echo $row['id']; ?>" />
                                                            <div class="mb-3">
                                                               <label for="student_id" class="form-label">Student ID</label>
                                                               <input class="form-control" type="text" name="id_no" placeholder="Student ID" required>
                                                            </div>
                                                            <button type="submit" class="btn btn-primary">Add Student</button>
                                                         </form>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>

                                          <?php
                                                      include 'admin-class-modal.php';
                                                      }
                                                   }
                                             }
                                          ?>
                                 </tbody>
                              </table>
                        </div>
                     </div>

                  </div>
               </div>

            </div>
         </div>
      </section>
   </main>


   <div class="modal fade" id="add_subj_modal" data-bs-backdrop="false">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title">Create a new Class..</h4>
            </div>

            <div class="modal-body">
               <div class="col-md-12">
                  
               <form action="../../include/server.php" method="POST" class="form needs-validation" novalidate>
               <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
                      <div class="form-group">
                        <label for="course">Course</label>
                        <select class="form-control" name="course" id="course" required>
                              <option value="" disabled selected>Select a course</option>
                              <option value="IS">Information Systems (IS)</option>
                              <option value="CS">Computer Science (CS)</option>
                              <!-- You can add more options here if needed -->
                        </select>
                           <div class="valid-feedback"> Looks good!</div>
                           <div class="invalid-feedback"> Please Course is required!</div>
                     </div>

                     <div class="form-group mt-3">
                        <label>Year Level</label>
                        <input class="form-control" type="number" name="year" placeholder="Year Level" required>
                        <p class="mt-1 fst-italic">Eg. 1, 2, 3 etc..</p>
                           <div class="valid-feedback"> Looks good!</div>
                           <div class="invalid-feedback"> Please Year Level is required!</div>
                     </div>

                     <div class="form-group mt-3">
                        <label>Section</label>
                        <input class="form-control" type="text" name="section" placeholder="Section" required>
                        <p class="mt-1 fst-italic">Eg. A, B, C, D etc..</p>
                           <div class="valid-feedback"> Looks good!</div>
                           <div class="invalid-feedback"> Please Section is required!</div>
                     </div>

                     <div class="form-group mt-3">
                        <label>Select Semester</label>
                        <select name="sem" class="form-select" required>
                           <option value="" selected disabled>Choose..</option>
                           <option>First Semester</option>
                           <option>Second Semester</option>
                           <option>Summer</option>
                        </select>
                           <div class="valid-feedback"> Looks good!</div>
                           <div class="invalid-feedback"> Please choose semester!</div>
                     </div>

                     <div class="form-group mt-3">
                        <label>School Year</label>
                        <select name="sy" class="form-select" required>
                           <option value="" selected disabled>Choose..</option>
                           <?php
                              $sql = "SELECT * FROM tbl_sy";
                              $query = mysqli_query($conn,$sql);
                              if($query){
                                 if(mysqli_num_rows($query) > 0){
                                    while($row = mysqli_fetch_array($query)){
                           ?>
                           <option value="<?php echo $row['id']?>"><?php echo $row['school_year']?></option>
                           <?php
                                 }
                              }
                           }
                           ?>
                        </select>
                           <div class="valid-feedback"> Looks good!</div>
                           <div class="invalid-feedback"> Please choose semester!</div>
                     </div>
                                          
               </div>
            </div>

            <div class="modal-footer">
               <button type="submit" name="admin-createClass" class="btn btn-success btn-sm">Submit</button>
               <button class="btn btn-danger btn-sm" type="button" data-bs-dismiss="modal">Cancel</button>
                  </form>
            </div>
         </div>
      </div>
   </div>


   <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
     
     
   <script src="../../assets/js/bootstrap.bundle.min.js"></script>
   <script src="../../assets/js/chart.min.js"></script>
   <script src="../../assets/js/echarts.min.js"></script>
   <script src="../../assets/js/simple-datatables.js"></script>
   <script src="../../assets/js/main.js"></script>
</body>
</html>