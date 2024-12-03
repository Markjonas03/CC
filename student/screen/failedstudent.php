<?php
include '../../include/config.php';
include '../../include/server.php';

if (!isset($_SESSION['student_name']) && !isset($_SESSION['user_stud'])) {
    header('Location: ../../login.php');
    exit();
}

$no = $_SESSION['stud_no'];  // Get student ID from session
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Failed Subjects</title>
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
                    $result = mysqli_query($conn, $query);
                    if ($result && mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
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
                            <a class="dropdown-item d-flex align-items-center" href="prof-profile.php">
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
                <?php } ?>
            </ul>
        </nav>
    </header>

    <aside id="sidebar" class="sidebar">
      <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
            <a class="nav-link collapsed " href="student.php">
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



    <main id="main" class="main">
        <div class="pagetitle">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="student.php">Home</a></li>
                    <li class="breadcrumb-item active">Failed Subjects</li>
                </ol>
            </nav>
        </div>

        <section class="section dashboard">
            <div class="row">
                <div class="col-lg-10 m-auto">
                    <div class="card">
                        <div class="card-header">
                            <h3>Failed Subjects</h3>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>SUBJECT Name</th>
                                        <th>UNITS</th>
                                        <th>Fee</th>
                                    </tr>
                                </thead>
                                <tbody>  
                                    <?php
                                       $sql = "SELECT DISTINCT 
                                       sub.subject_name, 
                                       sub.units, 
                                       r.result
                                   FROM 
                                       tbl_professor p
                                   JOIN 
                                       tbl_student s ON s.advisory_id = p.id
                                   JOIN 
                                       tbl_subjects sub ON sub.id = p.subject_id
                                   LEFT JOIN 
                                       tbl_result r ON s.id = r.student_id 
                                   WHERE 
                                       s.student_id = '$no' AND (r.result = 'Failed' OR r.result = 5.00)";  // Check both conditions
                           
                           // Execute the query
                           $query = mysqli_query($conn, $sql);
                           $total_fee = 0;  // Initialize total fee accumulator
                           
                           // Loop through the query result
                           while ($row = mysqli_fetch_assoc($query)) {
                               // Calculate the fee by multiplying units by 250 per unit
                               $fee = $row['units'] * 250;
                               $total_fee += $fee;  // Accumulate total fee
                           ?>
                           <tr>
                               <td><?php echo $row['subject_name']; ?></td>
                               <td><?php echo $row['units']; ?></td>
                               <td><?php echo '₱' . number_format($fee, 2); ?></td>  <!-- Display fee with formatting -->
                           </tr>
                           <?php
                           }
                           ?>
                           <tr>
                               <th colspan="2">Total Fee</th>
                               <td><b>₱<?php echo number_format($total_fee, 2); ?></b></td>
                           </tr>
                                </tbody>
                            </table>

                            <h6>Total Fee for Re-Enrollment: ₱<?php echo number_format($total_fee, 2); ?></h6>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script src="../../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/js/chart.min.js"></script>
    <script src="../../assets/js/echarts.min.js"></script>
    <script src="../../assets/js/simple-datatables.js"></script>
    <script src="../../assets/js/main.js"></script>
</body>
</html>
