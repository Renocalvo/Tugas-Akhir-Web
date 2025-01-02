<?php
require_once '../inc/inc_connection.php';
$pageTitle = "layanan Page - Healpoint";
include '../inc/inc_adminheader.php';



$records_per_page = 10;

// Get the current page number from the query string, default to 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $records_per_page;

// Query to get the total number of records
$total_query = "SELECT COUNT(*) AS total FROM psychologists";
$total_result = mysqli_query($koneksi, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_records = $total_row['total'];
$imageBasePath = '../';
$total_pages = ceil($total_records / $records_per_page);

// Query to fetch data with pagination
$query = "
    SELECT 
        p.id AS psychologist_id,
        p.name AS psychologist_name,
        p.specialization AS psychologist_specialization,
        p.bio AS psychologist_bio,
        p.contact AS psychologist_contact,
        pi.id AS image_id,
        pi.image_path AS image_path,
        pi.uploaded_at AS image_uploaded_at
    FROM 
        psychologists p
    LEFT JOIN 
        psychologist_images pi ON p.id = pi.psychologist_id
    ORDER BY 
        p.id
    LIMIT $offset, $records_per_page;
";

// Execute query
$result = mysqli_query($koneksi, $query);

// Check if the query was successful
if (!$result) {
    die("Query failed: " . mysqli_error($koneksi));
}

// Save query results into an array
$results = [];
while ($row = mysqli_fetch_assoc($result)) {
    $results[] = $row;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = (int)$_POST['id'];

    // Validasi koneksi database
    if (!$koneksi) {
        error_log("Database connection failed: " . mysqli_connect_error());
        header("Location: index-psikolog.php?error=Database+connection+failed");
        exit();
    }

    // Mulai transaksi
    mysqli_begin_transaction($koneksi);

    try {
        // Hapus dari tabel psychologist_images
        $delete_images_query = "DELETE FROM psychologist_images WHERE psychologist_id = ?";
        $stmt_images = mysqli_prepare($koneksi, $delete_images_query);
        mysqli_stmt_bind_param($stmt_images, 'i', $id);
        if (!mysqli_stmt_execute($stmt_images)) {
            throw new Exception("Failed to delete images: " . mysqli_error($koneksi));
        }
        mysqli_stmt_close($stmt_images);

        // Hapus dari tabel psychologists
        $delete_psychologists_query = "DELETE FROM psychologists WHERE id = ?";
        $stmt_psychologists = mysqli_prepare($koneksi, $delete_psychologists_query);
        mysqli_stmt_bind_param($stmt_psychologists, 'i', $id);
        if (!mysqli_stmt_execute($stmt_psychologists)) {
            throw new Exception("Failed to delete psychologist: " . mysqli_error($koneksi));
        }
        mysqli_stmt_close($stmt_psychologists);

        // Commit transaksi
        mysqli_commit($koneksi);

        // Redirect ke halaman utama dengan pesan sukses
        header("Location: index-psikolog.php?success=Psychologist+deleted+successfully");
        exit();
    } catch (Exception $e) {
        // Rollback transaksi jika ada error
        mysqli_rollback($koneksi);
        error_log($e->getMessage());
        header("Location: index-psikolog.php?error=Failed+to+delete+psychologist");
        exit();
    }
}
?>

<div class="container my-4">
    <h1>Psychologists Admin Panel</h1>
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Specialization</th>
                <th>Bio</th>
                <th>Contact</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['psychologist_id']) ?></td>
                    <td><?= htmlspecialchars($row['psychologist_name']) ?></td>
                    <td><?= htmlspecialchars($row['psychologist_specialization']) ?></td>
                    <td><?= htmlspecialchars($row['psychologist_bio']) ?></td>
                    <td><?= htmlspecialchars($row['psychologist_contact']) ?></td>
                    <td>
                        <?php if (!empty($row['image_path'])): ?>
                            <img src="<?= htmlspecialchars($imageBasePath . $row['image_path']) ?>" alt="Psychologist Image" style="max-width: 100px; height: auto;">
                        <?php else: ?>
                            No Image
                        <?php endif; ?>
                    </td>
                    <td class="actions">
                        <!-- Edit Button with Pencil Icon -->
                        <div class="box-actions">
                        <form action="edit-psikolog.php" method="GET" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $row['psychologist_id'] ?>">
                            <button type="submit" class="btn btn-primary btn-sm" title="Edit">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                        </form>
                        <!-- Delete Button with Trash Icon -->
                        <form action="" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $row['psychologist_id'] ?>">
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this psychologist?');" title="Delete">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                        </div>
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
                    <a class="page-link" href="?page=<?= $page - 1 ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $page + 1 ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>

    <!-- Add New Psychologist Button -->
    <div class="text-center mt-4">
        <a href="create-psikolog.php" class="btn btn-success">Add New Psychologist</a>
    </div>
</div>

<!-- Bootstrap 4.3 JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<?php
include '../inc/inc_adminfooter.php';
?>