<?php
include 'config.php';
session_start();


// SIGN IN
if (isset($_POST['login_submit'])) {
    $id_no = trim($_POST['id_no']);
    $password = trim($_POST['password']);

    if (empty($id_no) && empty($password)) {
        $_SESSION['status_message'] = "Please.. Fill out all field!";
        $_SESSION['status_code'] = "error";
        header("Location: ./login.php");
        exit();
    } elseif (empty($id_no)) {
        $_SESSION['status_message'] = "Enter your ID number!";
        $_SESSION['status_code'] = "warning";
        header("Location: ./login.php");
        exit();
    } elseif (empty($password)) {
        $_SESSION['status_message'] = "Enter your Password!";
        $_SESSION['status_code'] = "warning";
        header("Location: ./login.php");
        exit();
    } else {
        $select = "SELECT * FROM tbl_users WHERE id_no = '$id_no' && password = md5('$password')";
        $query = mysqli_query($conn, $select);

        if (mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_assoc($query);

            if ($row['role'] == 'student') {
                $_SESSION['student_name'] = $row['email'];
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_stud'] = $row['role'] == 'student';
                $_SESSION['stud_no'] = $row['id_no'];
                header('Location: ./student/screen/student.php');
                exit();
            } elseif ($row['role'] == 'admin') {
                $_SESSION['admin_name'] = $row['fname'];
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_admin'] = $row['role'] == 'admin';
                header('Location: ./admin/dashboard/admin.php');
                exit();
            } elseif ($row['role'] == 'professor') {
                $_SESSION['prof_name'] = $row['email'];
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_prof'] = $row['role'] == 'professor';
                $_SESSION['user_no'] = $row['id_no'];
                $_SESSION['profs'] = $row['fname'];
                header('Location: ./professor/screen/prof.php');
                exit();
            }

        } else {
            $_SESSION['status_message'] = "Incorrect ID number or Password..";
            $_SESSION['status_code'] = "error";
            header("Location: ./login.php");
            exit();
        }
    }
}


