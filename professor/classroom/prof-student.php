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
   <title>Add Student</title>

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
            <a class="nav-link " href="../classroom/prof-myClass.php"> 
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
               <li class="breadcrumb-item">My Class</li>
               <li class="breadcrumb-item active">Add Student</li>
            </ol>
         </nav>
      </div>

      <!-- PROFESSOR ADD STUDENT SECTION -->
      <section class="section dashboard">
         <div class="row">
            <div class="col-lg-10 m-auto">
                 
               <div class="row">
                  <div class="col-4 m-auto">
                     
                     <div class="card info-card overflow-auto">
                        <div class="card-body mt-3">
                           <?php include '../../include/message.php';?>
                           <?php
                              if(isset($_POST['prof-studs'])){
                                 $ids = $_POST['id_no'];
                                 
                                 if(empty($ids)){
                                    exit("Student ID is required!");
                                 } else {
                                    $sql = "SELECT * FROM tbl_users WHERE id_no ='$ids' && role ='student'";
                                    $query = mysqli_query($conn,$sql);
                                    if($query){
                                       if(mysqli_num_rows($query) > 0){
                                          while($row2 = mysqli_fetch_array($query)){
                           ?>
                           <form action="../../include/server.php" method="POST" class="form needs-validation" novalidate>
                              <input type="hidden" name="_token" value="<?php echo $_SESSION['_token'];?>">
                              <div class="form-group mt-3">
                                 <label>Select Class</label>
                                 <select name="class" class="form-select" required>
                                    <option value="" selected disabled>Choose..</option>
                                    <?php
                                       $no = $_SESSION['user_id'];
                                       $sql = "SELECT p.id, c.course, c.year, c.section, subj.subject_code, subj.subject_name
                                                FROM tbl_professor p
                                                JOIN tbl_class c ON p.class_id = c.id 
                                                JOIN tbl_subjects subj ON p.subject_id = subj.id 
                                                WHERE p.prof_id = '$no'";
                                       $query = mysqli_query($conn,$sql);
                                       if($query){
                                          if(mysqli_num_rows($query) > 0){
                                             while($row = mysqli_fetch_array($query)){
                                    ?>
                                    <option value="<?php echo $row['id']?>"><?php echo "[",$row['course'],"-",$row['year'],$row['section'],"]"?>&nbsp;<?php echo $row['subject_code'],"-",$row['subject_name']?></option>
                                    <?php
                                          }
                                       }
                                    }
                                    ?>
                                 </select>
                                    <div class="valid-feedback"> Looks good!</div>
                                    <div class="invalid-feedback"> Please Class is required!</div>
                              </div>

                              <div class="form-group mt-3">
                                 <input class="form-control" type="hidden" name="id_no" value="<?php echo $row2['id_no']?>">
                                 <input class="form-control" type="text" name="lname" value="<?php echo $row2['lname']?>">
                              </div>

                              <div class="form-group mt-3">
                                 <input class="form-control" type="text" name="fname" value="<?php echo $row2['fname']?>">
                              </div>

                              <div class="form-group mt-3">
                                 <input class="form-control" type="text" name="mname" value="<?php echo $row2['mname']?>">
                              </div>
                              

                              <input type="submit" name="prof-addStud" class="btn btn-success btn-sm mt-3 float-end" value="Submit">
                           </form>
                           <?php           
                                       }
                                    } else {                  
                                       exit("Student ID not found!..");
                                    }
                                 }
                              }
                           }
                           ?>
                        </div>
                     </div>
                    
                  </div>
               </div>
              
            </div>
         </div>
      </section>
   </main>


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