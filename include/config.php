<?php 
    $conn = mysqli_connect("localhost","root","","tcu_result");

    if(!$conn){
        die('Connection Failed'.mysqli_connect_error());
    }
?>