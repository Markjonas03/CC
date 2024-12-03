<?php
// Include your database connection file
include '../../include/config.php';
session_start();

if (!isset($_SESSION['admin_name']) && !isset($_SESSION['user_admin'])) {
    header('Location: ../../login.php');
    exit;
}

// Assuming class_id is directly known or fetched from admin's selection
$class_id = 15;  // Example class_id (could be passed dynamically)

// Query to fetch students enrolled in the selected class
$query_students = "SELECT u.id_no, u.fname, u.mname, u.lname
                   FROM tbl_class_students cs
                   JOIN tbl_users u ON cs.student_id = u.id_no
                   WHERE cs.class_id = $class_id"; // Directly use the class_id

// Run the query
$result_students = mysqli_query($conn, $query_students);

// Check if any students are found
if ($result_students) {
    echo '<table class="table table-bordered">
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Name</th>
                </tr>
            </thead>
            <tbody>';

    // Display the students
    if (mysqli_num_rows($result_students) > 0) {
        while ($row_students = mysqli_fetch_assoc($result_students)) {
            $student_id = $row_students['id_no'];
            $fname = $row_students['fname'];
            $mname = $row_students['mname'];
            $lname = $row_students['lname'];

            // Display student info
            echo "<tr>
                    <td>$student_id</td>
                    <td>$lname, $fname $mname</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='2'>No students found for this class.</td></tr>";
    }

    echo '</tbody></table>';
} else {
    echo "Error fetching students: " . mysqli_error($conn);
}
?>
