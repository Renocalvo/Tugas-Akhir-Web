<?php
require_once 'inc/inc_connection.php';
$pageTitle = "Manage Questions - Healpoint";
include './inc/inc_adminheader.php';

$records_per_page = 10;

// Get the current page number from the query string, default to 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $records_per_page;

// Fetch available categories (like "Burnout")
$category_query = "SELECT * FROM category";
$category_result = mysqli_query($koneksi, $category_query);

// Fetch questions based on selected category
$selected_category = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 1; // Default to category 1 (e.g., Burnout)
$query = "
    SELECT * 
    FROM questions
    WHERE category_id = $selected_category
    LIMIT $offset, $records_per_page
";
$result = mysqli_query($koneksi, $query);

// Check if the query was successful
if (!$result) {
    die("Query failed: " . mysqli_error($koneksi));
}

// Save query results into an array
$questions = [];
while ($row = mysqli_fetch_assoc($result)) {
    $questions[] = $row;
}

// Get total number of questions for pagination
$total_query = "SELECT COUNT(*) AS total FROM questions WHERE category_id = $selected_category";
$total_result = mysqli_query($koneksi, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $records_per_page);
?>

<div class="container my-4">
    <h1>Manage Questions - Admin Panel</h1>

    <!-- Category Dropdown -->
    <div class="mb-3">
        <form action="" method="GET">
            <label for="category">Select Category:</label>
            <select name="category_id" id="category" class="form-control" onchange="this.form.submit()">
                <?php while ($category = mysqli_fetch_assoc($category_result)): ?>
                    <option value="<?= $category['id'] ?>" <?= $category['id'] == $selected_category ? 'selected' : '' ?>>
                        <?= htmlspecialchars($category['category_name']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </form>
    </div>

    <!-- Questions Table -->
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>Question</th>
                <th>Answer 1</th>
                <th>Answer 2</th>
                <th>Answer 3</th>
                <th>Answer 4</th>
                <th>Answer 5</th>
                <th>Answer 6</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($questions as $question): ?>
                <tr>
                    <td><?= htmlspecialchars($question['question_text']) ?></td>
                    <td><?= htmlspecialchars($question['answer1']) ?></td>
                    <td><?= htmlspecialchars($question['answer2']) ?></td>
                    <td><?= htmlspecialchars($question['answer3']) ?></td>
                    <td><?= htmlspecialchars($question['answer4']) ?></td>
                    <td><?= htmlspecialchars($question['answer5']) ?></td>
                    <td><?= htmlspecialchars($question['answer6']) ?></td>
                    <td>
                        <!-- Edit Button -->
                        <a href="edit-question.php?id=<?= $question['id'] ?>" class="btn btn-primary btn-sm" title="Edit">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <!-- Delete Button -->
                        <form action="delete-question.php" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $question['id'] ?>">
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this question?');" title="Delete">
                                <i class="fas fa-trash-alt"></i>
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
                    <a class="page-link" href="?category_id=<?= $selected_category ?>&page=<?= $page - 1 ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                    <a class="page-link" href="?category_id=<?= $selected_category ?>&page=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
                <li class="page-item">
                    <a class="page-link" href="?category_id=<?= $selected_category ?>&page=<?= $page + 1 ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>

    <!-- Add New Question Button -->
    <div class="text-center mt-4">
        <a href="create-question.php?category_id=<?= $selected_category ?>" class="btn btn-success">Add New Question</a>
    </div>
</div>

<!-- Bootstrap 4.3 JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<?php include './inc/inc_adminfooter.php'; ?>
