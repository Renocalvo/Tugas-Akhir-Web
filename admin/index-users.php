<?php
require_once '../inc/inc_adminheader.php';


require_once '../inc/inc_connection.php';
$pageTitle = "Users Admin Panel - Healpoint";

// Validasi pengguna admin
if (!isset($_SESSION['user_id'])) {
    header("Location: ../users/login.php");
    exit();
}

// Metode lain untuk menghapus user menggunakan GET parameter
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete_user_id'])) {
    $delete_user_id = (int)$_GET['delete_user_id'];

    // Debug untuk memastikan ID yang diterima dari URL
    error_log("Delete request received via GET for user ID: " . $delete_user_id);

    global $koneksi;

    // Debug untuk memastikan koneksi
    if (!$koneksi) {
        error_log("Database connection failed: " . mysqli_connect_error());
        echo json_encode(['status' => 'error', 'message' => 'Database connection failed.']);
        exit();
    }

    // Eksekusi query delete langsung
    $delete_query = "DELETE FROM users WHERE id = ?";
    if ($stmt = mysqli_prepare($koneksi, $delete_query)) {
        mysqli_stmt_bind_param($stmt, 'i', $delete_user_id);

        if (mysqli_stmt_execute($stmt)) {
            error_log("User with ID $delete_user_id deleted successfully via GET.");
            header("Location: ?success=User+deleted+successfully");
            exit();
        } else {
            error_log("Failed to delete user via GET: " . mysqli_error($koneksi));
            header("Location: ?error=Failed+to+delete+user");
            exit();
        }
        mysqli_stmt_close($stmt);
    } else {
        error_log("Failed to prepare statement for GET delete: " . mysqli_error($koneksi));
        header("Location: ?error=Failed+to+prepare+statement");
        exit();
    }
}

// Pagination logic
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$records_per_page = 10;
$offset = ($page - 1) * $records_per_page;

$total_query = "SELECT COUNT(*) AS total FROM users";
$total_result = mysqli_query($koneksi, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $records_per_page);

$query = "
    SELECT 
        id AS user_id,
        full_name AS user_full_name,
        email AS user_email
    FROM 
        users
    ORDER BY 
        id
    LIMIT $offset, $records_per_page;
";

$result = mysqli_query($koneksi, $query);
$users = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<div class="container my-4">
    <h1>Users Admin Panel</h1>

    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['user_id']) ?></td>
                    <td><?= htmlspecialchars($user['user_full_name']) ?></td>
                    <td><?= htmlspecialchars($user['user_email']) ?></td>
                    <td>
                        <a href="?delete_user_id=<?= htmlspecialchars($user['user_id']) ?>" 
                           class="btn btn-danger btn-sm" 
                           onclick="return confirm('Are you sure you want to delete this user?');">
                            <i class="fas fa-trash-alt"></i> Delete
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <?php if ($page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $page - 1 ?>" aria-label="Previous">&laquo;</a>
                </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>"> <?= $i ?></a>
                </li>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $page + 1 ?>" aria-label="Next">&raquo;</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</div>


<!-- Bootstrap 4.3 JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<?php
include '../inc/inc_adminfooter.php';
?>