<?php
    include '../../include/config.php';
    include '../../include/server.php';

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

    <title>Users | Create Account</title>

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
                <a class="nav-link" data-bs-target="#users-nav" data-bs-toggle="collapse" href="#"> 
                    <i class="fa fa-users"></i>
                    <span>Users</span>
                    <i class="bi bi-chevron-down ms-auto"></i> 
                </a>
                
                <ul id="users-nav" class="nav-content collapse show" data-bs-parent="#sidebar-nav">
                    <li> 
                        <a href="admin-users-stud.php"> 
                            <i class="fa fa-user-graduate"></i>
                            <span>Students</span> 
                        </a>
                    </li>
                    
                    <li> 
                        <a href="admin-users-prof.php"> 
                            <i class="fa fa-user-tie"></i>
                            <span>Faculty</span> 
                        </a>
                    </li>
                    
                    <li> 
                        <a href="admin-users-ad.php"> 
                            <i class="fa fa-user-gear"></i>
                            <span>Admin</span> 
                        </a>
                    </li>
                    
                    <li> 
                        <a href="admin-create.php" class="active"> 
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
            <h1>Users</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../dashboard/admin.php">Home</a></li>
                    <li class="breadcrumb-item">Users</li>
                    <li class="breadcrumb-item active">Create Account</li>
                </ol>
            </nav>
        </div>


        <!-- ADMIN CREATE ACCOUNT SECTION -->
        <section class="section dashboard">
    <div class="row">
        <div class="col-lg-7 m-auto">
            <div class="row">
                <div class="col-12">
                    <div class="card admin-users overflow-auto">
                        <div class="card-body">
                            <h5 class="card-title">Create <span>| Account</span></h5>
                            <?php include '../../include/message.php' ?>

                            <form action="../../include/server.php" class="form needs-validation" method="POST" novalidate>
                                <div class="row">
                                    <div class="col-sm-6 mt-3">
                                        <h5 class="form-title">Account Info</h5>

                                        <div class="form-group mt-3">
                                            <label>ID Number</label>
                                            <input class="form-control" type="text" name="id_no" placeholder="ID Number" required>
                                            <div class="valid-feedback"> Looks good!</div>
                                            <div class="invalid-feedback"> Please ID no. is required!</div>
                                        </div>

                                        <div class="form-group mt-3">
                                            <label>Password</label>
                                            <input class="form-control" type="password" name="pass" placeholder="Password" required>
                                            <div class="valid-feedback"> Looks good!</div>
                                            <div class="invalid-feedback"> Please Password is required!</div>
                                        </div>

                                        <div class="form-group mt-3">
                                            <label>Confirm Password</label>
                                            <input class="form-control" type="password" name="con_pass" placeholder="Confirm Password">
                                            <div class="valid-feedback"> Looks good!</div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 mt-3">
                                        <h5 class="form-title">Personal Info</h5>

                                        <div class="form-group mt-3">
                                            <label>First Name</label>
                                            <input class="form-control" type="text" name="fname" placeholder="First Name" required>
                                            <div class="valid-feedback"> Looks good!</div>
                                            <div class="invalid-feedback"> Please First Name is required!</div>
                                        </div>

                                        <div class="form-group mt-3">
                                            <label>Middle Name</label>
                                            <input class="form-control" type="text" name="mname" placeholder="Middle Name">
                                            <div class="valid-feedback"> Looks good!</div>
                                        </div>

                                        <div class="form-group mt-3">
                                            <label>Last Name</label>
                                            <input class="form-control" type="text" name="lname" placeholder="Last Name" required>
                                            <div class="valid-feedback"> Looks good!</div>
                                            <div class="invalid-feedback"> Please Last Name is required!</div>
                                        </div>

                                        <div class="form-group mt-3">
                                            <label>Email</label>
                                            <input class="form-control" type="email" name="email" placeholder="Email Address" required>
                                            <div class="valid-feedback"> Looks good!</div>
                                            <div class="invalid-feedback"> Please Email Address is required!</div>
                                        </div>

                                        <div class="form-group mt-3">
                                            <label>Contact</label>
                                            <input class="form-control" type="number" name="contact" placeholder="+63-2-XXXXXXX" required>
                                            <div class="valid-feedback"> Looks good!</div>
                                            <div class="invalid-feedback"> Please Contact no. is required!</div>
                                        </div>

                                        <div class="form-group mt-3">
                                            <label>Role</label>
                                            <select name="role" class="form-select" required>
                                                <option selected disabled value="">Role</option>
                                                <option>student</option>
                                                <option>Faculty</option>
                                                <option>admin</option>
                                            </select>
                                            <div class="valid-feedback"> Looks good!</div>
                                            <div class="invalid-feedback"> Please Role is required!</div>
                                        </div>  

                                    
                                    </div>
                                </div>
                                
                                <div class="row mt-4 mb-3">
                                    <div class="col d-flex justify-content-between">
                                        <a href="../dashboard/admin.php">Go Back</a>
                                        <input class="btn btn-success btn-sm" type="submit" name="admin-submit" value="Submit">
                                    </div>
                                </div>
                            </form>

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
    <script src="../../assets/js/chart.min.js"></script>
    <script src="../../assets/js/echarts.min.js"></script>
    <script src="../../assets/js/simple-datatables.js"></script>
    <script src="../../assets/js/main.js"></script>
</body>
</html>