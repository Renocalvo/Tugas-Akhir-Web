<?php
require_once 'inc/inc_connection.php';
$pageTitle = "Users Admin Panel - Healpoint";
include './inc/inc_adminheader.php';

$records_per_page = 10;

// Get the current page number from the query string, default to 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $records_per_page;

// Query to get the total number of records
$total_query = "SELECT COUNT(*) AS total FROM users";
$total_result = mysqli_query($koneksi, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $records_per_page);

// Query to fetch data with pagination
$query = "
    SELECT 
        u.id AS user_id,
        u.full_name AS user_full_name,
        u.email AS user_email
    FROM 
        users u
    ORDER BY 
        u.id
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
            <?php foreach ($results as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['user_id']) ?></td>
                    <td><?= htmlspecialchars($row['user_full_name']) ?></td>
                    <td><?= htmlspecialchars($row['user_email']) ?></td>
                    <td class="actions">
                        <!-- Delete Button with Trash Icon -->
                        <form action="delete-user.php" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $row['user_id'] ?>">
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?');" title="Delete">
                                <i class="fas fa-trash-alt"></i> <!-- Font Awesome trash icon -->
                            </button>
                        </form>
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

</div>

<!-- Bootstrap 4.3 JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<?php 
    include './inc/inc_adminfooter.php'; 
?>

