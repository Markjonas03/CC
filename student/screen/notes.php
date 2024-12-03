<?php
include '../../include/config.php';
include '../../include/server.php';

if (!isset($_SESSION['student_name']) && !isset($_SESSION['user_stud'])) {
    header('Location: ../../login.php');
}
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
                           <img src="../../assets/image-profile/<?php echo $row['image']; ?>" alt="Profile" class="rounded-circle">
                           <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $row['email'] ?></span>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                           <li class="dropdown-header">
                              <h6><?php echo $row['email'] ?></h6>
                              <span><?php echo $row['role'] ?></span>
                           </li>

                           <li><hr class="dropdown-divider"></li>

                           <li>
                              <a class="dropdown-item d-flex align-items-center" href="student.php">
                                 <i class="bi bi-person"></i>
                                 <span>My Profile</span>
                              </a>
                           </li>

                           <li><hr class="dropdown-divider"></li>

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

   <aside id="sidebar" class="sidebar">
      <ul class="sidebar-nav" id="sidebar-nav">
         <li class="nav-item">
            <a class="nav-link collapsed" href="student.php">
               <i class="fa fa-id-card"></i>
               <span>Profile</span>
            </a>
         </li>

         <li class="nav-item">
            <a class="nav-link collapsed" href="student-result.php">
               <i class="bi-info-circle-fill"></i>
               <span>Result</span>
            </a>
         </li>

        <!-- Sidebar Section -->
        <aside id="sidebar" class="sidebar">
            <ul class="sidebar-nav" id="sidebar-nav">

                <!-- Profile Link -->
                <li class="nav-item">
                    <a class="nav-link collapsed" href="student.php">
                        <i class="fa fa-id-card"></i>
                        <span>Profile</span>
                    </a>
                </li>

                <!-- Result Link -->
                <li class="nav-item">
                    <a class="nav-link collapsed " href="student-result.php">
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
                    <ul id="notes-nav" class="nav-content collapsed <?php if (basename($_SERVER['PHP_SELF']) == 'view_reminders.php' || basename($_SERVER['PHP_SELF']) == 'notes.php') { echo 'show'; } ?>" data-bs-parent="#sidebar-nav">
                        <li>
                            <a href="notes.php" class="nav-link collapsed <?php if (basename($_SERVER['PHP_SELF']) == 'notes.php') { echo 'active'; } ?>">
                            <i class="bi bi-stickies"></i><span>Notes</span>
                            </a>
                        </li>
                        <li>
                            <a href="view_reminders.php" class="nav-link collapsed<?php if (basename($_SERVER['PHP_SELF']) == 'view_reminders.php') { echo 'active'; } ?>">
                            <i class="bi bi-bell"></i><span>Reminder</span>
                            </a>
                        </li>
                        <li>
                            <a href="failedstudent.php" class="nav-link collapsed<?php if (basename($_SERVER['PHP_SELF']) == 'failedstudent.php') { echo 'active'; } ?>">
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


      </ul>
   </aside>


      </ul>
   </aside>

   <main id="main" class="main">
      <div class="pagetitle">
         <nav>
            <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="student.php">Home</a></li>
               <li class="breadcrumb-item active">Notes</li>
            </ol>
         </nav>
      </div>

      <section class="section dashboard">
        <div class="row">
                <div class="col-lg-10 m-auto">
                    <div class="card prof-subj overflow-auto">
                              <div class="card-header card-headSubj">
                                 <h4>NOTES FROM Professor</h4>
                              </div>
                              
                            <div class="card-body mt-5" id="filters">
                                    <?php
                                    $student_id = $_SESSION['user_id'];

                                    // Adjust the query to join with tbl_users
                                    $query = "SELECT n.note, u.fname, u.lname 
                                             FROM tbl_notes n 
                                             INNER JOIN tbl_users u ON n.prof_id = u.id 
                                             WHERE n.prof_id IN (SELECT id FROM tbl_users WHERE role = 'professor')";

                                    if ($stmt = $conn->prepare($query)) {
                                       $stmt->execute();
                                       $notes_result = $stmt->get_result();

                                       if ($notes_result->num_rows > 0) {
                                             while ($note = $notes_result->fetch_assoc()) {
                                                echo "<p><strong>" . htmlspecialchars($note['fname']) . " " . htmlspecialchars($note['lname']) . ":</strong> " . htmlspecialchars($note['note']) . "</p>";
                                             }
                                       } else {
                                             echo "<p>No notes available.</p>";
                                       }
                                       $stmt->close(); // Close the statement
                                    } else {
                                       echo "<p>Error preparing the query: " . htmlspecialchars($conn->error) . "</p>";
                                    }
                                    ?>
                              </div>
                  </div>
                </div>
             </div>
        </section>
        <script>
   // Retain the 'show' class and active state on the Notes dropdown
   document.addEventListener("DOMContentLoaded", function() {
      // Get the current file name
      var currentFile = "<?php echo basename($_SERVER['PHP_SELF']); ?>";

      // Check if the current page is in the Notes section
      if (currentFile === 'view-notes.php' || currentFile === 'add-note.php') {
         var notesNav = document.getElementById('notes-nav');
         var notesLink = document.querySelector('[data-bs-target="#notes-nav"]');

         // Add 'show' class to keep the dropdown open
         notesNav.classList.add('show');

         // Add 'active' class to the Notes parent link
         notesLink.classList.add('active');
      }
   });
</script>                               
   </main>

   <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

   <script src="../../assets/js/bootstrap.bundle.min.js"></script>
   <script src="../../assets/js/chart.min.js"></script>
   <script src="../../assets/js/echarts.min.js"></script>
   <script src="../../assets/js/simple-datatables.js"></script>
   <script src="../../assets/js/main.js"></script>

</body>

</html>
