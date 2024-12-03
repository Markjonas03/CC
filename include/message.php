<script src="../../assets/js/sweetalert.min.js"></script>
<?php
if (isset($_SESSION['status_message'])) {
    ?>
    <script>
        swal({
            title: "<?php echo $_SESSION['status_message']; ?>",
            icon: "<?php echo $_SESSION['status_code']; ?>",
            button: "OK",
        });
    </script>
    <?php
    unset($_SESSION['status_message']);
}
?>