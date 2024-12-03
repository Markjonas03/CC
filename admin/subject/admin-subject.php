<?php
    include '../../include/config.php';
    session_start();

    if(!isset($_SESSION['admin_name']) && (!isset($_SESSION['user_admin']))){
        header('Location: ../../login.php'); 
    }
    $_SESSION['_token'] = bin2hex(random_bytes(32));
    $_SESSION['_token-expire'] = time() + 3600;
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Subjects</title>

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
                  <a href="../classes/admin-class.php"> 
                     <i class="ri-file-list-3-fill"></i>
                     <span>Semester</span> 
                  </a>
               </li>
                    
               <li> 
                  <a href="admin-subject.php" class="active"> 
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
                 <li class="breadcrumb-item active">Subjects</li>
              </ol>
           </nav>
        </div>

      <!-- ADMIN SUBJECT SECTION -->
      <section class="section dashboard">
         <div class="row">
            <div class="col-lg-10 m-auto">

                  <div class="row">
                     <div class="col-12">

                        <div class="card school-year overflow-auto">
                           <div class="card-body mt-1">
                              <h5 class="card-title">Manage <span>| Subject</span></h5>
                              <button class="btn btn-info btn-sm my-1 text-white  d-flex align-items-center" data-bs-target="#add_subj_modal" data-bs-toggle="modal">
                                 <i class="bx bx-plus fs-5 me-1"></i>Subject</button>
                              <?php include '../../include/message.php';?>
                              
                              <table class="table table-borderless table-striped mt-2 datatable">
                                 <thead>
                                    <tr>
                                       <th scope="col">Code</th>
                                       <th scope="col">Name</th>
                                       <th scope="col">Units</th>
                                       <th scope="col">Created</th>
                                       <th scope="col">Actions</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php
                                        $query = "SELECT * FROM tbl_subjects";
                                        $result = mysqli_query($conn,$query);
                                          if($result){
                                            if(mysqli_num_rows($result) > 0){
                                                while($row = mysqli_fetch_assoc($result)){
                                                   $timestamp = $row['date_created'];
                                    ?>
                                    <tr>
                                        <th scope="row"><?php echo $row['subject_code']?></th>
                                        <td><?php echo $row['subject_name']?></td>
                                        <td><?php echo $row['units']?></td>
                                        <td><?php echo date('D, M d, Y g:i A', strtotime($timestamp));?></td>
                                        <td>
                                            <a href="#" class="text-info me-3" data-bs-target="#subj_up_modal<?php echo $row['id']?>" data-bs-toggle="modal"><i class="fa-solid fa-pen-to-square fs-5" title="Edit Subject"></i></a>
                                            <a href="#" class="text-danger" data-bs-target="#subj_del_modal<?php echo $row['id']?>" data-bs-toggle="modal"><i class="fa-solid fa-trash fs-5" title="Delete Subject"></i></a>
                                        </td>
                                    </tr>
                                    <?php
                                          include 'admin-subj-modal.php';
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
               <h4 class="modal-title">Create a new Subject..</h4>
            </div>

            <div class="modal-body">
               <div class="col-md-12">

                  <form action="../../include/server.php" method="POST" class="form needs-validation" novalidate>
                     <div class="form-group">
                        <label>Subject Code</label>
                        <input type="hidden" name="_token" value="<?php echo $_SESSION['_token'];?>">
                        <input class="form-control" type="text" name="subject_code" placeholder="Subject Code" required>
                           <div class="valid-feedback"> Looks good!</div>
                           <div class="invalid-feedback"> Please Subject Code is required!</div>
                     </div>

                     <div class="form-group mt-3">
                        <label>Subject Name</label>
                        <input class="form-control" type="text" name="subject_name" placeholder="Subject Name" required>
                           <div class="valid-feedback"> Looks good!</div>
                           <div class="invalid-feedback"> Please Subject Name is required!</div>
                     </div>

                     <div class="form-group mt-3">
                        <label>Units</label>
                        <input class="form-control" type="number" name="unit" placeholder="Units" required>
                           <div class="valid-feedback"> Looks good!</div>
                           <div class="invalid-feedback"> Please Units is required!</div>
                     </div>
               </div>
            </div>

            <div class="modal-footer">
               <button type="submit" name="add_subj" class="btn btn-success btn-sm">Submit</button>
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