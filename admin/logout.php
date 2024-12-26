<?php
// Fungsi logout
function logout()
{
    session_unset();  
    session_destroy(); 
    setcookie(session_name(), '', time() - 3600, '/');
    header("Location: ../users/login.php");
    exit();
}

// Periksa URL untuk logout
if ($_GET['action'] == 'logout') {
    logout();
}
?>

