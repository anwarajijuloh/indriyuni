<?php
require_once 'config.php';
require_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validateCSRFToken($_POST['csrf_token'])) {
        die("CSRF Token Validation Failed");
    }

    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    if (!validatePassword($password, $confirmPassword)) {
        echo "<div class='message-error'>
                <p>This email already register, Try email other!</p>
            </div> <br>";

        echo "<a href='javascript:self.history.back()'> <button class='btn'> Go Back </button></a>";
    }

    if (validateUserExists($username, $email)) {
        echo "<div class='message-error'>
                <p>This email already register, Try email other!</p>
            </div> <br>";

        echo "<a href='javascript:self.history.back()'> <button class='btn'> Go Back </button></a>";
    }

    registerUser($name, $username, $email, $password);
    redirectToLogin();
}

$csrfToken = generateToken();
$_SESSION['csrf_token'] = $csrfToken;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Indriyuni Profile Company</title>

    <!-- Favicons -->
    <link href="assets/img/features.jpg" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">


</head>

<body>
    <section id="hero" class="d-flex align-items-center justify-content-center">
        <div class="container" data-aos="fade-up">

            <div class="row justify-content-center" data-aos="fade-up" data-aos-delay="150">
                <div class="col-xl-6 col-lg-8">
                    <h1>Daftar yuk!<span>.</span></h1>
                </div>
            </div>
            <div class="row justify-content-center mt-4" data-aos="fade-up" data-aos-delay="150">

                <form action="register.php" method="post" class="col-xl-3 col-lg-6">
                    <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
                    <div class="form-group mt-3">
                        <input type="text" class="form-control mt-3" name="name" id="name" placeholder="Masukkan Nama" required>
                        <input type="text" class="form-control mt-3" name="username" id="username" placeholder="Masukkan Username" required>
                        <input type="text" class="form-control mt-3" name="email" id="email" placeholder="Masukkan Email" required>
                        <input type="password" class="form-control mt-3" name="password" id="password" placeholder="Masukkan Password" required>
                        <input type="password" class="form-control mt-3" name="confirm_password" id="confirm_password" placeholder="Konfirmasi Password" required>
                    </div>
                    <div class="mt-3"><button type="submit" class="btn btn-warning">Daftar</button></div>
                    <p class="mt-4">Sudah punya akun? <a href="register.php">Masuk</a> </p>
                </form>
            </div>


        </div>
    </section><!-- End Hero -->
    <!-- ======= Footer ======= -->
    <footer id="footer">
        <div class="container">
            <div class="copyright">
                &copy; Copyright <strong><span>Indriyuni</span></strong>. All Rights Reserved
            </div>
        </div>
    </footer><!-- End Footer -->

    <div id="preloader"></div>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

</body>

</html>