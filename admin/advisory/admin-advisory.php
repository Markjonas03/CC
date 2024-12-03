<?php
    include '../../include/config.php';
    session_start();

    if(!isset($_SESSION['admin_name']) && (!isset($_SESSION['user_admin']))){
        header('Location: ../../login.php'); 
    }
    $_SESSION['_token'] = bin2hex(random_bytes(32));
    $_SESSION['_token-expire'] = time() + 3600;


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $student_id = $_POST['student_id'];
        $class_id = $_POST['class_id'];
    
        
    }
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professor</title>

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
                            <span>Professors</span> 
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
                        <a href="../subject/admin-subject.php"> 
                            <i class="fa fa-book"></i>
                            <span>Subjects</span> 
                        </a>
                    </li>

                    <li> 
                        <a href="admin-advisory.php" class="active"> 
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
                    <li class="breadcrumb-item active">Faculty</li>
                </ol>
            </nav>
        </div>

       <!-- ADMIN ADVISORY SECTION -->
       <section class="section dashboard">
       <div class="row">
        <div class="col-lg-10 m-auto">
            <div class="row">
                <div class="col-12">
                    <div class="card school-year overflow-auto">
                        <div class="card-body mt-1">
                            <h5 class="card-title">Manage <span>| Faculty </span></h5>
                            <button class="btn btn-info btn-sm my-1 text-white d-flex align-items-center" data-bs-target="#advisory_modal" data-bs-toggle="modal">
                                <i class="bx bx-plus fs-5 me-1"></i>Add Professor</button>
                            <?php include '../../include/message.php';?>

                            <table class="table table-borderless table-striped mt-2 datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">Professor Name</th>
                                        <th scope="col">Class</th>
                                        <th scope="col">Semester</th>
                                        <th scope="col">Subject</th>
                                        <th scope="col">School Year</th> 
                                        <th scope="col">Created</th>
                                        <th scope="col">Student List</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        // Updated query to include school_year
                                        $query = "SELECT p.id, u.lname, u.fname, u.mname, c.course, c.year, c.sem, c.section, 
                                                     p.date_created, s.subject_code, s.subject_name, sy.school_year 
                                                  FROM tbl_professor p 
                                                  JOIN tbl_users u ON p.prof_id = u.id 
                                                  JOIN tbl_class c ON p.class_id = c.id 
                                                  JOIN tbl_subjects s ON p.subject_id = s.id
                                                  JOIN tbl_sy sy ON c.sy_id = sy.id"; // Make sure to join school year table
                                        $result = mysqli_query($conn, $query);
                                        if ($result) {
                                            if (mysqli_num_rows($result) > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $timestamp = $row['date_created'];
                                                    $year_mapping = [
                                                        1 => '1st',
                                                        2 => '2nd',
                                                        3 => '3rd',
                                                        4 => '4th',
                                                        5 => '5th',
                                                    ];
                                                    $formatted_class = $row['course'] . '-' . $year_mapping[$row['year']] . '-' . $row['section'];
                                                        ?>
                                                         <tr>
                                                            <th scope="row"><?php echo $row['lname'] . ", " . $row['fname'] . " " . $row['mname']; ?></th>
                                                            <td><?php echo $formatted_class; ?></td>
                                                            <td><?php echo $row['sem']; ?></td>
                                                            <td><?php echo $row['subject_code'] . " - " . $row['subject_name']; ?></td>
                                                            <td><?php echo $row['school_year']; ?></td>
                                                            <td><?php echo date('D, M d, Y g:i A', strtotime($timestamp)); ?></td>
                                                            <td>
                                                                <a href="#" class="icon-box text-info d-flex justify-content-center align-items-center" 
                                                                    data-bs-toggle="modal" 
                                                                    data-bs-target="#studentListModal<?php echo $row['id']; ?>" 
                                                                    title="View Students" 
                                                                    onclick="loadStudentList(<?php echo $row['id']; ?>)">
                                                                        <i class="fa-solid fa-eye fs-5"></i>
                                                                    </a>
                                                            </td>
                                                            <td>
                                                                <a href="#" class="text-info me-3" data-bs-target="#advisory_up_modal<?php echo $row['id']; ?>" data-bs-toggle="modal"><i class="fa-solid fa-pen-to-square fs-5" title="Edit Professor"></i></a>
                                                                <a href="#" class="text-danger" data-bs-target="#advisory_del_modal<?php echo $row['id']; ?>" data-bs-toggle="modal"><i class="fa-solid fa-trash fs-5" title="Delete Professor"></i></a>
                                                            </td>
                                                        </tr>

                                                            <!-- Student List Modal -->
                                                        <div class="modal fade" id="studentListModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="studentListModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="studentListModalLabel<?php echo $row['id']; ?>">Enrolled Students for</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <!-- Class details -->
                                                                        <div class="mb-3">
                                                                            <strong>Professor: </strong><?php echo $row['lname'] . ", " . $row['fname']; ?><br>
                                                                            <strong>Subject: </strong><?php echo $row['subject_code'] . " - " . $row['subject_name']; ?><br>
                                                                            <strong>Year-Section: </strong><?php echo $formatted_class; ?><br>
                                                                            <strong>Semester: </strong><?php echo $row['sem']; ?><br>
                                                                        </div>
                                                                        <hr>
                                                                        
                                                                        <!-- This is where the list of students will appear -->
                                                                        <div id="studentListContent<?php echo $row['id']; ?>"></div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <?php
                                                    // Include any other necessary modals, such as for updating or deleting professors
                                                    include 'admin-advisory-modal.php';
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


    <div class="modal fade" id="advisory_modal" data-bs-backdrop="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Create a new Professor.</h4>
                </div>
                
                <div class="modal-body">
                    <div class="col-md-12">
                        <form action="../../include/server.php" method="POST" class="form needs-validation" novalidate>
            
                        <div class="form-group mt-3">
                            <input type="hidden" name="_token" value="<?php echo $_SESSION['_token'];?>">
                            <label>Professor</label>
                            <select name="prof" class="form-select" required>
                                <option value="" selected disabled>Choose..</option>
                            <?php
                                $sql = "SELECT * FROM tbl_users WHERE role = 'professor'";
                                $query = mysqli_query($conn,$sql);
                                if($query){
                                    if(mysqli_num_rows($query) > 0){
                                        while($row = mysqli_fetch_array($query)){
                            ?>
                                <option value="<?php echo $row['id']?>"><?php echo $row['lname'],", ",$row['fname']," ",$row['mname']?></option>
                            <?php
                                        }
                                    }
                                }
                            ?>
                            </select>
                                <div class="valid-feedback"> Looks good!</div>
                                <div class="invalid-feedback"> Please choose Professor!</div>
                        </div>

                        <div class="form-group mt-3">
                            <label>Class</label>
                           <select name="class" class="form-select" required onchange="loadStudents(this.value)">
                                <option value="" selected disabled>Choose..</option>
                                <?php
                                    $sql = "SELECT * FROM tbl_class";
                                    $query = mysqli_query($conn, $sql);
                                    if ($query) {
                                        if (mysqli_num_rows($query) > 0) {
                                            while ($row = mysqli_fetch_array($query)) {
                                                ?>
                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['course'] . "-" . $row['year'] . $row['section']; ?></option>
                                                <?php
                                            }
                                        }
                                    }
                                ?>
                            </select>

                                <div class="valid-feedback"> Looks good!</div>
                                <div class="invalid-feedback"> Please choose Class!</div>
                        </div>
                        <div id="studentList"></div>
                        

                          

                        <div class="form-group mt-3">
                            <label>Subject</label>
                            <select name="subject" class="form-select" required>
                                <option value="" selected disabled>Choose..</option>
                            <?php
                                $sql = "SELECT * FROM tbl_subjects";
                                $query = mysqli_query($conn,$sql);
                                if($query){
                                    if(mysqli_num_rows($query) > 0){
                                        while($row = mysqli_fetch_array($query)){
                            ?>
                                <option value="<?php echo $row['id']?>"><?php echo $row['subject_code']," - ",$row['subject_name']?></option>
                            <?php
                                        }
                                    }
                                }
                            ?>
                            </select>
                                <div class="valid-feedback"> Looks good!</div>
                                <div class="invalid-feedback"> Please choose Subject!</div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" name="add_advisory" class="btn btn-success btn-sm">Submit</button>
                    <button class="btn btn-danger btn-sm" type="button" data-bs-dismiss="modal">Cancel</button>
                        </form>
                </div>
            </div>
        </div>
    </div>
    <script>
   // Function to load the student list dynamically when the modal is triggered
   function loadStudentList(classId) {
    var contentDiv = document.getElementById('studentListContent' + classId);
    
    // Create an AJAX request
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'fetch_students.php?class_id=' + classId, true);
    xhr.onload = function() {
        if (xhr.status == 200) {
            contentDiv.innerHTML = xhr.responseText;
        } else {
            contentDiv.innerHTML = 'Failed to load student list.';
        }
    };
    xhr.send();
}

</script>



    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
     

    <script src="../../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/js/chart.min.js"></script>
    <script src="../../assets/js/echarts.min.js"></script>
    <script src="../../assets/js/simple-datatables.js"></script>
    <script src="../../assets/js/main.js"></script>
</body>
</html>