// CREATE ACCOUNT
if (isset($_POST['admin-submit'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id_no']);
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $pass = $_POST['pass'];
    $cpass = $_POST['con_pass'];
    $encrypted = md5($pass);
    $role = $_POST['role'];

    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    if (empty($id)) {
        $_SESSION['status_message'] = "Id no. is required!";
        $_SESSION['status_code'] = "error";
        header("Location: ../admin/users/admin-create.php");
        exit();
    } else {
        if (empty($fname)) {
            $_SESSION['status_message'] = "First Name is required!";
            $_SESSION['status_code'] = "error";
            header("Location: ../admin/users/admin-create.php");
            exit();
        } elseif (empty($lname)) {
            $_SESSION['status_message'] = "Last Name is required!";
            $_SESSION['status_code'] = "error";
            header("Location: ../admin/users/admin-create.php");
            exit();
        } else {
            $fname = validate($_POST['fname']);
            if (!preg_match("/^[a-zA-Z-' ]*$/", $fname)) {
                $_SESSION['status_message'] = "Only letters and space allowed!";
                $_SESSION['status_code'] = "error";
                header("Location: ../admin/users/admin-create.php");
                exit();
            } else {
                $mname = validate($_POST['mname']);
                if (!preg_match("/^[a-zA-Z-' ]*$/", $mname)) {
                    $_SESSION['status_message'] = "Only letters and space allowed!";
                    $_SESSION['status_code'] = "error";
                    header("Location: ../admin/users/admin-create.php");
                    exit();
                } else {
                    $lname = validate($_POST['lname']);
                    if (!preg_match("/^[a-zA-Z-' ]*$/", $lname)) {
                        $_SESSION['status_message'] = "Only letters and space allowed!";
                        $_SESSION['status_code'] = "error";
                        header("Location: ../admin/users/admin-create.php");
                        exit();
                    } else {
                        if (empty($email)) {
                            $_SESSION['status_message'] = "Email is required!";
                            $_SESSION['status_code'] = "error";
                            header("Location: ../admin/users/admin-create.php");
                            exit();
                        } else {
                            $email = validate($_POST["email"]);
                            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                $_SESSION['status_message'] = "Invalid Email.";
                                $_SESSION['status_code'] = "error";
                                header("Location: ../admin/users/admin-create.php");
                                exit();
                            } else {
                                if (empty($contact)) {
                                    $_SESSION['status_message'] = "Contact is required!";
                                    $_SESSION['status_code'] = "error";
                                    header("Location: ../admin/users/admin-create.php");
                                    exit();
                                } else {
                                    if (empty($pass)) {
                                        $_SESSION['status_message'] = "Password is required!";
                                        $_SESSION['status_code'] = "error";
                                        header("Location: ../admin/users/admin-create.php");
                                        exit();
                                    } else {
                                        if (strlen($pass) < 6) {
                                            $_SESSION['status_message'] = "Password is too weak!";
                                            $_SESSION['status_code'] = "warning";
                                            header("Location: ../admin/users/admin-create.php");
                                            exit();
                                        } else {
                                            if (empty($role)) {
                                                $_SESSION['status_message'] = "Role is required!";
                                                $_SESSION['status_code'] = "error";
                                                header("Location: ../admin/users/admin-create.php");
                                                exit();
                                            } else {

                                                $selId = "SELECT * FROM tbl_users WHERE id_no = '$id'";
                                                $checkId = mysqli_query($conn, $selId);

                                                if (mysqli_num_rows($checkId) > 0) {
                                                    $_SESSION['status_message'] = "ID no. already exists!";
                                                    $_SESSION['status_code'] = "error";
                                                    header("Location: ../admin/users/admin-create.php");
                                                    exit();
                                                } else {
                                                    $selEmail = "SELECT * FROM tbl_users WHERE email = '$email'";
                                                    $checkEmail = mysqli_query($conn, $selEmail);

                                                    if (mysqli_num_rows($checkEmail) > 0) {
                                                        $_SESSION['status_message'] = "Email already exists!";
                                                        $_SESSION['status_code'] = "error";
                                                        header("Location: ../admin/users/admin-create.php");
                                                        exit();
                                                    } else {
                                                        if ($pass != $cpass) {
                                                            $_SESSION['status_message'] = "Passwords do not match!";
                                                            $_SESSION['status_code'] = "warning";
                                                            header("Location: ../admin/users/admin-create.php");
                                                            exit();
                                                        } else {
                                                            // Insert into database including the new course field
                                                            $insert = "INSERT INTO tbl_users(id_no, fname, mname, lname, email, contact, password, role) 
                                                                       VALUES ('$id', '$fname', '$mname', '$lname', '$email', '$contact', '$encrypted', '$role')";
                                                            mysqli_query($conn, $insert);
                                                            $_SESSION['status_message'] = "Account has been created...";
                                                            $_SESSION['status_code'] = "success";
                                                            header("Location: ../admin/users/admin-create.php");
                                                            exit();
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}



// STUDENT EDIT PHOTO
if (isset($_FILES["image_stud"]["name"])) {
    if (!isset($_POST['_token']) || ($_POST['_token'] !== $_SESSION['_token'])) {
        $_SESSION['status_message'] = "Invalid TOKEN!";
        $_SESSION['status_code'] = "error";
        header("Location: ../student/screen/student.php");
        exit();
    } else {
        if (time() >= $_SESSION['_token-expire']) {
            $_SESSION['status_message'] = "Token expired.. Please try to reload the page!";
            $_SESSION['status_code'] = "warning";
            header("Location: ../student/screen/student.php");
            exit();
        } else {
            $id = $_SESSION['user_id'];
            $name = $_POST["name"];

            $imageName = $_FILES["image_stud"]["name"];
            $imageSize = $_FILES["image_stud"]["size"];
            $tmpName = $_FILES["image_stud"]["tmp_name"];

            // Image validation
            $validImageExtension = ['jpg', 'jpeg', 'png'];
            $imageExtension = explode('.', $imageName);
            $imageExtension = strtolower(end($imageExtension));
            if (!in_array($imageExtension, $validImageExtension)) {
                $_SESSION['status_message'] = "Invalid Image Extension!";
                $_SESSION['status_code'] = "error";
                header("Location: ../student/screen/student.php");
                exit();
            } elseif ($imageSize > 1200000) {
                $_SESSION['status_message'] = "Image Size Is Too Large";
                $_SESSION['status_code'] = "warning";
                header("Location: ../student/screen/student.php");
                exit();
            } else {
                $newImageName = $name . " - " . date("Y.m.d") . " - " . date("h.i.sa"); // Generate new image name
                $newImageName .= '.' . $imageExtension;
                $query = "UPDATE tbl_users SET image = '$newImageName' WHERE id = $id";
                mysqli_query($conn, $query);
                move_uploaded_file($tmpName, '../assets/image-profile/' . $newImageName);
                $_SESSION['status_message'] = "Photo changed successfully!";
                $_SESSION['status_code'] = "success";
                header("location: ../student/screen/student.php");
                exit();
            }
        }
    }
}


// STUDENT EDIT PROFILE
if (isset($_POST['profile_stud'])) {
    if (!isset($_POST['_token']) || ($_POST['_token'] !== $_SESSION['_token'])) {
        $_SESSION['status_message'] = "Invalid TOKEN!";
        $_SESSION['status_code'] = "error";
        header("Location: ../student/screen/student.php");
        exit();
    } else {
        if (time() >= $_SESSION['_token-expire']) {
            $_SESSION['status_message'] = "Token expired.. Please try to reload the page!";
            $_SESSION['status_code'] = "warning";
            header("Location: ../student/screen/student.php");
            exit();
        } else {
            $fname = mysqli_real_escape_string($conn, $_POST['fname']);
            $mname = mysqli_real_escape_string($conn, $_POST['mname']);
            $lname = mysqli_real_escape_string($conn, $_POST['lname']);
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $contact = $_POST['contact'];
            $dept = $_POST['dept'];
            $id = $_SESSION['user_id'];

            function validate($data)
            {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }

            if (empty($fname)) {
                $_SESSION['status_message'] = "First Name is required!";
                $_SESSION['status_code'] = "error";
                header("Location: ../student/screen/student.php");
                exit();
            } elseif (empty($mname)) {
                $_SESSION['status_message'] = "Middle Name is required!";
                $_SESSION['status_code'] = "error";
                header("Location: ../student/screen/student.php");
                exit();
            } elseif (empty($lname)) {
                $_SESSION['status_message'] = "Last Name is required!";
                $_SESSION['status_code'] = "error";
                header("Location: ../student/screen/student.php");
                exit();
            } else {
                $fname = validate($_POST['fname']);
                if (!preg_match("/^[a-zA-Z-' ]*$/", $fname)) {
                    $_SESSION['status_message'] = "Only letters and space allowed!";
                    $_SESSION['status_code'] = "error";
                    header("Location: ../student/screen/student.php");
                    exit();
                } else {
                    $mname = validate($_POST['mname']);
                    if (!preg_match("/^[a-zA-Z-' ]*$/", $mname)) {
                        $_SESSION['status_message'] = "Only letters and space allowed!";
                        $_SESSION['status_code'] = "error";
                        header("Location: ../student/screen/student.php");
                        exit();
                    } else {
                        $lname = validate($_POST['lname']);
                        if (!preg_match("/^[a-zA-Z-' ]*$/", $lname)) {
                            $_SESSION['status_message'] = "Only letters and space allowed!";
                            $_SESSION['status_code'] = "error";
                            header("Location: ../student/screen/student.php");
                            exit();
                        } else {
                            $email = validate($_POST["email"]);
                            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                $_SESSION['status_message'] = "Invalid Email!";
                                $_SESSION['status_code'] = "error";
                                header("Location: ../student/screen/student.php");
                                exit();
                            } else {
                                if (empty($contact)) {
                                    $_SESSION['status_message'] = "Contact is required!";
                                    $_SESSION['status_code'] = "error";
                                    header("Location: ../student/screen/student.php");
                                    exit();
                                } else {
                                    $check_id = "SELECT * FROM tbl_users WHERE id = '$id'";
                                    $query = mysqli_query($conn, $check_id);
                                    if (mysqli_fetch_array($query) > 0) {
                                        $update = "UPDATE tbl_users SET fname = '$fname', mname = '$mname', lname = '$lname', dept ='$dept', email = '$email', contact = '$contact' WHERE id ='$id'";

                                        mysqli_query($conn, $update);
                                        unset($_SESSION['_token']);
                                        unset($_SESSION['_token-expire']);
                                        $_SESSION['status_message'] = "Successfully Saved Changes!";
                                        $_SESSION['status_code'] = "success";
                                        header("Location: ../student/screen/student.php");
                                        exit();
                                    } else {
                                        $_SESSION['status_message'] = "Something went wrong.. Please Try Again!";
                                        $_SESSION['status_code'] = "error";
                                        header("Location: ../student/screen/student.php");
                                        exit();
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}


//STUDENT CHANGE PASSWORD
if (isset($_POST['changePass_stud'])) {
    if (!isset($_POST['_token']) || ($_POST['_token'] !== $_SESSION['_token'])) {
        $_SESSION['status_message'] = "Invalid TOKEN!";
        $_SESSION['status_code'] = "error";
        header("Location: ../student/screen/student.php");
        exit();
    } else {
        if (time() >= $_SESSION['_token-expire']) {
            $_SESSION['status_message'] = "Token expired.. Please try to reload the page!";
            $_SESSION['status_code'] = "warning";
            header("Location: ../student/screen/student.php");
            exit();
        } else {
            $old_pass = $_POST['old_password'];
            $new_pass = $_POST['new_password'];
            $con_pass = $_POST['con_password'];

            function validate($data)
            {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }

            if (empty($old_pass)) {
                $_SESSION['status_message'] = "Old password is required!";
                $_SESSION['status_code'] = "error";
                header("Location: ../student/screen/student.php");
                exit();
            } else {
                if (empty($new_pass)) {
                    $_SESSION['status_message'] = "New password is required!";
                    $_SESSION['status_code'] = "error";
                    header("Location: ../student/screen/student.php");
                    exit();
                } elseif (strlen($new_pass) < 6) {
                    $_SESSION['status_message'] = "Password is too weak!";
                    $_SESSION['status_code'] = "warning";
                    header("Location: ../student/screen/student.php");
                    exit();
                } else {
                    if ($new_pass != $con_pass) {
                        $_SESSION['status_message'] = "Password does not matched!";
                        $_SESSION['status_code'] = "warning";
                        header("Location: ../student/screen/student.php");
                        exit();
                    } else {
                        $id = $_SESSION['user_id'];
                        $old_pass = md5($old_pass);
                        $new_pass = md5($new_pass);
                        $con_pass = md5($con_pass);

                        $check_pass = "SELECT * FROM tbl_users WHERE id = '$id' AND password = '$old_pass'";
                        $query = mysqli_query($conn, $check_pass);

                        if (mysqli_fetch_array($query) > 0) {
                            $update = "UPDATE tbl_users SET password = '$new_pass' WHERE id ='$id'";
                            mysqli_query($conn, $update);
                            $_SESSION['status_message'] = "Successfully Saved Changes!";
                            $_SESSION['status_code'] = "success";
                            header("Location: ../student/screen/student.php");
                            exit();
                        } else {
                            $_SESSION['status_message'] = "Old password is Incorrect!";
                            $_SESSION['status_code'] = "error";
                            header("Location: ../student/screen/student.php");
                            exit();
                        }
                    }
                }
            }
        }
    }
}


// ADMIN EDIT PHOTO
if (isset($_FILES["images"]["name"])) {
    $id = $_SESSION['user_id'];
    $name = $_POST["name"];

    $imageName = $_FILES["images"]["name"];
    $imageSize = $_FILES["images"]["size"];
    $tmpName = $_FILES["images"]["tmp_name"];

    // Image validation
    $validImageExtension = ['jpg', 'jpeg', 'png'];
    $imageExtension = explode('.', $imageName);
    $imageExtension = strtolower(end($imageExtension));
    if (!in_array($imageExtension, $validImageExtension)) {
        $_SESSION['status_message'] = "Invalid Image Extension!";
        $_SESSION['status_code'] = "error";
        header("Location: ../admin/profile/admin-profile.php");
        exit();
    } elseif ($imageSize > 1200000) {
        $_SESSION['status_message'] = "Image Size Is Too Large!";
        $_SESSION['status_code'] = "warning";
        header("Location: ../admin/profile/admin-profile.php");
        exit();
    } else {
        $newImageName = $name . " - " . date("Y.m.d") . " - " . date("h.i.sa"); // Generate new image name
        $newImageName .= '.' . $imageExtension;
        $query = "UPDATE tbl_users SET image = '$newImageName' WHERE id = $id";
        mysqli_query($conn, $query);
        move_uploaded_file($tmpName, '../assets/image-profile/' . $newImageName);
        $_SESSION['status_message'] = "Photo changed successfully!";
        $_SESSION['status_code'] = "success";
        header("location: ../admin/profile/admin-profile.php");
        exit();
    }
}


// ADMIN EDIT PROFILE
if (isset($_POST['save-edit-profile-ad'])) {
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $mname = mysqli_real_escape_string($conn, $_POST['mname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $contact = $_POST['contact'];
    $id = $_SESSION['user_id'];

    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    if (empty($fname)) {
        $_SESSION['status_message'] = "First Name is required!";
        $_SESSION['status_code'] = "error";
        header("Location: ../admin/profile/admin-profile.php");
        exit();
    } elseif (empty($mname)) {
        $_SESSION['status_message'] = "Middle Name is required!";
        $_SESSION['status_code'] = "error";
        header("Location: ../admin/profile/admin-profile.php");
        exit();
    } elseif (empty($lname)) {
        $_SESSION['status_message'] = "Last Name is required!";
        $_SESSION['status_code'] = "error";
        header("Location: ../admin/profile/admin-profile.php");
        exit();
    } else {
        $fname = validate($_POST['fname']);
        if (!preg_match("/^[a-zA-Z-' ]*$/", $fname)) {
            $_SESSION['status_message'] = "Only letters and space allowed!";
            $_SESSION['status_code'] = "error";
            header("Location: ../admin/profile/admin-profile.php");
            exit();
        } else {
            $mname = validate($_POST['mname']);
            if (!preg_match("/^[a-zA-Z-' ]*$/", $mname)) {
                $_SESSION['status_message'] = "Only letters and space allowed!";
                $_SESSION['status_code'] = "error";
                header("Location: ../admin/profile/admin-profile.php");
                exit();
            } else {
                $lname = validate($_POST['lname']);
                if (!preg_match("/^[a-zA-Z-' ]*$/", $lname)) {
                    $_SESSION['status_message'] = "Only letters and space allowed!";
                    $_SESSION['status_code'] = "error";
                    header("Location: ../admin/profile/admin-profile.php");
                    exit();
                } else {
                    $email = validate($_POST["email"]);
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $_SESSION['status_message'] = "Invalid Email!";
                        $_SESSION['status_code'] = "error";
                        header("Location: ../admin/profile/admin-profile.php");
                        exit();
                    } else {
                        if (empty($contact)) {
                            $_SESSION['status_message'] = "Contact is required!";
                            $_SESSION['status_code'] = "error";
                            header("Location: ../admin/profile/admin-profile.php");
                            exit();
                        } else {
                            $check_id = "SELECT * FROM tbl_users WHERE id = '$id'";
                            $query = mysqli_query($conn, $check_id);
                            if (mysqli_fetch_array($query) > 0) {
                                $update = "UPDATE tbl_users SET fname = '$fname', mname = '$mname', lname = '$lname', dept ='$dept', email = '$email', contact = '$contact' WHERE id ='$id'";

                                mysqli_query($conn, $update);
                                $_SESSION['status_message'] = "Successfully Saved Changes!";
                                $_SESSION['status_code'] = "success";
                                header("Location: ../admin/profile/admin-profile.php");
                                exit();
                            } else {
                                $_SESSION['status_message'] = "Something went wrong.. Please Try Again!";
                                $_SESSION['status_code'] = "error";
                                header("Location: ../admin/profile/admin-profile.php");
                                exit();
                            }
                        }
                    }
                }
            }
        }
    }
}


// ADMIN CHANGED PASSWORD
if (isset($_POST['save-password-ad'])) {
    $old_pass = $_POST['old_password'];
    $new_pass = $_POST['new_password'];
    $con_pass = $_POST['con_password'];

    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    if (empty($old_pass)) {
        $_SESSION['status_message'] = "Old password is required!";
        $_SESSION['status_code'] = "error";
        header("Location: ../admin/profile/admin-profile.php");
        exit();
    } else {
        if (empty($new_pass)) {
            $_SESSION['status_message'] = "New password is required!";
            $_SESSION['status_code'] = "error";
            header("Location: ../admin/profile/admin-profile.php");
            exit();
        } elseif (strlen($new_pass) < 6) {
            $_SESSION['status_message'] = "Password is too weak!";
            $_SESSION['status_code'] = "warning";
            header("Location: ../admin/profile/admin-profile.php");
            exit();
        } else {
            if ($new_pass != $con_pass) {
                $_SESSION['status_message'] = "Password does not matched!";
                $_SESSION['status_code'] = "warning";
                header("Location: ../admin/profile/admin-profile.php");
                exit();
            } else {
                $id = $_SESSION['user_id'];
                $old_pass = md5($old_pass);
                $new_pass = md5($new_pass);
                $con_pass = md5($con_pass);

                $check_pass = "SELECT * FROM tbl_users WHERE id = '$id' AND password = '$old_pass'";
                $query = mysqli_query($conn, $check_pass);

                if (mysqli_fetch_array($query) > 0) {
                    $update = "UPDATE tbl_users SET password = '$new_pass' WHERE id ='$id'";
                    mysqli_query($conn, $update);
                    $_SESSION['status_message'] = "Password successfully changed!";
                    $_SESSION['status_code'] = "success";
                    header("Location: ../admin/profile/admin-profile.php");
                    exit();
                } else {
                    $_SESSION['status_message'] = "Old password is Incorrect!";
                    $_SESSION['status_code'] = "error";
                    header("Location: ../admin/profile/admin-profile.php");
                    exit();
                }
            }
        }
    }
}


// ADMIN SCHOOL YEAR CREATE
if (isset($_POST['add_sy'])) {
    $sy = $_POST['school_year'];

    if (empty($sy)) {
        $_SESSION['status_message'] = "School Year is required!";
        $_SESSION['status_code'] = "error";
        header("Location: ../admin/sy/admin-sy.php");
        exit();
    } else {
        $check = "SELECT * FROM tbl_sy WHERE school_year = '$sy'";
        $result = mysqli_query($conn, $check);
        if (mysqli_num_rows($result) > 0) {
            $_SESSION['status_message'] = "School Year is already exist!";
            $_SESSION['status_code'] = "error";
            header("Location: ../admin/sy/admin-sy.php");
            exit();
        } else {
            $insert = "INSERT INTO tbl_sy (school_year) VALUES ('$sy')";
            mysqli_query($conn, $insert);
            $_SESSION['status_message'] = "You have successfully Added a new School Year!";
            $_SESSION['status_code'] = "success";
            header("Location: ../admin/sy/admin-sy.php");
            exit();
        }
    }
}


// ADMIN SCHOOL YEAR UPDATE
if (isset($_POST['update_sy'])) {
    $sy_id = $_POST['sy_id'];
    $sy = $_POST['school_year'];
    $sy_status = $_POST['status'];

    $update = "UPDATE tbl_sy SET school_year = '$sy', status = '$sy_status' WHERE id ='$sy_id'";
    mysqli_query($conn, $update);
    $_SESSION['status_message'] = "School Year has been Updated!";
    $_SESSION['status_code'] = "success";
    header("Location: ../admin/sy/admin-sy.php");
    exit();
}


// ADMIN SCHOOL YEAR DELETE
if (isset($_POST['delete_sy'])) {
    $sy_id = $_POST['sy_id'];

    $del = "DELETE FROM tbl_sy WHERE id = '$sy_id'";
    $query = mysqli_query($conn, $del);
    if ($query) {
        $_SESSION['status_message'] = "School Year has been deleted...";
        $_SESSION['status_code'] = "success";
        header("Location: ../admin/sy/admin-sy.php");
        exit();
    } else {
        $_SESSION['status_message'] = "Something went wrong.. Please Try Again!";
        $_SESSION['status_code'] = "error";
        header("Location: ../admin/sy/admin-sy.php");
        exit();
    }
}


// ADMIN ADD SUBJECT
if (isset($_POST['add_subj'])) {
    if (!isset($_POST['_token']) || ($_POST['_token'] !== $_SESSION['_token'])) {
        $_SESSION['status_message'] = "Invalid TOKEN!";
        $_SESSION['status_code'] = "error";
        header("Location: ../admin/subject/admin-subject.php");
        exit();
    } else {
        if (time() >= $_SESSION['_token-expire']) {
            $_SESSION['status_message'] = "Token expired.. Please try to reload the page!";
            $_SESSION['status_code'] = "warning";
            header("Location: ../admin/subject/admin-subject.php");
            exit();
        } else {
            $subj_code = $_POST['subject_code'];
            $subj_name = $_POST['subject_name'];
            $unit = $_POST['unit'];

            if (empty($subj_code) && empty($subj_name) && empty($unit)) {
                $_SESSION['status_message'] = "Fill out all fields!";
                $_SESSION['status_code'] = "error";
                header("Location: ../admin/subject/admin-subject.php");
                exit();
            } else {
                $insert = "INSERT INTO tbl_subjects (subject_code, subject_name, units) VALUES ('$subj_code', '$subj_name', '$unit')";
                mysqli_query($conn, $insert);
                unset($_SESSION['_token']);
                unset($_SESSION['_token-expire']);
                $_SESSION['status_message'] = "You have successfully added your new Subject!";
                $_SESSION['status_code'] = "success";
                header("Location: ../admin/subject/admin-subject.php");
                exit();
            }
        }
    }
}


// ADMIN UPDATE SUBJECT
if (isset($_POST['update_subject'])) {
    if (!isset($_POST['_token']) || ($_POST['_token'] !== $_SESSION['_token'])) {
        $_SESSION['status_message'] = "Invalid TOKEN!";
        $_SESSION['status_code'] = "error";
        header("Location: ../admin/subject/admin-subject.php");
        exit();
    } else {
        if (time() >= $_SESSION['_token-expire']) {
            $_SESSION['status_message'] = "Token expired.. Please try to reload the page!";
            $_SESSION['status_code'] = "warning";
            header("Location: ../admin/subject/admin-subject.php");
            exit();
        } else {
            $ids = $_POST['subj_id'];
            $subj_code = $_POST['subject_code'];
            $subj_name = $_POST['subject_name'];
            $unit = $_POST['unit'];

            if (empty($subj_code) && empty($subj_name) && empty($unit)) {
                $_SESSION['status_message'] = "Fill out all fields!";
                $_SESSION['status_code'] = "error";
                header("Location: ../admin/subject/admin-subject.php");
                exit();
            } else {
                $update = "UPDATE tbl_subjects SET subject_code = '$subj_code', subject_name = '$subj_name', units = '$unit' WHERE id = '$ids'";
                $query = mysqli_query($conn, $update);
                if ($query) {
                    unset($_SESSION['_token']);
                    unset($_SESSION['_token-expire']);
                    $_SESSION['status_message'] = "Your subject has been Updated!";
                    $_SESSION['status_code'] = "success";
                    header("Location: ../admin/subject/admin-subject.php");
                    exit();

                } else {
                    $_SESSION['status_message'] = "Something went wrong.. Please Try Again!";
                    $_SESSION['status_code'] = "error";
                    header("Location: ../admin/subject/admin-subject.php");
                    exit();
                }
            }
        }
    }
}


// ADMIN DELETE SUBJECT
if (isset($_POST['delete_subject'])) {
    if (!isset($_POST['_token']) || ($_POST['_token'] !== $_SESSION['_token'])) {
        $_SESSION['status_message'] = "Invalid TOKEN!";
        $_SESSION['status_code'] = "error";
        header("Location: ../admin/subject/admin-subject.php");
        exit();
    } else {
        if (time() >= $_SESSION['_token-expire']) {
            $_SESSION['status_message'] = "Token expired.. Please try to reload the page!";
            $_SESSION['status_code'] = "warning";
            header("Location: ../admin/subject/admin-subject.php");
            exit();
        } else {
            $id = $_POST['subj_id'];

            $del = "DELETE FROM tbl_subjects WHERE id ='$id'";
            $query = mysqli_query($conn, $del);
            if ($query) {
                unset($_SESSION['_token']);
                unset($_SESSION['_token-expire']);
                $_SESSION['status_message'] = "Your subject has been Deleted!";
                $_SESSION['status_code'] = "success";
                header("Location: ../admin/subject/admin-subject.php");
                exit();
            } else {
                $_SESSION['status_message'] = "Something went wrong.. Please Try Again!";
                $_SESSION['status_code'] = "error";
                header("Location: ../admin/subject/admin-subject.php");
                exit();
            }
        }
    }
}


// ADMIN CREATE CLASS
if (isset($_POST['admin-createClass'])) {
    if (!isset($_POST['_token']) || ($_POST['_token'] !== $_SESSION['_token'])) {
        $_SESSION['status_message'] = "Invalid TOKEN!";
        $_SESSION['status_code'] = "error";
        header("Location: ../admin/classes/admin-class.php");
        exit();
    } else {
        if (time() >= $_SESSION['_token-expire']) {
            $_SESSION['status_message'] = "Token expired.. Please try to reload the page!";
            $_SESSION['status_code'] = "warning";
            header("Location: ../admin/classes/admin-class.php");
            exit();
        } else {
            $course = $_POST['course'];
            $yr = $_POST['year'];
            $sec = $_POST['section'];
            $sem = $_POST['sem'];
            $sy = $_POST['sy'];

            if (empty($course) && empty($yr) && empty($sec) && empty($sem) && empty($sy)) {
                $_SESSION['status_message'] = "Fill out all fields!";
                $_SESSION['status_code'] = "error";
                header("Location: ../admin/classes/admin-class.php");
                exit();
            } else {
                $id = $_SESSION['user_id'];
                $sql = "SELECT * FROM tbl_users WHERE id ='$id'";
                $query = mysqli_query($conn, $sql);
                if ($query) {
                    $check = "SELECT * FROM tbl_class WHERE course ='$course' && year ='$yr' && section ='$sec'";
                    $result = mysqli_query($conn, $check);
                    if (mysqli_num_rows($result) > 0) {
                        $_SESSION['status_message'] = "Class is already exist!";
                        $_SESSION['status_code'] = "error";
                        header("Location: ../admin/classes/admin-class.php");
                        exit();
                    } else {
                        $insert = "INSERT INTO tbl_class (course, year, section, sem, sy_id) VALUES ('$course', '$yr', '$sec', '$sem', '$sy')";
                        mysqli_query($conn, $insert);
                        unset($_SESSION['_token']);
                        unset($_SESSION['_token-expire']);
                        $_SESSION['status_message'] = "You have successfully added your new Class!";
                        $_SESSION['status_code'] = "success";
                        header("Location: ../admin/classes/admin-class.php");
                        exit();
                    }
                } else {
                    $_SESSION['status_message'] = "Something went wrong.. Please Try Again!";
                    $_SESSION['status_code'] = "error";
                    header("Location: ../admin/classes/admin-class.php");
                    exit();
                }
            }
        }
    }
}


// ADMIN UPDATE CLASS
if (isset($_POST['update_class'])) {
    if (!isset($_POST['_token']) || ($_POST['_token'] !== $_SESSION['_token'])) {
        $_SESSION['status_message'] = "Invalid TOKEN!";
        $_SESSION['status_code'] = "error";
        header("Location: ../admin/classes/admin-class.php");
        exit();
    } else {
        if (time() >= $_SESSION['_token-expire']) {
            $_SESSION['status_message'] = "Token expired.. Please try to reload the page!";
            $_SESSION['status_code'] = "warning";
            header("Location: ../admin/classes/admin-class.php");
            exit();
        } else {
            $ids = $_POST['class_id'];
            $course = $_POST['course'];
            $yr = $_POST['year'];
            $sec = $_POST['section'];
            $sem = $_POST['sem'];
            $sy = $_POST['sy'];

            if (empty($course) && empty($yr) && empty($sec) && empty($subj)) {
                $_SESSION['status_message'] = "Fill out all fields!";
                $_SESSION['status_code'] = "error";
                header("Location: ../admin/classes/admin-class.php");
                exit();
            } else {
                $update = "UPDATE tbl_class SET course = '$course', year = '$yr', section = '$sec', sem = '$sem', sy_id = '$sy' WHERE id = '$ids'";
                $query = mysqli_query($conn, $update);
                if ($query) {
                    unset($_SESSION['_token']);
                    unset($_SESSION['_token-expire']);
                    $_SESSION['status_message'] = "Your class has been Updated!";
                    $_SESSION['status_code'] = "success";
                    header("Location: ../admin/classes/admin-class.php");
                    exit();
                } else {
                    $_SESSION['status_message'] = "Something went wrong.. Please Try Again!";
                    $_SESSION['status_code'] = "error";
                    header("Location: ../admin/classes/admin-class.php");
                    exit();
                }
            }
        }
    }
}


// ADMIN DELETE CLASS
if (isset($_POST['delete_class'])) {
    if (!isset($_POST['_token']) || ($_POST['_token'] !== $_SESSION['_token'])) {
        $_SESSION['status_message'] = "Invalid TOKEN!";
        $_SESSION['status_code'] = "error";
        header("Location: ../admin/classes/admin-class.php");
        exit();
    } else {
        if (time() >= $_SESSION['_token-expire']) {
            $_SESSION['status_message'] = "Token expired.. Please try to reload the page!";
            $_SESSION['status_code'] = "warning";
            header("Location: ../admin/classes/admin-class.php");
            exit();
        } else {
            $id = $_POST['class_id'];

            // Delete class from tbl_class
            $del = "DELETE FROM tbl_class WHERE id ='$id'";
            $query = mysqli_query($conn, $del);
            if ($query) {
                // Delete associated students from tbl_student
                $del2 = "DELETE FROM tbl_student WHERE advisory_id ='$id'";
                $query2 = mysqli_query($conn, $del2);
                if ($query2) {
                    // Delete related results from tbl_result
                    $del3 = "DELETE r 
                            FROM tbl_result r
                            INNER JOIN tbl_professor p ON p.id = r.class_id
                            INNER JOIN tbl_subjects s ON s.id = p.subject_id
                            WHERE p.class_id = '$id'";
                    $query3 = mysqli_query($conn, $del3);

                    if ($query3) {
                        unset($_SESSION['_token']);
                        unset($_SESSION['_token-expire']);
                        $_SESSION['status_message'] = "Your class has been Deleted!";
                        $_SESSION['status_code'] = "success";
                        header("Location: ../admin/classes/admin-class.php");
                        exit();
                    } else {
                        $_SESSION['status_message'] = "Failed to delete class results!";
                        $_SESSION['status_code'] = "error";
                        header("Location: ../admin/classes/admin-class.php");
                        exit();
                    }
                }
            } else {
                $_SESSION['status_message'] = "Something went wrong.. Please Try Again!";
                $_SESSION['status_code'] = "error";
                header("Location: ../admin/classes/admin-class.php");
                exit();
            }
        }
    }
}



// ADMIN ADD PROFESSOR ADVISORY
if (isset($_POST['add_advisory'])) {
    if (!isset($_POST['_token']) || ($_POST['_token'] !== $_SESSION['_token'])) {
        $_SESSION['status_message'] = "Invalid TOKEN!";
        $_SESSION['status_code'] = "error";
        header("Location: ../admin/advisory/admin-advisory.php");
        exit();
    } else {
        if (time() >= $_SESSION['_token-expire']) {
            $_SESSION['status_message'] = "Token expired.. Please try to reload the page!";
            $_SESSION['status_code'] = "warning";
            header("Location: ../admin/advisory/admin-advisory.php");
            exit();
        } else {
            $prof = $_POST['prof'];
            $class = $_POST['class'];
            $subj = $_POST['subject'];

            if (empty($prof) && empty($class) && empty($subj)) {
                $_SESSION['status_message'] = "Fill out all fields!";
                $_SESSION['status_code'] = "error";
                header("Location: ../admin/advisory/admin-advisory.php");
                exit();
            } else {
                $insert = "INSERT INTO tbl_professor(prof_id, class_id, subject_id) VALUES ('$prof', '$class', '$subj')";
                $query = mysqli_query($conn, $insert);
                if ($query) {
                    unset($_SESSION['_token']);
                    unset($_SESSION['_token-expire']);
                    $_SESSION['status_message'] = "Successfully added!";
                    $_SESSION['status_code'] = "success";
                    header("Location: ../admin/advisory/admin-advisory.php");
                    exit();
                } else {
                    $_SESSION['status_message'] = "Something went wrong.. Please Try Again!";
                    $_SESSION['status_code'] = "error";
                    header("Location: ../admin/advisory/admin-advisory.php");
                    exit();
                }
            }
        }
    }
}


// ADMIN UPDATE PROFESSOR ADVISORY
if (isset($_POST['update_advisory'])) {
    if (!isset($_POST['_token']) || ($_POST['_token'] !== $_SESSION['_token'])) {
        $_SESSION['status_message'] = "Invalid TOKEN!";
        $_SESSION['status_code'] = "error";
        header("Location: ../admin/advisory/admin-advisory.php");
        exit();
    } else {
        if (time() >= $_SESSION['_token-expire']) {
            $_SESSION['status_message'] = "Token expired.. Please try to reload the page!";
            $_SESSION['status_code'] = "warning";
            header("Location: ../admin/advisory/admin-advisory.php");
            exit();
        } else {
            $id = $_POST['id'];
            $prof = $_POST['prof'];
            $class = $_POST['class'];
            $sem = $_POST['sem'];
            $subj = $_POST['subject'];

            if (empty($id) && empty($prof) && empty($class) && empty($sem) && empty($subj)) {
                $_SESSION['status_message'] = "Fill out all fields!";
                $_SESSION['status_code'] = "error";
                header("Location: ../admin/advisory/admin-advisory.php");
                exit();
            } else {
                $update = "UPDATE tbl_professor SET prof_id ='$prof', class_id ='$class', subject_id ='$subj' WHERE id ='$id'";
                $query = mysqli_query($conn, $update);
                if ($query) {
                    unset($_SESSION['_token']);
                    unset($_SESSION['_token-expire']);
                    $_SESSION['status_message'] = "Your Advisory has been Updated!";
                    $_SESSION['status_code'] = "success";
                    header("Location: ../admin/advisory/admin-advisory.php");
                    exit();
                } else {
                    $_SESSION['status_message'] = "Something went wrong.. Please Try Again!";
                    $_SESSION['status_code'] = "error";
                    header("Location: ../admin/advisory/admin-advisory.php");
                    exit();
                }
            }
        }
    }
}


// ADMIN DELETE PROFESSOR ADVISORY
if (isset($_POST['delete_advisory'])) {
    if (!isset($_POST['_token']) || ($_POST['_token'] !== $_SESSION['_token'])) {
        $_SESSION['status_message'] = "Invalid TOKEN!";
        $_SESSION['status_code'] = "error";
        header("Location: ../admin/advisory/admin-advisory.php");
        exit();
    } else {
        if (time() >= $_SESSION['_token-expire']) {
            $_SESSION['status_message'] = "Token expired.. Please try to reload the page!";
            $_SESSION['status_code'] = "warning";
            header("Location: ../admin/advisory/admin-advisory.php");
            exit();
        } else {
            $id = $_POST['id'];

            $del = "DELETE FROM tbl_professor WHERE id ='$id'";
            $query = mysqli_query($conn, $del);
            if ($query) {
                $del2 = "DELETE FROM tbl_student WHERE advisory_id ='$id'";
                mysqli_query($conn, $del2);
                unset($_SESSION['_token']);
                unset($_SESSION['_token-expire']);
                $_SESSION['status_message'] = "Your class has been Deleted!";
                $_SESSION['status_code'] = "success";
                header("Location: ../admin/advisory/admin-advisory.php");
                exit();
            } else {
                $_SESSION['status_message'] = "Something went wrong.. Please Try Again!";
                $_SESSION['status_code'] = "error";
                header("Location: ../admin/advisory/admin-advisory.php");
                exit();
            }
        }
    }
}


// ADMIN UPDATE RESULT
if (isset($_POST['ad_upResult'])) {
    if (!isset($_POST['_token']) || ($_POST['_token'] !== $_SESSION['_token'])) {
        $_SESSION['status_message'] = "Invalid TOKEN!";
        $_SESSION['status_code'] = "error";
        header("Location: ../admin/gradeReport/admin-grade.php");
        exit();
    } else {
        if (time() >= $_SESSION['_token-expire']) {
            $_SESSION['status_message'] = "Token expired.. Please try to reload the page!";
            $_SESSION['status_code'] = "warning";
            header("Location: ../admin/gradeReport/admin-grade.php");
            exit();
        } else {
            $id = $_POST['id'];
            $mark = $_POST['result'];

            if (empty($mark)) {
                $_SESSION['status_message'] = "Empty Result..";
                $_SESSION['status_code'] = "error";
                header("Location: ../admin/gradeReport/admin-grade");
                exit();
            } else {
                $update = "UPDATE tbl_result SET result ='$mark' WHERE id ='$id'";
                mysqli_query($conn, $update);
                $_SESSION['status_message'] = "The result has been Updated!";
                $_SESSION['status_code'] = "success";
                header("Location: ../admin/gradeReport/admin-grade.php");
                exit();
            }
        }
    }
}


// ADMIN DELETE STUDENT RESULT
if (isset($_POST['admin_delete_id'])) {
    $id = $_POST['admin_delete_id'];

    $del = "DELETE FROM tbl_student WHERE id ='$id'";
    $query = mysqli_query($conn, $del);
    if ($query) {
        $_SESSION['status_message'] = "Successfully deleted!";
        $_SESSION['status_code'] = "success";
        header("Location: ../admin/gradeReport/admin-grade.php");
        exit();
    } else {
        $_SESSION['status_message'] = "Something went wrong.. Please Try Again!";
        $_SESSION['status_code'] = "error";
        header("Location: ../admin/gradeReport/admin-grade.php");
        exit();
    }
}


// PROFESSOR EDIT PHOTO
if (isset($_FILES["images_prof"]["name"])) {
    if (!isset($_POST['_token']) || ($_POST['_token'] !== $_SESSION['_token'])) {
        $_SESSION['status_message'] = "Invalid TOKEN!";
        $_SESSION['status_code'] = "error";
        header("Location: ../professor/profile/prof-profile.php");
        exit();
    } else {
        if (time() >= $_SESSION['_token-expire']) {
            $_SESSION['status_message'] = "Token expired.. Please try to reload the page!";
            $_SESSION['status_code'] = "warning";
            header("Location: ../professor/profile/prof-profile.php");
            exit();
        } else {
            $id = $_SESSION['user_id'];
            $name = $_POST["name"];

            $imageName = $_FILES["images_prof"]["name"];
            $imageSize = $_FILES["images_prof"]["size"];
            $tmpName = $_FILES["images_prof"]["tmp_name"];

            // Image validation
            $validImageExtension = ['jpg', 'jpeg', 'png'];
            $imageExtension = explode('.', $imageName);
            $imageExtension = strtolower(end($imageExtension));
            if (!in_array($imageExtension, $validImageExtension)) {
                $_SESSION['status_message'] = "Invalid Image Extension!";
                $_SESSION['status_code'] = "error";
                header("Location: ../professor/profile/prof-profile.php");
                exit();
            } elseif ($imageSize > 1200000) {
                $_SESSION['status_message'] = "Image Size Is Too Large!";
                $_SESSION['status_code'] = "warning";
                header("Location: ../professor/profile/prof-profile.php");
                exit();
            } else {
                $newImageName = $name . " - " . date("Y.m.d") . " - " . date("h.i.sa"); // Generate new image name
                $newImageName .= '.' . $imageExtension;
                $query = "UPDATE tbl_users SET image = '$newImageName' WHERE id = $id";
                mysqli_query($conn, $query);
                move_uploaded_file($tmpName, '../assets/image-profile/' . $newImageName);
                unset($_SESSION['_token']);
                unset($_SESSION['_token-expire']);
                $_SESSION['status_message'] = "Photo changed successfully!";
                $_SESSION['status_code'] = "success";
                header("location: ../professor/profile/prof-profile.php");
                exit();
            }
        }
    }
}


// PROFESSOR EDIT PROFILE
if (isset($_POST['save-edit-profile-prof'])) {
    if (!isset($_POST['_token']) || ($_POST['_token'] !== $_SESSION['_token'])) {
        $_SESSION['status_message'] = "Invalid TOKEN!";
        $_SESSION['status_code'] = "error";
        header("Location: ../professor/profile/prof-profile.php");
        exit();
    } else {
        if (time() >= $_SESSION['_token-expire']) {
            $_SESSION['status_message'] = "Token expired.. Please try to reload the page!";
            $_SESSION['status_code'] = "warning";
            header("Location: ../professor/profile/prof-profile.php");
            exit();
        } else {
            $fname = mysqli_real_escape_string($conn, $_POST['fname']);
            $mname = mysqli_real_escape_string($conn, $_POST['mname']);
            $lname = mysqli_real_escape_string($conn, $_POST['lname']);
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $contact = $_POST['contact'];
            $id = $_SESSION['user_id'];

            function validate($data){
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }

            if (empty($fname)) {
                $_SESSION['status_message'] = "First Name is required!";
                $_SESSION['status_code'] = "error";
                header("Location: ../professor/profile/prof-profile.php");
                exit();
            } elseif (empty($mname)) {
                $_SESSION['status_message'] = "Middle Name is required!";
                $_SESSION['status_code'] = "error";
                header("Location: ../professor/profile/prof-profile.php");
                exit();
            } elseif (empty($lname)) {
                $_SESSION['status_message'] = "Last Name is required!";
                $_SESSION['status_code'] = "error";
                header("Location: ../professor/profile/prof-profile.php");
                exit();
            } else {
                $fname = validate($_POST['fname']);
                if (!preg_match("/^[a-zA-Z-' ]*$/", $fname)) {
                    $_SESSION['status_message'] = "Only letters and space allowed!";
                    $_SESSION['status_code'] = "error";
                    header("Location: ../professor/profile/prof-profile.php");
                    exit();
                } else {
                    $mname = validate($_POST['mname']);
                    if (!preg_match("/^[a-zA-Z-' ]*$/", $mname)) {
                        $_SESSION['status_message'] = "Only letters and space allowed!";
                        $_SESSION['status_code'] = "error";
                        header("Location: ../professor/profile/prof-profile.php");
                        exit();
                    } else {
                        $lname = validate($_POST['lname']);
                        if (!preg_match("/^[a-zA-Z-' ]*$/", $lname)) {
                            $_SESSION['status_message'] = "Only letters and space allowed!";
                            $_SESSION['status_code'] = "error";
                            header("Location: ../professor/profile/prof-profile.php");
                            exit();
                        } else {
                            $email = validate($_POST["email"]);
                            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                $_SESSION['status_message'] = "Invalid Email!";
                                $_SESSION['status_code'] = "error";
                                header("Location: ../professor/profile/prof-profile.php");
                                exit();
                            } else {
                                if (empty($contact)) {
                                    $_SESSION['status_message'] = "Contact is required!";
                                    $_SESSION['status_code'] = "error";
                                    header("Location: ../professor/profile/prof-profile.php");
                                    exit();
                                } else {
                                    $check_id = "SELECT * FROM tbl_users WHERE id = '$id'";
                                    $query = mysqli_query($conn, $check_id);
                                    if (mysqli_fetch_array($query) > 0) {
                                        $update = "UPDATE tbl_users SET fname = '$fname', mname = '$mname', lname = '$lname', email = '$email', contact = '$contact' WHERE id ='$id'";

                                        mysqli_query($conn, $update);
                                        unset($_SESSION['_token']);
                                        unset($_SESSION['_token-expire']);
                                        $_SESSION['status_message'] = "Successfully Saved Changes!";
                                        $_SESSION['status_code'] = "success";
                                        header("Location: ../professor/profile/prof-profile.php");
                                        exit();
                                    } else {
                                        $_SESSION['status_message'] = "Something went wrong.. Please Try Again!";
                                        $_SESSION['status_code'] = "error";
                                        header("Location: ../professor/profile/prof-profile.php");
                                        exit();
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}


// PROFESSOR CHANGED PASSWORD
if (isset($_POST['save-password-prof'])) {
    if (!isset($_POST['_token']) || ($_POST['_token'] !== $_SESSION['_token'])) {
        $_SESSION['status_message'] = "Invalid TOKEN!";
        $_SESSION['status_code'] = "error";
        header("Location: ../professor/profile/prof-profile.php");
        exit();
    } else {
        if (time() >= $_SESSION['_token-expire']) {
            $_SESSION['status_message'] = "Token expired.. Please try to reload the page!";
            $_SESSION['status_code'] = "warning";
            header("Location: ../professor/profile/prof-profile.php");
            exit();
        } else {
            $old_pass = $_POST['old_password'];
            $new_pass = $_POST['new_password'];
            $con_pass = $_POST['con_password'];

            function validate($data){
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }

            if (empty($old_pass)) {
                $_SESSION['status_message'] = "Old password is required!";
                $_SESSION['status_code'] = "error";
                header("Location: ../professor/profile/prof-profile.php");
                exit();
            } else {
                if (empty($new_pass)) {
                    $_SESSION['status_message'] = "New password is required!";
                    $_SESSION['status_code'] = "error";
                    header("Location: ../professor/profile/prof-profile.php");
                    exit();
                } elseif (strlen($new_pass) < 6) {
                    $_SESSION['status_message'] = "Password is too weak!";
                    $_SESSION['status_code'] = "warning";
                    header("Location: ../professor/profile/prof-profile.php");
                    exit();
                } else {
                    if ($new_pass != $con_pass) {
                        $_SESSION['status_message'] = "Password does not matched!";
                        $_SESSION['status_code'] = "warning";
                        header("Location: ../professor/profile/prof-profile.php");
                        exit();
                    } else {
                        $id = $_SESSION['user_id'];
                        $old_pass = md5($old_pass);
                        $new_pass = md5($new_pass);
                        $con_pass = md5($con_pass);

                        $check_pass = "SELECT * FROM tbl_users WHERE id = '$id' AND password = '$old_pass'";
                        $query = mysqli_query($conn, $check_pass);

                        if (mysqli_fetch_array($query) > 0) {
                            $update = "UPDATE tbl_users SET password = '$new_pass' WHERE id ='$id'";
                            mysqli_query($conn, $update);
                            unset($_SESSION['_token']);
                            unset($_SESSION['_token-expire']);
                            $_SESSION['status_message'] = "Password successfully changed!";
                            $_SESSION['status_code'] = "success";
                            header("Location: ../professor/profile/prof-profile.php");
                            exit();
                        } else {
                            $_SESSION['status_message'] = "Old password is Incorrect!";
                            $_SESSION['status_code'] = "error";
                            header("Location: ../professor/profile/prof-profile.php");
                            exit();
                        }
                    }
                }
            }
        }
    }
}



// PROFESSOR ADD STUDENT
if (isset($_POST['prof-addStud'])) {
    if (!isset($_POST['_token']) || ($_POST['_token'] !== $_SESSION['_token'])) {
        $_SESSION['status_message'] = "Invalid TOKEN!";
        $_SESSION['status_code'] = "error";
        header("Location: ../professor/classroom/prof-student.php");
        exit();
    }

    if (time() >= $_SESSION['_token-expire']) {
        $_SESSION['status_message'] = "Token expired.. Please try to reload the page!";
        $_SESSION['status_code'] = "warning";
        header("Location: ../professor/classroom/prof-student.php");
        exit();
    }

    $class = $_POST['class'];
    $stud = $_POST['id_no'];
    $lname = $_POST['lname'];
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];

    // Ensure fields are not empty
    $fields = [$class, $stud, $lname, $fname];
    if (array_filter($fields) !== $fields) {
        $_SESSION['status_message'] = "Fill out all fields!";
        $_SESSION['status_code'] = "error";
        header("Location: ../professor/classroom/prof-student.php");
        exit();
    }

    // Check if student already exists in tbl_student for that class
    $stmt = $conn->prepare("SELECT * FROM tbl_student WHERE student_id = ? AND advisory_id = ?");
    $stmt->bind_param("ss", $stud, $class);
    $stmt->execute();
    $query = $stmt->get_result();

    if ($query->num_rows > 0) {
        $_SESSION['status_message'] = "Student ID already exists!";
        $_SESSION['status_code'] = "error";
    } else {
        // Insert into tbl_student
        $insert = $conn->prepare("INSERT INTO tbl_student (advisory_id, student_id, lname, fname, mname) VALUES (?, ?, ?, ?, ?)");
        $insert->bind_param("sssss", $class, $stud, $lname, $fname, $mname);

        if ($insert->execute()) {
            $_SESSION['status_message'] = "You have successfully added your new Student!";
            $_SESSION['status_code'] = "success";
        } else {
            $_SESSION['status_message'] = "Error adding student: " . $conn->error;
            $_SESSION['status_code'] = "error";
        }
    }

    header("Location: ../professor/classroom/prof-myClass.php");
    exit();
}


// PROFESSOR UPDATE STUDENT
if (isset($_POST['prof_upInfo'])) {
    if (!isset($_POST['_token']) || ($_POST['_token'] !== $_SESSION['_token'])) {
        $_SESSION['status_message'] = "Invalid TOKEN!";
        $_SESSION['status_code'] = "error";
        header("Location: ../professor/classroom/prof-myClass.php");
        exit();
    } else {
        if (time() >= $_SESSION['_token-expire']) {
            $_SESSION['status_message'] = "Token expired.. Please try to reload the page!";
            $_SESSION['status_code'] = "warning";
            header("Location: ../professor/classroom/prof-myClass.php");
            exit();
        } else {
            $id = $_POST['id'];
            $lname = $_POST['lname'];
            $fname = $_POST['fname'];
            $mname = $_POST['mname'];

            if (empty($studId) && empty($lname) && empty($fname)) {
                $_SESSION['status_message'] = "All Field is required!";
                $_SESSION['status_code'] = "error";
                header("Location: ../professor/classroom/prof-myClass.php");
                exit();
            } else {
                $update = "UPDATE tbl_student SET lname ='$lname', fname='$fname',mname ='$mname' WHERE id ='$id'";
                mysqli_query($conn, $update);
                $_SESSION['status_message'] = "Your Student has been Updated!";
                $_SESSION['status_code'] = "success";
                header("Location: ../professor/classroom/prof-myClass.php");
                exit();
            }
        }
    }
}


// PROFESSOR DELETE STUDENT
if (isset($_POST['prof_delete_id'])) {

    $id = $_POST['prof_delete_id'];

    $del = "DELETE FROM tbl_student WHERE id ='$id'";
    $query = mysqli_query($conn, $del);
    if ($query) {
        $_SESSION['status_message'] = "Successfully deleted!";
        $_SESSION['status_code'] = "success";
        header("Location: ../professor/classroom/prof-myClass.php");
        exit();
    } else {
        $_SESSION['status_message'] = "Something went wrong.. Please Try Again!";
        $_SESSION['status_code'] = "error";
        header("Location: ../professor/classroom/prof-myClass.php");
        exit();
    }

}
// Function to round to the nearest valid grade
// Function to map a score to a grade (1.0, 1.25, etc.)
function mapToGrade($score) {
    if ($score >= 97 && $score <= 100) {
        return 1.00;
    } elseif ($score >= 94 && $score < 97) {
        return 1.25;
    } elseif ($score >= 91 && $score < 94) {
        return 1.50;
    } elseif ($score >= 88 && $score < 91) {
        return 1.75;
    } elseif ($score >= 85 && $score < 88) {
        return 2.00;
    } elseif ($score >= 82 && $score < 85) {
        return 2.25;
    } elseif ($score >= 79 && $score < 82) {
        return 2.50;
    } elseif ($score >= 76 && $score < 79) {
        return 2.75;
    } elseif ($score >= 75 && $score < 76) {
        return 3.00;
    } elseif ($score >= 0 && $score < 75) {
        return 5.00;
    }
    return 5.00;  // Default to 5.0 (Failed)
}

// Function to calculate final grade
function calculateGrade($midterm, $finals) {
    // Calculate the weighted average if needed
    $average = ($midterm + $finals) / 2;

    // Map to grade
    $final_grade = mapToGrade($average);

    return $final_grade;
}

// ADD OR UPDATE GRADES
if (isset($_POST['student_id'])) {
    // Retrieve posted data
    $student_id = $_POST['student_id'];
    $midterm = $_POST['midterm'];
    $finals = $_POST['finals'];

    // Validate input
    if (empty($student_id) || (!is_numeric($midterm) && $midterm !== '') || (!is_numeric($finals) && $finals !== '')) {
        echo json_encode(['status' => 'error', 'message' => 'All fields are required!']);
        exit();
    }

    // Calculate final grade based on midterm and finals
    $final_grade = calculateGrade($midterm, $finals);

    // Determine the status (Passed or Failed)
    $status = ($final_grade <= 3.00) ? 'PASSED' : 'FAILED';

    // Check if a record already exists for this student
    $check_sql = "SELECT id FROM tbl_result WHERE student_id = ? LIMIT 1";
    $check_stmt = mysqli_prepare($conn, $check_sql);
    mysqli_stmt_bind_param($check_stmt, "s", $student_id);
    mysqli_stmt_execute($check_stmt);
    mysqli_stmt_store_result($check_stmt);

    if (mysqli_stmt_num_rows($check_stmt) > 0) {
        // Record exists, update it
        $update_sql = "UPDATE tbl_result SET midterm = ?, finals = ?, result = ?, status = ? WHERE student_id = ?";
        $update_stmt = mysqli_prepare($conn, $update_sql);
        mysqli_stmt_bind_param($update_stmt, "ddsss", $midterm, $finals, $final_grade, $status, $student_id);
        if (mysqli_stmt_execute($update_stmt)) {
            echo json_encode(['status' => 'success', 'message' => 'Grades updated successfully!', 'final_grade' => $final_grade, 'status' => $status]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error executing update query: ' . mysqli_stmt_error($update_stmt)]);
        }
        mysqli_stmt_close($update_stmt);
    } else {
        // No record exists, insert new grade entry
        $insert_sql = "INSERT INTO tbl_result (student_id, midterm, finals, result, status) VALUES (?, ?, ?, ?, ?)";
        $insert_stmt = mysqli_prepare($conn, $insert_sql);
        mysqli_stmt_bind_param($insert_stmt, "sddss", $student_id, $midterm, $finals, $final_grade, $status);
        if (mysqli_stmt_execute($insert_stmt)) {
            echo json_encode(['status' => 'success', 'message' => 'Grades added successfully!', 'final_grade' => $final_grade, 'status' => $status]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error executing insert query: ' . mysqli_stmt_error($insert_stmt)]);
        }
        mysqli_stmt_close($insert_stmt);
    }
    mysqli_stmt_close($check_stmt);
    exit();
}



// Add Note (from professor or student)
if (isset($_POST['add_note'])) {
    // Check if the CSRF token is valid
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die(json_encode(["status" => "error", "message" => "Invalid CSRF token"]));
    }

    // Get the necessary data based on the user role
    $user_id = $_SESSION['user_id']; // This will be either professor or student ID
    $note_text = mysqli_real_escape_string($conn, $_POST['note_text']);
    $class_id = $_POST['class_id'];
    $student_id = $_POST['student_id'];
    
    // Determine sender type
    if ($_SESSION['role'] == 'professor') {
        $sender_type = 'professor';
        $prof_id = $user_id;
        // Insert note as professor
        $sql = "INSERT INTO tbl_notes (prof_id, class_id, student_id, note_text, sender_type) 
                VALUES ('$prof_id', '$class_id', '$student_id', '$note_text', '$sender_type')";
    } elseif ($_SESSION['role'] == 'student') {
        $sender_type = 'student';
        $sender_id = $user_id;
        // Insert note as student
        $sql = "INSERT INTO tbl_notes (student_id, class_id, note_text, sender_type) 
                VALUES ('$sender_id', '$class_id', '$note_text', '$sender_type')";
    }

    // Execute the query to insert the note
    if (mysqli_query($conn, $sql)) {
        $_SESSION['message'] = "Note added successfully!";
    } else {
        $_SESSION['error'] = "Failed to add note.";
    }

    // Redirect back to the professor page or wherever you want
    header('Location: ../prof/prof.php');
}


//MODAL VIEWSTUDENT
if (isset($_GET['class_id'])) {
    $class_id = $_GET['class_id'];

    // Query to get all students enrolled in the specified class
    $query = "SELECT u.id AS student_id, u.lname, u.fname
              FROM tbl_users u
              JOIN tbl_class_students cs ON cs.student_id = u.id
              WHERE cs.class_id = $class_id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            echo "<table class='table table-bordered'>";
            echo "<thead><tr><th>Student ID</th><th>Last Name</th><th>First Name</th></tr></thead><tbody>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>" . $row['student_id'] . "</td>
                        <td>" . $row['lname'] . "</td>
                        <td>" . $row['fname'] . "</td>
                      </tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p>No students enrolled in this class.</p>";
        }
    } else {
        echo "<p>Error fetching student list.</p>";
    }
}
?>



