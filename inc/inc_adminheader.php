<?php
session_start();
require_once 'inc/inc_connection.php';

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Validasi pengguna admin
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = '$user_id'";
$result = mysqli_query($koneksi, $sql);
$user = mysqli_fetch_assoc($result);

if (!$user || $user['role'] !== 'Admin') {
    // Jika bukan admin, alihkan ke halaman unauthorized
    header("Location: login.php");
    exit();
}

function logout()
{
    // Hapus sesi di server
    session_unset();  // Hapus semua variabel sesi
    session_destroy(); // Hancurkan sesi

    // Hapus cookie sesi jika ada
    setcookie(session_name(), '', time() - 3600, '/');  // Menghapus cookie sesi jika digunakan

    // Redirect pengguna ke halaman login setelah logout
    header("Location: login.php");
    exit();
}

// Periksa apakah ada permintaan logout
if (isset($_POST['logout'])) {
    logout();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title><?php echo isset($pageTitle) ? $pageTitle : "Default Title"; ?></title>

    <!-- Bootstrap CSS -->
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

</head>

<body>
    <div class="main-container">
        <!-- Sidebar -->
        <nav class="col-md-3 col-lg-2 sidenav d-flex flex-column p-3">
            <!-- Logo -->
            <a class="navbar-brand" href="landingpage.php">
                <img src="./assets/logo.png" width="80" height="80" alt="">
                <span style="font-size:30px; font-weight:bolder; margin-left:-20px; color:grey;">Healpoint</span>
            </a>

            <!-- Profile Image -->
            <div class="profile-img text-center">
                <img src="assets/profile.jpg" alt="Profile" class="img-fluid rounded-circle">
            </div>

            <!-- Admin Name -->
            <div class="admin-name">
                <?php echo htmlspecialchars($user['full_name']); ?>
            </div>

            <!-- Social Links -->
            <div class="social-links text-center mt-3">
                <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
            </div>

            <!-- Navigation Menu -->
            <ul class="nav flex-column mt-4">
                <li class="nav-item">
                    <a href="index-users.php" id="users-link" class="nav-link"><i class="bi bi-people me-2"></i> Users</a>
                </li>
                <li class="nav-item">
                    <a href="index-psikolog.php" id="psychologis-link" class="nav-link"><i class="bi bi-activity me-2"></i> Psychologies</a>
                </li>
                <li class="nav-item">
                    <a href="index-questions.php" id="question-link" class="nav-link"><i class="bi bi-question-circle me-2"></i> Questions</a>
                </li>
                <li class="nav-item">
                    <form action="" method="POST" style="display: inline;">
                        <button type="submit" name="logout" id="logout-link" class="nav-link btn btn-link" style="border: none; background: none;">
                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                        </button>
                    </form>
                </li>

            </ul>
        </nav>

        <!-- Main Content -->
        <main class="col-md-9 col-lg-10 content">
            <div id="dynamic-content"></div>