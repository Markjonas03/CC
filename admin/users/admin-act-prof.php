<?php
    include '../../include/config.php';
    session_start();

    // ADMIN DELETE PROFESSOR DATA
    if(isset($_POST['admin-delete-prof'])){
        $id = $_POST['id'];

        $del = "DELETE FROM tbl_users WHERE id = '$id'";
        $query = mysqli_query($conn,$del);
        if($query){
            $_SESSION['status_message'] = "Users data has been deleted...";
            $_SESSION['status_code'] = "success";
            header("Location: admin-users-prof.php");
            exit();
        } else {
            $_SESSION['status_message'] = "Something went wrong..";
            $_SESSION['status_code'] = "error";
            header("Location: admin-users-prof.php");
            exit();
        }
    }
    


    // ADMIN UPDATE PROFESSOR DATA
    if(isset($_POST['admin-update-prof'])){
        $id = $_POST['id'];
        $id_no = $_POST['id_no'];
        $fname = $_POST['fname'];
        $mname = $_POST['mname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $contact = $_POST['contact'];

        if(empty($id_no) && empty($fname) && empty($mname) && empty($lname) && empty($email) && empty($contact)){
            $_SESSION['status_message'] = "Fill out all fields...";
            $_SESSION['status_code'] = "error";
            header("Location: admin-users-prof.php");
            exit();
        }else{
            $update = "UPDATE tbl_users SET id_no = '$id_no',fname = '$fname', mname = '$mname', lname = '$lname', email = '$email', contact = '$contact' WHERE id = '$id'";
            $query = mysqli_query($conn,$update);
            if($query){
                $_SESSION['status_message'] = "Data successfully updated!";
                $_SESSION['status_code'] = "success";
                header("Location: admin-users-prof.php");
                exit();
            } else {
                $_SESSION['status_message'] = "Something went wrong...";
                $_SESSION['status_code'] = "error";
                header("Location: admin-users-prof.php");
                exit();
            }
        }
    }

?>