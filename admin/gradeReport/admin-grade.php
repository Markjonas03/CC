<?php
   include '../../include/config.php';
   session_start();

   if(!isset($_SESSION['admin_name']) && (!isset($_SESSION['user_admin']))){
      header('Location: ../../login.php'); 
   }
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8" />
   <meta http-equiv="X-UA-Compatible" content="IE=edge" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0" />

   <title>Grade Report</title>

   <link href="../../assets/image/LOGO.png" rel="icon">

   <link href="../../assets/css/font.css" rel="stylesheet">
   <link href="../../assets/css/bootstrap.min.css" rel="stylesheet">
   <link href="../../assets/css/bootstrap-icons.css" rel="stylesheet">
   <link href="../../assets/css/boxicons.min.css" rel="stylesheet">
   <link href="../../assets/css/remixicon.css" rel="stylesheet">
   <link href="../../assets/css/simple-datatables.css" rel="stylesheet">
   <link href="../../assets/font-awesome/all.min.css" rel="stylesheet">
   <link href="../../assets/css/style.css" rel="stylesheet">
    
   <script src="../../assets/js/jquery.min.js"></script>
   <script src="../../assets/js/popper.min.js"></script>
   <script src="https://unpkg.com/@jarstone/dselect/dist/js/dselect.js"></script>
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
            <a class="nav-link " href="admin-grade.php"> 
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
            
            <ul id="users-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
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
            <a class="nav-link collapsed" data-bs-target="#maintenance-nav" data-bs-toggle="collapse" href="#"> 
               <i class="bi-gear-wide-connected"></i>
               <span>Maintenance</span>
               <i class="bi bi-chevron-down ms-auto"></i> 
            </a>
                
            <ul id="maintenance-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
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
               <li class="breadcrumb-item active">Grade Report</li>
            </ol>
         </nav>
      </div>


      <!-- ADMIN GRADE REPORT SECTION -->
      <section class="section dashboard">
         <div class="row">
            <div class="col-lg-10 m-auto">
               
               <div class="row">
                  <div class="col-12">
                        
                     <div class="card admin-users overflow-auto h-100" style="margin-bottom: 200px;">
                        <div class="card-body">
                           <h5 class="card-title">View <span>| Grade Report</span></h5>
                           
                           <div class="row mb-3">
                              <div class="col-sm-3">
                                 <select id="class" name="class" class="form-select" required="required">
                                    <option value="" selected disabled>Select Student..</option>
                                    <?php
                                       $sql = "SELECT DISTINCT lname, fname, student_id FROM tbl_student";
                                       $result = mysqli_query($conn,$sql);
                                       while($rows = mysqli_fetch_assoc($result)){
                                    ?>
                                    <option value="<?php echo $rows['student_id']?>"><?php echo "[",$rows['student_id'],"]"," ",$rows['lname']," - ",$rows['fname']?></option>
                                    <?php } ?>
                                 </select>
                              </div>
                           </div>
                              <?php include '../../include/message.php'?>
                              <table class="container">   
                              </table>

                        </div>
                     </div>

                  </div>
               </div>

            </div>
         </div>
      </section>
   </main>

      
   <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

   
   <script>
      $(document).ready(function(){
         $("#class").on('change',function(){
            var value = $(this).val();
            $.ajax({
               url:'get_stud.php',
               type:'POST',
               data: 'request=' + value,
               beforeSend:function(){
                  $(".container").html("<span>Loading...</span>");
               },
               success:function(data){
                  $(".container").html(data);
               }
            })
         });
      });

      var select =document.querySelector('#class');
      dselect(select,{
         search: true,
         size:'sm'
      });
   </script>

   <script src="../../assets/js/bootstrap.bundle.min.js"></script>
   <script src="../../assets/js/chart.min.js"></script>
   <script src="../../assets/js/echarts.min.js"></script>
   <script src="../../assets/js/simple-datatables.js"></script>
   <script src="../../assets/js/main.js"></script>
</body>
</html>