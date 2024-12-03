<?php
   include '../../include/config.php';
   session_start();

   if(!isset($_SESSION['prof_name']) && (!isset($_SESSION['user_prof']))){
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
   <title>My Class</title>

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


</head>
<body>
<header id="header" class="header fixed-top d-flex align-items-center">
      <div class="d-flex align-items-center justify-content-between"> 
         <a href="../screen/prof.php" class="logo d-flex align-items-center"> 
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
            <a class="nav-link collapsed" href="../screen/prof.php"> 
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
            <a class="nav-link collapsed" href="../screen/add_notes.php"> 
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
            <a class="nav-link " href="prof-myClass.php"> 
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
               <li class="breadcrumb-item"><a href="../screen/prof.php">Home</a></li>
               <li class="breadcrumb-item active">My Class</li>
            </ol>
         </nav>
      </div>

      
      <!-- PROFESSOR CLASSROOM SECTION -->
      <section class="section dashboard">
         <div class="row">
            <div class="col-lg-10 m-auto">
                 
               <div class="row">
                  <div class="col-12">
                     
                     <div class="card prof-subj overflow-auto">
                        <div class="card-header card-headSubj">
                           <h1>Class Record</h1>
                        </div>
                          
                        <div class="card-body mt-3" id="filters">                             
                           <?php include '../../include/message.php';?>

                           <div class="row mb-3">
                              <div class="col-sm-3">
                                 <select id="class" name="class" class="form-select" required="required">
                                    <option value="" selected disabled>Select Class..</option>
                                    <?php
                                       $no = $_SESSION['user_id'];
                                       $sql = "SELECT p.id, p.id, c.course, c.year, c.section, s.subject_name 
                                                FROM tbl_class c 
                                                JOIN tbl_professor p ON c.id = p.class_id 
                                                JOIN tbl_subjects s ON s.id = p.subject_id 
                                                WHERE p.prof_id = '$no'";
                                       $result = mysqli_query($conn,$sql);
                                       while($rows = mysqli_fetch_assoc($result)){
                                    ?>
                                    <option value="<?php echo $rows['id']?>"><?php echo "[",$rows['course'],"-" ,$rows['year'],$rows['section'],"]"?>&nbsp;<?php echo $rows['subject_name']?></option>
                                    <?php } ?>
                                 </select>
                              </div>
                              <div class="col-sm-9">
                                 <button class="btn btn-success btn-sm my-1 text-white  d-flex align-items-center float-end me-2" data-bs-target="#add_student_modal" data-bs-toggle="modal"><i class="bx bx-plus fs-5 me-1"></i>Student</button>
                              </div>
                           </div>   

                           <table class="container mt-3">
                           </table>

                        </div>
                     </div>

                  </div>
               </div>

            </div>
           </div>

      </section>
   </main>


   <div class="modal fade" id="add_student_modal" data-bs-backdrop="false">
      <div class="modal-dialog">
         
             <div class="modal-content">
               <div class="modal-header">
                  <h4 class="modal-title">Add a new Student..</h4>
               </div>
               
               <div class="modal-body">
                  <div class="col-md-12">
                        <form action="prof-student.php" method="POST" class="form needs-validation" novalidate>
                           <div class="form-group">
                              <label>Student ID</label>
                              <input type="hidden" name="class_id" value="<?php echo $row['id']; ?>" />
                              <input class="form-control" type="text" name="id_no" placeholder="Student ID" required>
                              <div class="valid-feedback"> Looks good!</div>
                              <div class="invalid-feedback"> Please Student ID is required!</div>
                           </div>
                        </div>
                  </div>
                  <div class="modal-footer">
                        <button type="submit" name="prof-studs" class="btn btn-success btn-sm">Continue</button>
                        <button class="btn btn-danger btn-sm" type="button" data-bs-dismiss="modal">Cancel</button>
                  </form>
                  </div>
               </div>
            </div>
      </div>
   </div>


   


   <a href="#" class="back-to-top d-flex align-items-center justify-content-center">
      <i class="bi bi-arrow-up-short"></i>
   </a>
     
   <script>
      $(document).ready(function(){
         $("#class").on('change',function(){
            var value = $(this).val();
            $.ajax({
               url:'get_student.php',
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

      $(document).ready(function(){
         $("#classes").on('change', function(){
            var value = $(this).val();
            $.ajax({
               url: 'get_student.php',
               type: 'POST',
               data: 'classid=' + value,
               success: function(data){
                  $("#students").html(data);
               }
            })
         });
      });

   </script>

<script src="../../assets/js/bootstrap.bundle.min.js"></script>
   <script src="../../assets/js/chart.min.js"></script>
   <script src="../../assets/js/echarts.min.js"></script>
   <script src="../../assets/js/simple-datatables.js"></script>
   <script src="../../assets/js/main.js"></script>              
</body>
</html>