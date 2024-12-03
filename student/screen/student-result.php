<?php
    include '../../include/config.php';
    session_start();

    if(!isset($_SESSION['student_name']) && (!isset($_SESSION['user_stud']))){
        header('Location: ../../login.php'); 
    }
    $select = "SELECT * FROM tbl_sy";
    $query = mysqli_query($conn,$select);
    $row = mysqli_fetch_assoc($query);
    $_SESSION['sy'] = $row['id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Result</title>

    <link href="../../assets/image/LOGO.png" rel="icon">

    <link href="../../assets/css/font.css" rel="stylesheet">
    <link href="../../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/css/bootstrap-icons.css" rel="stylesheet">
    <link href="../../assets/css/boxicons.min.css" rel="stylesheet">
    <link href="../../assets/css/remixicon.css" rel="stylesheet">
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
                    $result = mysqli_query($conn,$query);
                    if($result){
                        if(mysqli_num_rows($result) > 0){
                            while($row = mysqli_fetch_assoc($result)){
                ?>
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown"> 
                    <img src="../../assets/image-profile/<?php echo $row['image']; ?>" alt="Profile" class="rounded-circle"> 
                    <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $_SESSION['student_name']?></span> 
                </a>
                
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6><?php echo $_SESSION['student_name']?></h6>
                        <span><?php echo $row['role']?></span>
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

                <!-- Profile Link -->
                <li class="nav-item">
                    <a class="nav-link collapsed" href="student.php">
                        <i class="fa fa-id-card"></i>
                        <span>Profile</span>
                    </a>
                </li>

                <!-- Result Link -->
                <li class="nav-item">
                    <a class="nav-link " href="student-result.php">
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
                 <li class="breadcrumb-item active">Result</li>
              </ol>
           </nav>
        </div>
        
        <!-- DASHBOARD SECTION -->
        <section class="section dashboard">
            <div class="container">
                
                <div class="row">
                    <div class="col-md-10 m-auto">

                        <div class="row">
                            <div class="col-12">
                                <?php
                                    $no = $_SESSION['stud_no'];
                                    $sy = $_SESSION['sy'];
                                    $sql = "SELECT DISTINCT fname, mname,lname, c.course, c.year, c.section, sy.school_year 
                                    FROM tbl_student s 
                                    JOIN tbl_professor p ON p.id = s.advisory_id
                                    JOIN tbl_class c ON c.id = p.class_id 
                                    JOIN tbl_sy sy ON c.sy_id = sy.id 
                                    WHERE s.student_id = '$no' && c.sy_id = '$sy'";
                                    $result = mysqli_query($conn,$sql);
                                    while($rows = mysqli_fetch_assoc($result)){
                                ?>
                                <div class="card prof-subj overflow-auto">
                                    <div class="card-body p-5">
                                        <div class="text-center d-flex justify-content-center">
                                            <img src="../../assets/image/LOGO.png" width="120px" height="120px">
                                            <div>
                                                <h5>Taguig City University</h5>
                                                <h6>General Santos Avenue, Barangay Central Bicutan, City of Taguig</h6>
                                                <h6>TAGUIG, METRO MANILA</h6>
                                                <h6>TEL NOS:  8635-8300 (7202) / 09618872644</h6>
                                                <h6>E-MAIL ADD: taguigcityuniversity072220@gmail.com</h6>
                                            </div>
                                        </div>
                                        <h4 class="text-center mt-5 fw-bold">REPORT OF GRADE</h4>
                                        <p><b>NAME OF STUDENT:</b> &nbsp; <?php echo $rows['fname']," ",$rows['mname']," ",$rows['lname']?></p>
                                        <p><b>PROGRAM:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $rows['course']?></p>
                                        <p><b>YEAR & SECTION:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $rows['year'],"-",$rows['section']?></p>    
                                        <p><b>S.Y:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $rows['school_year']?></b> </p>                         
                                <?php
                                    }
                                ?>
                                                                                                                     
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>SUBJECT CODE</th>    
                                                    <th>SUBJECT TITLE</th>
                                                    <th>UNITS</th>
                                                    <th>GRADES</th>
                                                </tr>
                                            </thead>
                                            <tbody>  
                                                <?php
                                                    $no = $_SESSION['stud_no'];
                                                    $sy = $_SESSION['sy'];
                                                    $sql = "SELECT DISTINCT subject_code, subject_name, result, units FROM tbl_professor p
                                                            JOIN tbl_student s ON s.advisory_id = p.id
                                                            JOIN tbl_subjects sub ON sub.id = p.subject_id
                                                            LEFT JOIN tbl_result r ON s.id = r.student_id
                                                            JOIN tbl_class c ON c.id = p.class_id
                                                            WHERE s.student_id = '$no' && c.sy_id ='$sy'";
                                                    $query = mysqli_query($conn,$sql);
                                                    $units = 0;
                                                    $total = 0;
                                                    $avg = null;
                                                    while($row = mysqli_fetch_assoc($query)){
                                                ?> 
                                                <tr>
                                                    <td><?php echo $row['subject_code']?></td>
                                                    <td><?php echo $row['subject_name']?></td>
                                                    <td><?php echo $row['units']?></td>
                                                    <td><?php echo $row['result']?></td>
                                                </tr>
                                                <?php   
                                                    $units += $row['units'];                                                    
                                                    $total += $row['result'];
                                                    $avg = ($total /6);                                                 
                                                    }
                                                ?>
                                                <tr>
                                                   <th></th>
                                                   <th scope="row">TOTAL OF UNITS</th>           
                                                   <td ><b><?php echo $units;?></b></td>
                                                   <th></th>
                                                </tr>
                                                <tr>
                                                   <th></th>
                                                   <th scope="row">GENERAL AVERAGE</th>
                                                   <th></th>          
                                                   <td ><b><?php echo $avg;?></b></td>
                                                </tr>
                                                <tr>
                                                   <th></th>
                                                   <th scope="row">Download Result</th>           
                                                   <td><b><a href="download-result.php" target="_blank" class="text-dark">Download </a></b></td>
                                                   <th></th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </section>

    </main>



    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
       

    <script src="../../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/js/main.js"></script> 
            
</body>
</html>