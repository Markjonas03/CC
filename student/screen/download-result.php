<?php 
    require_once '../../dompdf/autoload.inc.php';
    include '../../include/config.php';
    session_start();
    use Dompdf\Dompdf;

    $dompdf = new Dompdf();
    ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>

</head>
<body>
    <div class="col-12">
        <div class="card prof-subj overflow-auto">
            <div class="card-body p-5">
                <div class="text-center d-flex justify-content-center">
                    <!-- <img src="assets/image/LOGO.png" width="120px" height="120px"> -->
                    <div>
                        <p style="text-align:center;">Taguig City University</p>
                        <p style="text-align:center;">General Santos Avenue, Barangay Central Bicutan, City of Taguig</p>
                        <p style="text-align:center;">TAGUIG, METRO MANILA</p>
                        <p style="text-align:center;">TEL NOS:8635-8300 (7202)</p>
                        <p style="text-align:center;">E-MAIL ADD: taguigcityuniversity072220@gmail.com</p>
                    </div>
                </div>
                <h4 style="text-align:center;">REPORT OF GRADE</h4>
                <?php
                    $no = $_SESSION['stud_no'];
                    $sql = "SELECT DISTINCT fname, mname,lname, c.course, c.year, c.section, sy.school_year 
                    FROM tbl_student s 
                    JOIN tbl_professor p ON p.id = s.advisory_id
                    JOIN tbl_class c ON c.id = p.class_id 
                    JOIN tbl_sy sy ON c.sy_id = sy.id 
                    WHERE s.student_id = '$no'";
                    $result = mysqli_query($conn,$sql);
                    while($rows = mysqli_fetch_assoc($result)){
                ?>
                <p><b>NAME OF STUDENT:</b> &nbsp; <?php echo $rows['fname']," ",$rows['mname']," ",$rows['lname']?></p>
                <p><b>PROGRAM:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $rows['course']?></p>
                <p><b>YEAR & SECTION:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $rows['year'],"-",$rows['section']?></p>    
                <p><b>S.Y:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $rows['school_year']?></b> </p>                         
                <?php
                    }
                ?>
                                                                                                                      
                <table class="table table-bordered" border="1" cellpadding="10" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>SUBJECT CODE</th>    
                            <th>SUBJECT TITLE</th>
                            <th>GRADES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $no = $_SESSION['stud_no'];
                            $sql = "SELECT DISTINCT subject_code, subject_name, result FROM tbl_professor p
                            JOIN tbl_student s ON s.advisory_id = p.id
                            JOIN tbl_subjects sub ON sub.id = p.subject_id
                            LEFT JOIN tbl_result r ON s.id = r.student_id
                            WHERE s.student_id = '$no'";
                            $query = mysqli_query($conn,$sql);
                            $total = 0;
                            $avg = null;
                            while($row = mysqli_fetch_assoc($query)){
                        ?>
                        <tr>
                            <td><?php echo $row['subject_code']?></td>
                            <td><?php echo $row['subject_name']?></td>
                            <td><?php echo $row['result']?></td>
                        </tr>
                        <?php                                                       
                            $total += $row['result'];
                            $avg = ($total / 6);
                        }
                                                
                        ?>
                        <tr>
                            <th></th>
                            <th scope="row">GENERAL AVERAGE</th>           
                            <td ><b><?php echo $avg;?></b></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
<?php
    $html = ob_get_clean();
    // Load content from html file 
    $dompdf->loadHtml($html); 
 
    // (Optional) Setup the paper size and orientation 
    $dompdf->setPaper('A4', 'landscape'); 
 
    // Render the HTML as PDF 
    $dompdf->render(); 
 
    // Output the generated PDF (1 = download and 0 = preview) 
    $dompdf->stream("as", array("Attachment" => 0));
?>