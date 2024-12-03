<?php
// Including configuration and server files
include '../../include/config.php';
include '../../include/server.php';

// Check if the user is logged in, otherwise redirect to login page
if (!isset($_SESSION['student_name']) && (!isset($_SESSION['user_stud']))) {
   header('Location: ../../login.php');
}

// Generating CSRF token for form submission security
$_SESSION['_token'] = bin2hex(random_bytes(32));
$_SESSION['_token-expire'] = time() + 3600;
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8" />
   <meta http-equiv="X-UA-Compatible" content="IE=edge" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0" />

   
   <title>Profile</title>

   
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
         <a href="student.php" class="logo d-flex align-items-center">
            <img src="../../assets/image/LOGO.png">
            <span class="d-none d-lg-block">Student</span>
         </a>
         <i class="bi bi-list toggle-sidebar-btn"></i>
      </div>

      <nav class="header-nav ms-auto">
         <ul class="d-flex align-items-center">

            <li class="nav-item dropdown pe-3">
               <?php
               $id = $_SESSION['user_id'];
               $query = "SELECT * FROM tbl_users WHERE id ='$id'";
               $result = mysqli_query($conn, $query);
               if ($result) {
                  if (mysqli_num_rows($result) > 0) {
                     while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                           <img src="../../assets/image-profile/<?php echo $row['image']; ?>" alt="Profile"
                              class="rounded-circle">
                           <span class="d-none d-md-block dropdown-toggle ps-2">
                              <?php echo $row['email']?>
                           </span>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                           <li class="dropdown-header">
                              <h6>
                                 <?php echo $row['email']?>
                              </h6>
                              <span>
                                 <?php echo $row['role']?>
                              </span>
                           </li>

                           <li>
                              <hr class="dropdown-divider">
                           </li>

                           <li>
                              <a class="dropdown-item d-flex align-items-center" href="student.php">
                                 <i class="bi bi-person"></i>
                                 <span>My Profile</span>
                              </a>
                           </li>

                           <li>
                              <hr class="dropdown-divider">
                           </li>

                           <li>
                              <a class="dropdown-item d-flex align-items-center" href="../../include/logout.php">
                                 <i class="bi bi-box-arrow-right"></i>
                                 <span>Sign Out</span>
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


  <!-- Sidebar Section -->
<!-- Sidebar Section -->
<aside id="sidebar" class="sidebar">
   <ul class="sidebar-nav" id="sidebar-nav">

      <!-- Profile Link -->
      <li class="nav-item">
         <a class="nav-link" href="student.php">
            <i class="fa fa-id-card"></i>
            <span>Profile</span>
         </a>
      </li>

      <!-- Result Link -->
      <li class="nav-item">
         <a class="nav-link collapsed" href="student-result.php">
            <i class="bi-info-circle-fill"></i>
            <span>Result</span>
         </a>
      </li>

      <li class="nav-item">
         <a class="nav-link collapsed <?php if (basename($_SERVER['PHP_SELF']) == 'view_reminders.php' || basename($_SERVER['PHP_SELF']) == 'notes.php') { echo ''; } else { echo 'collapsed'; } ?>" data-bs-target="#notes-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-stickies"></i>
            <span>Notes</span>
            <i class="bi bi-chevron-down ms-auto"></i>
         </a>
         <ul id="notes-nav" class="nav-content collapse <?php if (basename($_SERVER['PHP_SELF']) == 'view_reminders.php' || basename($_SERVER['PHP_SELF']) == 'notes.php') { echo 'show'; } ?>" data-bs-parent="#sidebar-nav">
            <li>
                <a href="notes.php" class="<?php if (basename($_SERVER['PHP_SELF']) == 'notes.php') { echo 'active'; } ?>">
                  <i class="bi bi-stickies"></i><span>Notes</span>
                </a>
            </li>
            <li>
                <a href="view_reminders.php" class="<?php if (basename($_SERVER['PHP_SELF']) == 'view_reminders.php') { echo 'active'; } ?>">
                  <i class="bi bi-bell"></i><span>Reminder</span>
                 </a>
            </li>
            <li>
                <a href="failedstudent.php" class="<?php if (basename($_SERVER['PHP_SELF']) == 'failedstudent.php') { echo 'active'; } ?>">
                  <i class="bi bi-credit-card"></i><span>Failed Subject</span>
                 </a>
            </li>
         </ul>
      </li>
      <!-- Logout Link -->
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
               <li class="breadcrumb-item"><a href="student.php">Home</a></li>
               <li class="breadcrumb-item active">Profile</li>
            </ol>
         </nav>

      </div>


      <section class="section profile">
         <div class="row">
            <div class="col-xl-4">

               <div class="card">
                  <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                     <?php
                     $id = $_SESSION['user_id'];
                     $query = "SELECT * FROM tbl_users WHERE id ='$id'";
                     $result = mysqli_query($conn, $query);
                     if ($result) {
                        if (mysqli_num_rows($result) > 0) {
                           while ($row = mysqli_fetch_assoc($result)) {
                              ?>
                              <img src="../../assets/image-profile/<?php echo $row['image']; ?>" alt="Profile"
                                 class="rounded-circle">
                              <h2>
                                 <?php echo $row['fname'] ?>
                              </h2>
                              <h3>
                                 <?php echo $row['role'] ?>
                              </h3>
                             
                           </div>
                        </div>

                     </div>

                     <div class="col-xl-8">
                        <?php include '../../include/message.php'; ?>

                        <div class="card">
                           <div class="card-body pt-3">
                              <ul class="nav nav-tabs nav-tabs-bordered">
                                 <li class="nav-item">
                                    <button class="nav-link active" data-bs-toggle="tab"
                                       data-bs-target="#profile-overview">Overview</button>
                                 </li>

                                 <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit
                                       Profile</button>
                                 </li>

                                 <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab"
                                       data-bs-target="#profile-change-password">Change Password</button>
                                 </li>
                              </ul>

                              <div class="tab-content pt-2">
                                 <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                    <h5 class="card-title">Profile Details</h5>

                                    <div class="row">
                                       <div class="col-lg-3 col-md-4 label ">Full Name</div>
                                       <div class="col-lg-9 col-md-8">
                                          <?php echo $row['fname'], " ", $row['mname'], " ", $row['lname'] ?>
                                       </div>
                                    </div>

                                    <div class="row">
                                       <div class="col-lg-3 col-md-4 label">Student ID</div>
                                       <div class="col-lg-9 col-md-8">
                                          <?php echo $row['id_no'] ?>
                                       </div>
                                    </div>

                                    <div class="row">
                                       <div class="col-lg-3 col-md-4 label">Role</div>
                                       <div class="col-lg-9 col-md-8">
                                          <?php echo $row['role'] ?>
                                       </div>
                                    </div>

                                    <div class="row">
                                       <div class="col-lg-3 col-md-4 label">Phone</div>
                                       <div class="col-lg-9 col-md-8">
                                          <?php echo $row['contact'] ?>
                                       </div>
                                    </div>

                                    <div class="row">
                                       <div class="col-lg-3 col-md-4 label">Email</div>
                                       <div class="col-lg-9 col-md-8">
                                          <?php echo $row['email'] ?>
                                       </div>
                                    </div>

                                 </div>


                                 <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                                    <form action="../../include/server.php" id="form" method="POST"
                                       enctype="multipart/form-data">
                                       <div class="row mb-3">
                                          <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile
                                             Image</label>

                                          <div class="col-md-8 col-lg-9">
                                             <?php
                                             $id = $_SESSION['user_id'];
                                             $name = $row["fname"];
                                             $image = $row["image"];
                                             ?>

                                             <img src="../../assets/image-profile/<?php echo $image; ?>" alt="Profile"
                                                title="<?php echo $image; ?>">

                                             <div class="upload pt-2">
                                                <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
                                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                                                <input type="hidden" name="name" value="<?php echo $name; ?>">
                                                <input type="file" name="image_stud" id="image" accept=".jpg, .jpeg, .png">
                                                <label for="image" class="label-img"><i class="bi bi-upload"></i> </label>
                                             </div>

                                          </div>

                                       </div>
                                    </form>


                                    <form action="../../include/server.php" method="POST">

                                       <div class="row mb-3">
                                          <label for="id_no" class="col-md-4 col-lg-3 col-form-label">Student ID</label>
                                          <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">

                                          <div class="col-md-8 col-lg-9">
                                             <input name="id_no" type="text" class="form-control" id="id_no"
                                                value="<?php echo $row['id_no'] ?>" disabled>
                                          </div>
                                       </div>

                                       <div class="row mb-3">
                                          <label for="fname" class="col-md-4 col-lg-3 col-form-label">First Name</label>
                                          <div class="col-md-8 col-lg-9">
                                             <input name="fname" type="text" class="form-control" id="fname"
                                                value="<?php echo $row['fname'] ?>" required>
                                          </div>
                                       </div>

                                       <div class="row mb-3">
                                          <label for="mname" class="col-md-4 col-lg-3 col-form-label">Middle Name</label>
                                          <div class="col-md-8 col-lg-9">
                                             <input name="mname" type="text" class="form-control" id="mname"
                                                value="<?php echo $row['mname'] ?>" required>
                                          </div>
                                       </div>

                                       <div class="row mb-3">
                                          <label for="lname" class="col-md-4 col-lg-3 col-form-label">Last Name</label>
                                          <div class="col-md-8 col-lg-9">
                                             <input name="lname" type="text" class="form-control" id="lname"
                                                value="<?php echo $row['lname'] ?>" required>
                                          </div>
                                       </div>

                                     
                                       <div class="row mb-3">
                                          <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                                          <div class="col-md-8 col-lg-9">
                                             <input name="contact" type="text" class="form-control" id="Phone"
                                                value="<?php echo $row['contact'] ?>" required>
                                          </div>
                                       </div>

                                       <div class="row mb-3">
                                          <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                          <div class="col-md-8 col-lg-9">
                                             <input name="email" type="email" class="form-control" id="Email"
                                                value="<?php echo $row['email'] ?>" required>
                                          </div>
                                       </div>

                                       <div class="text-center">
                                          <button type="submit" name="profile_stud" class="btn btn-primary">Save Changes</button>
                                       </div>

                                    </form>
                                 </div>


                                 <div class="tab-pane fade pt-3" id="profile-change-password">
                                    <form action="../../include/server.php" method="POST">

                                       <div class="row mb-3">
                                          <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current
                                             Password</label>
                                          <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
                                          <div class="col-md-8 col-lg-9">
                                             <input name="old_password" type="password" class="form-control" id="currentPassword"
                                                required>
                                          </div>
                                       </div>

                                       <div class="row mb-3">
                                          <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                                          <div class="col-md-8 col-lg-9">
                                             <input name="new_password" type="password" class="form-control" id="newPassword"
                                                required>
                                          </div>
                                       </div>

                                       <div class="row mb-3">
                                          <label for="con_Password" class="col-md-4 col-lg-3 col-form-label">Confirm
                                             Password</label>
                                          <div class="col-md-8 col-lg-9">
                                             <input name="con_password" type="password" class="form-control" id="con_Password"
                                                required>
                                          </div>
                                       </div>

                                       <div class="text-center">
                                          <button type="submit" name="changePass_stud" class="btn btn-primary">Change
                                             Password</button>
                                       </div>

                                    </form>
                                 </div>
                              </div>

                           </div>

                        </div>
                        <?php
                           }
                        }
                     }
                     ?>
            </div>

         </div>
      </section>

   </main>


   <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
         class="bi bi-arrow-up-short"></i></a>


   <script src="../../assets/js/bootstrap.bundle.min.js"></script>
   <script src="../../assets/js/chart.min.js"></script>
   <script src="../../assets/js/echarts.min.js"></script>
   <script src="../../assets/js/simple-datatables.js"></script>
   <script src="../../assets/js/main.js"></script>

   <!-- IMAGE CHANGE -->
   <script type="text/javascript">
      document.getElementById("image").onchange = function () {
         document.getElementById("form").submit();
      };
   </script>
</body>

</html>