<?php
ob_start(); // Start output buffering
include '../../include/config.php';
include '../../include/server.php';

// Check if the professor is logged in
if (!isset($_SESSION['prof_name']) && !isset($_SESSION['user_prof'])) {
    header('Location: ../../login.php');
    exit; // Ensure exit after header to stop execution
}

$_SESSION['_token'] = bin2hex(random_bytes(32));
$_SESSION['_token-expire'] = time() + 3600;

$prof_id = $_SESSION['user_id']; // Automatically associate with professor

// Handle form submission for the task reminder
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['task'])) {
    $task = $_POST['task'];
    $task_date = $_POST['task_date'];
    $task_time = $_POST['task_time'];
    $deadline = $_POST['deadline'];
    $subject_id = $_POST['subject_id']; // Get the selected subject_id

    // Insert task into the database (tbl_tasks)
    $query = "INSERT INTO tbl_tasks (prof_id, task, task_date, task_time, deadline, subject_id, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("issssi", $prof_id, $task, $task_date, $task_time, $deadline, $subject_id);
        if ($stmt->execute()) {
            $_SESSION['success_message'] = 'Task added successfully!';
        } else {
            $_SESSION['success_message'] = 'Error adding task.';
        }
        $stmt->close();
    } else {
        $_SESSION['success_message'] = 'Error preparing statement.';
    }
    header('Location: add_task.php'); // Redirect to avoid form resubmission
    exit;
}


// Handle deletion of a task
if (isset($_GET['delete'])) {
    $task_id = $_GET['delete'];

    // Delete the task from the database
    $delete_query = "DELETE FROM tbl_tasks WHERE id = ? AND prof_id = ?";
    if ($delete_stmt = $conn->prepare($delete_query)) {
        $delete_stmt->bind_param("ii", $task_id, $prof_id);
        if ($delete_stmt->execute()) {
            $_SESSION['success_message'] = 'Task deleted successfully!';
        } else {
            $_SESSION['success_message'] = 'Error deleting task.';
        }
        $delete_stmt->close();
    } else {
        $_SESSION['success_message'] = 'Error preparing delete statement.';
    }
    header('Location: add_task.php'); // Redirect to avoid query string exposure
    exit; // Ensure exit after header redirect
}

// Retrieve the professor's tasks
// Retrieve the professor's tasks with subject names
$query_tasks = "SELECT t.*, s.subject_name FROM tbl_tasks t
                JOIN tbl_subjects s ON t.subject_id = s.id
                WHERE t.prof_id = ? ORDER BY t.task_date ASC, t.task_time ASC";
$tasks = [];
if ($stmt = $conn->prepare($query_tasks)) {
    $stmt->bind_param("i", $prof_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $tasks[] = $row;
    }
    $stmt->close();
}

ob_end_flush(); // Flush output buffer and turn off output buffering
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Task Reminder</title>

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
                <a class="nav-link" href="add_task.php">
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
                    <li class="breadcrumb-item active">Task Reminders</li>
                </ol>
            </nav>
        </div>

        <section class="section dashboard">
            <div class="row">
                <div class="col-lg-10 m-auto">
                    <div class="card prof-subj overflow-auto">
                        <div class="card-header card-headSubj">
                            <h3>Add Task Reminder</h3>
                        </div>
                        
                        <div class="card-body mt-5" id="filters">
                            <!-- Form to add task reminders -->
                            <form method="POST" action="">
                                <div class="mb-3">
                                    <label for="task" class="form-label">Task</label>
                                    <input type="text" class="form-control" name="task" required />
                                </div>

                                <div class="mb-3">
                                    <label for="subject" class="form-label">Subject</label>
                                    <select class="form-control" name="subject_id" required>
                                        <option value="">Select Subject</option>
                                        <?php
                                        // Fetch subjects from the database
                                        $subject_query = "SELECT * FROM tbl_subjects";
                                        $subject_result = mysqli_query($conn, $subject_query);
                                        while ($subject = mysqli_fetch_assoc($subject_result)) {
                                            echo "<option value='" . $subject['id'] . "'>" . $subject['subject_name'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="task_date" class="form-label">Task Date</label>
                                    <input type="date" class="form-control" name="task_date" required />
                                </div>

                                

                                <div class="mb-3">
                                    <label for="deadline" class="form-label">Deadline</label>
                                    <input type="date" class="form-control" name="deadline" required />
                                </div>

                                <div class="mb-3">
                                    <label for="task_time" class="form-label">Task Time</label>
                                    <input type="time" class="form-control" name="task_time" required />
                                </div>

                                <button type="submit" class="btn btn-primary">Add Task</button>
                            </form>
                        </div>
                    </div>

                    <div class="card prof-subj overflow-auto mt-5">
                        <div class="card-header card-headSubj">
                            <h3>Your Tasks</h3>
                        </div>

                        <div class="card-body mt-3">
                            <?php if (!empty($_SESSION['success_message'])): ?>
                                <div class="alert alert-success" role="alert">
                                    <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
                                </div>
                            <?php endif; ?>

                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Subject</th>
                                        <th>Task</th>
                                        <th>Date</th>
                                        <th>Deadline</th>
                                        <th>Time</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($tasks as $task) : ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($task['subject_name']); ?></td>
                                            <td><?php echo htmlspecialchars($task['task']); ?></td>
                                            <td><?php echo htmlspecialchars($task['task_date']); ?></td>
                                            <td><?php echo htmlspecialchars($task['deadline']); ?></td>
                                            <td><?php echo htmlspecialchars($task['task_time']); ?></td>
                                         
                                            <td>
                                                <a href="?delete=<?php echo $task['id']; ?>" class="btn btn-danger btn-sm" 
                                                    onclick="return confirm('Are you sure you want to delete this task?');">Delete</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
