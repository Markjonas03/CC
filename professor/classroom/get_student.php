<?php
sleep(1);
include '../../include/config.php';
session_start();

// Function to round to the nearest valid grade
function roundToValidGrade($grade) {
    // Grade ranges
    $ranges = [
        [97, 100, 1.00],
        [94, 96, 1.25],
        [91, 93, 1.50],
        [88, 90, 1.75],
        [85, 87, 2.00],
        [82, 84, 2.25],
        [79, 81, 2.50],
        [76, 78, 2.75],
        [75, 75, 3.00],
        [0, 74, 5.00]
    ];

    foreach ($ranges as $range) {
        if ($grade >= $range[0] && $grade <= $range[1]) {
            return number_format($range[2], 2); // Return the grade in the desired format
        }
    }

    return 5.00; // Default to 5.00 if no match is found
}

// Check if the request is valid and retrieve advisory_id
if (isset($_POST['request'])) {
    $request = $_POST['request'];
    $sql = "SELECT * FROM tbl_result r RIGHT JOIN tbl_student s ON s.id = r.student_id WHERE s.advisory_id='$request'";
    $result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);
}
?>

<link href="../../assets/css/simple-datatables.css" rel="stylesheet">
<script src="../../assets/js/simple-datatables.js"></script>
<script src="../../assets/js/main.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

<table class="table table-bordered table-hover table-striped">
    <thead>
        <tr>
            <th>Student ID</th>
            <th>Last Name</th>
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Midterm</th>
            <th>Finals</th>
            <th>Final</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
    <tr id="row_<?php echo $row['id']; ?>">
        <td><?php echo $row['student_id'] ?></td>
        <td><?php echo $row['lname'] ?></td>
        <td><?php echo $row['fname'] ?></td>
        <td><?php echo $row['mname'] ?></td>
        <td>
            <input type="number" id="midterm_<?php echo $row['id'] ?>" value="<?php echo $row['midterm'] ?>" required>
        </td>
        <td>
            <input type="number" id="finals_<?php echo $row['id'] ?>" value="<?php echo $row['finals'] ?>" required>
        </td>
        <td id="final_grade_<?php echo $row['id']; ?>">
            <?php
            if ($row['status'] != 'UD' && $row['status'] != 'INC') {
                if (isset($row['midterm']) && isset($row['finals'])) {
                    $finalGrade = ($row['midterm'] * 0.5) + ($row['finals'] * 0.5);
                    echo roundToValidGrade($finalGrade);
                } else {
                    echo '-';
                }
            } else {
                echo '-';
            }
            ?>
        </td>
        <td id="status_<?php echo $row['id'] ?>" style="
            <?php 
                if ($row['status'] == 'UD') {
                    echo 'color: red;';
                } elseif ($row['status'] == 'INC') {
                    echo 'color: blue;';
                }
            ?>">
            <?php
                if ($row['status'] == 'UD') {
                    echo 'UD';
                } elseif ($row['status'] == 'INC') {
                    echo 'INC';
                } else {
                    if (isset($row['midterm']) && isset($row['finals'])) {
                        $finalGrade = ($row['midterm'] * 0.5) + ($row['finals'] * 0.5);
                        if ($finalGrade < 75) {
                            echo 'FAILED';
                        } else {
                            echo 'PASSED';
                        }
                    } else {
                        echo '-'; // Don't show "FAILED" if grades are not available
                    }
                }
            ?>
        </td>
        <td>
            <button type="button" onclick="submitGrades(<?php echo $row['id'] ?>)">Submit</button>
        </td>
    </tr>
    <?php } ?>
    </tbody>
</table>

<script>
function roundToValidGrade(grade) {
    const ranges = [
        [97, 100, 1.00],
        [94, 96, 1.25],
        [91, 93, 1.50],
        [88, 90, 1.75],
        [85, 87, 2.00],
        [82, 84, 2.25],
        [79, 81, 2.50],
        [76, 78, 2.75],
        [75, 75, 3.00],
        [0, 74, 5.00]
    ];

    for (let range of ranges) {
        if (grade >= range[0] && grade <= range[1]) {
            return range[2].toFixed(2);
        }
    }

    return 5.00;
}

function showSuccessAlert(message) {
    Swal.fire({
        icon: 'success',
        title: 'Success',
        text: message,
        confirmButtonText: 'OK'
    });
}

function showErrorAlert(message) {
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: message,
        confirmButtonText: 'OK'
    });
}

function submitGrades(id) {
    const midtermInput = document.getElementById(`midterm_${id}`);
    const finalsInput = document.getElementById(`finals_${id}`);

    const midterm = parseFloat(midtermInput.value);
    const finals = parseFloat(finalsInput.value);

    if (isNaN(midterm) || isNaN(finals)) {
        showWarningAlert("Please fill in both grades.");
        return;
    }

    let status = '';
    let finalGrade = 0;

    // Determine the grade status and final grade based on input
    if (midterm && !finals) {
        status = 'INC'; // Incomplete
        finalGrade = '-';
    } else if (!midterm && !finals) {
        status = 'UD'; // Unofficial Drop
        finalGrade = '-';
    } else {
        finalGrade = (midterm * 0.5) + (finals * 0.5);
        finalGrade = roundToValidGrade(finalGrade); // Round the grade to the nearest valid grade

        // Determine the status based on the final grade
        if (parseFloat(finalGrade) >= 3.0) {
            status = 'FAILED';
        } else {
            status = 'PASSED';
        }
    }

    console.log(`Submitting grades for student ${id}: Midterm: ${midterm}, Finals: ${finals}, Final Grade: ${finalGrade}, Status: ${status}`);

    // AJAX call to submit the grades
    $.ajax({
        url: '../../include/server.php',
        type: 'POST',
        data: {
            student_id: id,
            midterm: midterm,
            finals: finals,
            finalGrade: finalGrade,
            status: status,
            _token: '<?php echo $_SESSION["_token"]; ?>' // Token for security
        },
        success: function(data) {
            console.log(`Data saved for student ${id}:`, data);

            // Update the page content with the saved grades
            updateRow(id, finalGrade, status);
            showSuccessAlert("Grades and status updated successfully!");
        },
        error: function(xhr, status, error) {
            console.error("Error occurred while submitting grades:", error);
            showErrorAlert("An error occurred: " + error);
        }
    });
}

function updateRow(id, finalGrade, status) {
    const finalGradeCell = document.getElementById(`final_grade_${id}`);
    const statusCell = document.getElementById(`status_${id}`);

    finalGradeCell.innerText = finalGrade === '-' ? '-' : finalGrade;
    statusCell.innerText = status;

    if (status === 'UD') {
        statusCell.style.color = 'orange';
    } else if (status === 'INC') {
        statusCell.style.color = 'blue';
    } else if (status === 'PASSED') {
        statusCell.style.color = 'green';
    } else if (status === 'FAILED') {
        statusCell.style.color = 'red';
    }
}
</script>
