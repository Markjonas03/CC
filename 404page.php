<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error 404</title>

    <link href="assets/css/font.css" rel="stylesheet">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
    <main>
        <div class="container">
            <section class="section error-404 min-vh-100 d-flex flex-column align-items-center justify-content-center">
               <!-- <h1>404</h1>
               <h2>The page you are looking for doesn't exist.</h2> -->
               <img src="assets/image/404.svg" class="img-fluid py-5" width="100%" alt="Page Not Found">
               <!-- <a class="btn" href="index.php">Back to home</a>  -->
            </section>
        </div>
    </main>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <script>
        setTimeout(()=>{
            window.location = 'logout.php';
        }, 10000);
    </script>

    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>