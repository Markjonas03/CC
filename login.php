<?php
include 'include/config.php';
include 'include/server.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link href="assets/image/LOGO.png" rel="icon">

    <link href="assets/css/style-home.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/font.css">

    <link rel="stylesheet" href="assets/font-awesome/all.min.css">

</head>

<body>
    <!-- STARTS OF NAVIGATION HEADER SECTION -->
    <header>
        <div class="logo">
            <img src="assets/image/LOGO.png" alt="PEP logo">
        </div>
        <h1 class="logo-name">Taguig City University</h1>

        <nav class="navbar">
            <a href="index.php">Home</a>
        </nav>

        <div class="icons">
            <div id="menu-bar" class="fas fa-bars"></div>
        </div>

    </header>
    <!-- ENDS OF NAVIGATION HEADER SECTION -->



    <!-- STARTS OF LOGIN SECTION -->
    <section class="home" id="home"
        style="background: url(assets/image/TCUU.png); background-repeat: no-repeat; background-position: top; background-size: cover; width: 100%;  height: 85vh;">

        <div class="content">
            <form action="" method="POST" class="login-form">
                <h3>login</h3>
                <?php include 'message.php'; ?>
                <input class="box" type="text" name="id_no" placeholder="ID Number">
                <input class="box" type="password" name="password" placeholder="Password">
                <input class="btn" type="submit" name="login_submit" value="Login">
                <br>
                <br>
                <hr>
            </form>
        </div>

    </section>
    <!-- ENDS OF LOGIN SECTION -->



    <!-- STARTS OF FOOTER SECTION -->
    <footer id="try">
        <div class="container">
            <div class="box">
            <h3>Taguig City University</h3>
                        <p>General Santos Avenue, Barangay Central Bicutan, City of Taguig</p>
                            <a href="https://tcu.edu.ph/about/"><img src="assets/image/LOGO.png" alt="TAGUIG logo"></a>
                            <a href="https://taguig.gov.ph/"><img src="assets/image/TAGUIG.png" alt="TAGUIG logo"></a>
                            <a href="https://ched.gov.ph/"><img src="assets/image/CHED-LOGO.png" alt="TAGUIG logo"></a>
                        <hr class="footer-hr">
                            
                    
                        <div class="follow">
                            <p>Follow Us on Social Media:</p>
                            <a href="https://www.facebook.com/TaguigCityUniversity" class="fab fa-facebook-f"></a>
                           
                        </div>
                
            </div>
        </div>
    </footer>
    <!-- ENDS OF FOOTER SECTION -->


    <!-- js link -->
    <script src="assets/js/main.js"></script>
</body>

</html>