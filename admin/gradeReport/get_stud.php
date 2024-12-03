<?php
    sleep(1);
    include '../../include/config.php';
    session_start();

    if(isset($_POST['request'])) {
        $request = $_POST['request'];
        $sql = "SELECT DISTINCT subject_code, subject_name, result, s.id,c.course,c.year,c.section,c.sem FROM tbl_professor p
                    JOIN tbl_student s ON s.advisory_id = p.id
                    JOIN tbl_subjects sub ON sub.id = p.subject_id
                    LEFT JOIN tbl_result r ON s.id = r.student_id
                    JOIN tbl_class c ON c.id = p.class_id
                    WHERE s.student_id ='$request'";
        $result = mysqli_query($conn, $sql);	
        $count = mysqli_num_rows($result);
?>
<link href="../../assets/css/simple-datatables.css" rel="stylesheet">
<script src="../../assets/js/simple-datatables.js"></script>
<script src="../../assets/js/main.js"></script> 

<table class="table table-borderless table-hover table-striped datatable">
    <?php
    if($count){
    ?>
    <thead>
        <tr>
            <th>COURSE</th>
            <th>SEMESTER</th>
            <th>Subject Code</th>
            <th>Subject Title</th>
            <th>Grades</th>
            <th>Actions</th>
        </tr>
    </thead>
    <?php } else {

    }
        ?>
    <tbody>
        <?php
            while($row = mysqli_fetch_assoc($result)){
        ?>
        <tr id="delete<?php echo $row['id']?>">
            <th><?php echo $row['course'],"-",$row['year'],$row['section']?></th>
            <th><?php echo $row['sem']?></th>
            <th><?php echo $row['subject_code']?></th>
            <th><?php echo $row['subject_name']?></th>
            <th><?php echo $row['result']?></th>
            <th>
                <a href="admin-edit-result.php?id=<?php echo $row['id'];?>" class="text-info me-3"><i class="fa-solid fa-pen-to-square fs-5" title="Edit"></i></a>
                <a href="#" class="text-danger" onclick="delData(<?php echo $row['id'];?>)"><i class="fa-solid fa-trash fs-5" title="Delete"></i></a>
            </th>
        </tr>
        <?php 
            }
        ?>
    </tbody>
</table>
<?php 
    }
?>

<script>
    function delData(id){
        if(confirm("Are you sure?")){
            $.ajax({
                url: '../../include/server.php',
                type: 'POST',
                data: {admin_delete_id:id},
                success:function(data){
                    $("#delete"+id).hide();
                }
            })
        }
    }
</script>