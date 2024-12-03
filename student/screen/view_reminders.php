<?php

include '../../include/config.php';
include '../../include/server.php';

// Check if the student is logged in
if (!isset($_SESSION['student_name']) && !isset($_SESSION['user_stud'])) {
    header('Location: ../../login.php');
    exit(); // Ensure to exit after redirection
}

// Retrieve the student ID from session
$student_id = $_SESSION['user_id']; // Assuming user_id stores the student's ID

// Handle task completion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mark_done'])) {
    $task_id = $_POST['task_id'];

    // Update task status to "Completed"
    $update_query = "UPDATE tbl_tasks SET status = 'Completed' WHERE id = ?";
    if ($stmt = $conn->prepare($update_query)) {
        $stmt->bind_param("i", $task_id);
        $stmt->execute();
        $stmt->close();
        
        // Redirect after completing a task to avoid form resubmission
        header('Location: view_reminders.php');
        exit();
    }
}

// Fetch task reminders for the student
$query = "SELECT t.id, t.task, t.task_date, t.task_time, t.deadline, t.created_at, t.status, s.subject_name 
          FROM tbl_tasks AS t 
          JOIN tbl_users AS u ON u.id = ? 
          LEFT JOIN tbl_subjects AS s ON s.id = t.subject_id
          ORDER BY t.task_date ASC, t.task_time ASC";

          
$tasks = [];
if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $tasks[] = $row;
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
    <title>Reminder</title>

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
                    <li class="breadcrumb-item"><a href="../screen/student.php">Home</a></li>
                    <li class="breadcrumb-item active">Reminders</li>
                </ol>
            </nav>
        </div>

        <section class="section dashboard">
            <div class="row">
                <div class="col-lg-10 m-auto">
                    <div class="card overflow-auto">
                        <div class="card-header">
                            <h3>Your Reminders</h3>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($tasks)) : ?>
                                <table class="table table-bordered">
    <thead>
        <tr>
            <th>Subject Name</th>  <!-- Add this column for the subject name -->
            <th>Task</th>
            <th>Date</th>
            <th>Deadline</th>
            <th>Time</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tasks as $task) : ?>
            <tr>
                <td><?php echo htmlspecialchars($task['subject_name']); ?></td> <!-- Display subject name -->
                <td><?php echo htmlspecialchars($task['task']); ?></td>
                <td><?php echo htmlspecialchars($task['task_date']); ?></td>
                <td><?php echo htmlspecialchars($task['deadline']); ?></td>
                <td><?php echo htmlspecialchars($task['task_time']); ?></td>
                <td><?php echo htmlspecialchars($task['status']); ?></td>
                <td>
                    <?php if ($task['status'] === 'Pending') : ?>
                        <!-- Mark as Done form -->
                        <form method="POST" action="">
                            <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                            <button type="submit" name="mark_done" class="btn btn-success">Done</button>
                        </form>
                    <?php else : ?>
                        <span class="badge bg-success">Completed</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
                            <?php else : ?>
                                <p>No reminders available.</p>
                            <?php endif; ?>
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
