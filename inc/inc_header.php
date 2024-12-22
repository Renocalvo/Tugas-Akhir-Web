<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    $fullName = 'Guest'; // Default jika belum login
} else {
    $fullName = $_SESSION['full_name'];
}
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title><?php echo isset($pageTitle) ? $pageTitle : "Default Title"; ?></title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light mx-auto">
        <a class="navbar-brand" href="landingpage.php" style="font-size: 30px;">
            <img src="./assets/logo.png" width="80" height="80" alt=""> Healpoint
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto mr-3">
                <li class="nav-item ">
                    <a class="nav-link" href="layananpage.php">Layanan<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="klinikpage.php">Klinik</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="treatmentpage.php">Treatment</a>
                </li>
            </ul>
            <div class="vertical-line mr-3"></div>
            <?php if (!isset($_SESSION['user_id'])): ?>
                <!-- Tampilkan tombol "Login" jika pengguna belum login -->
                <a href="login.php" class="button-login ml-2 mr-3" style="text-decoration: none; color: black;">Login</a>
                <img src="./assets/default-profile.png" style="max-width: 40px; border-radius: 50%; border: none;"
                    class="img-thumbnail m-2" alt="...">
            <?php else: ?>
                <!-- Tampilkan informasi pengguna jika sudah login -->
                <div class="hero-avatar-profile mr-3">
                    <span class="full-name"><?php echo htmlspecialchars($fullName); ?></span>
                </div>
                <?php
                    $defaultImage = 'assets/default-profile.png';
                    $imagePath = ''; // Ubah sesuai dengan gambar pengguna jika tersedia
                ?>
                <img src="<?php echo $imagePath; ?>" 
                    onerror="this.onerror=null; this.src='<?php echo $defaultImage; ?>';" 
                    style="max-width: 40px; border-radius: 50%; border: none;" 
                    class="img-thumbnail m-2" 
                    alt="Profile Picture">
            <?php endif; ?>
        </div>
    </nav>
