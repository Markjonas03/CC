<?php
include '../../include/config.php';
include '../../include/server.php';

if (!isset($_SESSION['prof_name']) && !isset($_SESSION['user_prof'])) {
    header('Location: ../../login.php');
    exit;
}

// Initialize CSRF token
if (empty($_SESSION['_token']) || time() > $_SESSION['_token-expire']) {
    $_SESSION['_token'] = bin2hex(random_bytes(32));
    $_SESSION['_token-expire'] = time() + 3600;
}

$prof_id = $_SESSION['user_id']; // Automatically associate with professor
$showAlert = false;
$alertType = '';
$alertMessage = '';

// Handle form submission to add a note
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['note'])) {
    // Validate CSRF token
    if (hash_equals($_SESSION['_token'], $_POST['_token'])) {
        $note = $_POST['note'];

        // Insert note into tbl_notes
        $query = "INSERT INTO tbl_notes (prof_id, note, created_at, updated_at) VALUES (?, ?, NOW(), NOW())";
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("is", $prof_id, $note);
            if ($stmt->execute()) {
                $showAlert = true;
                $alertType = 'success';
                $alertMessage = 'Note added successfully!';
            } else {
                $showAlert = true;
                $alertType = 'error';
                $alertMessage = 'Error adding note!';
            }
            $stmt->close();
        } else {
            $showAlert = true;
            $alertType = 'error';
            $alertMessage = 'Error preparing statement!';
        }
    } else {
        $showAlert = true;
        $alertType = 'error';
        $alertMessage = 'Invalid CSRF token!';
    }
}

// Handle delete note
if (isset($_GET['delete'])) {
    $note_id = $_GET['delete'];
    $delete_query = "DELETE FROM tbl_notes WHERE id = ? AND prof_id = ?";
    if ($delete_stmt = $conn->prepare($delete_query)) {
        $delete_stmt->bind_param("ii", $note_id, $prof_id);
        if ($delete_stmt->execute()) {
            $showAlert = true;
            $alertType = 'success';
            $alertMessage = 'Note deleted successfully!';
        } else {
            $showAlert = true;
            $alertType = 'error';
            $alertMessage = 'Error deleting note!';
        }
        $delete_stmt->close();
    }
}

// Retrieve professor's notes
$query_notes = "SELECT * FROM tbl_notes WHERE prof_id = ? ORDER BY created_at DESC";
$notes = [];
if ($stmt = $conn->prepare($query_notes)) {
    $stmt->bind_param("i", $prof_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $notes[] = $row;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profile</title>

    <link href="../../assets/css/font.css" rel="stylesheet">
    <link href="../../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/css/bootstrap-icons.css" rel="stylesheet">
    <link href="../../assets/css/boxicons.min.css" rel="stylesheet">
    <link href="../../assets/css/remixicon.css" rel="stylesheet">
    <link href="../../assets/css/simple-datatables.css" rel="stylesheet">
    <link href="../../assets/font-awesome/all.min.css" rel="stylesheet">
    <link href="../../assets/css/style.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert Script -->
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
                <a class="nav-link" href="add_notes.php">
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
                <a class="nav-link collapsed" href="../classroom/prof-myClass.php">
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
                    <li class="breadcrumb-item active">Add Notes</li>
                </ol>
            </nav>
        </div>

        <section class="section dashboard">
            <div class="row">
                <div class="col-lg-10 m-auto">
                    <div class="card prof-subj overflow-auto">
                        <div class="card-header card-headSubj">
                            <h3>Add Notes</h3>
                        </div>

                        <div class="card-body mt-5" id="filters">
                            <!-- Form to add notes -->
                            <form method="POST" action="">
                                <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
                                <div class="mb-3">
                                    <label for="note" class="form-label">Note</label>
                                    <textarea class="form-control" id="note" name="note" rows="3" required></textarea>
                                </div>
                                
                                <button type="submit" class="btn btn-primary">Add Note</button>
                            </form>

                            <!-- Display list of notes -->
                            <h3 class="mt-5">Your Notes</h3>
                            <ul class="list-group">
                                <?php foreach ($notes as $note): ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <?php echo $note['note']; ?>
                                        <a href="add_notes.php?delete=<?php echo $note['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
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
    <script src="../../assets/js/main.js"></script>

    <!-- SweetAlert Script Block -->
    <?php if ($showAlert): ?>
    <script>
        Swal.fire({
            icon: '<?php echo $alertType; ?>',
            title: '<?php echo $alertMessage; ?>',
            confirmButtonText: 'OK'
        }).then(function() {
            window.location = 'add_notes.php'; // Optional: Refresh the page after showing the alert
        });
    </script>
    <?php endif; ?>
</body>
</html>
