<?php
require_once '../inc/inc_adminheader.php';
require_once '../inc/inc_connection.php';
$pageTitle = "Admin Dashboard - Healpoint";

// Validasi pengguna admin
if (!isset($_SESSION['user_id'])) {
    header("Location: ../users/login.php");
    exit();
}

// Fungsi logout
function logout() {
    // Menghapus semua data session
    session_unset();
    session_destroy();

    // Menghapus cookie session jika ada
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 3600,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Redirect ke halaman login
    header("Location: ../users/login.php");
    exit();
}

// Periksa apakah form logout dikirimkan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    logout();
}
?>

<div class="container my-5 text-center">
    <h1 class="display-4">Welcome to Admin Panel</h1>
    <p class="lead">Manage users, psychologists, questions, and other settings with ease.</p>
    <hr class="my-4">

    <div class="mt-4">
        <a href="../users/landingpage.php" class="btn btn-primary btn-lg mx-2" role="button">
            <i class="bi bi-box-arrow-in-left"></i> Go to User
        </a>

        <form action="" method="POST" style="display:inline;">
            <button type="submit" class="btn btn-danger btn-lg mx-2">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
    </div>
</div>

<!-- Bootstrap 4.3 JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<?php 
include '../inc/inc_adminfooter.php'; 
?>
