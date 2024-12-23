<?php
require_once '../inc/inc_connection.php'; // Include database connection
$pageTitle = "Edit Question - Healpoint";
include '../inc/inc_adminheader.php';

// Get the question ID from the query string
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch question data based on ID
$query = "SELECT * FROM questions WHERE id = $id";
$result = mysqli_query($koneksi, $query);

// Check if the question exists
if (!$result || mysqli_num_rows($result) == 0) {
    die("Question not found.");
}

$question = mysqli_fetch_assoc($result);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $question_text = mysqli_real_escape_string($koneksi, $_POST['question_text']);
    $answer1 = mysqli_real_escape_string($koneksi, $_POST['answer1']);
    $answer2 = mysqli_real_escape_string($koneksi, $_POST['answer2']);
    $answer3 = mysqli_real_escape_string($koneksi, $_POST['answer3']);
    $answer4 = mysqli_real_escape_string($koneksi, $_POST['answer4']);
    $answer5 = mysqli_real_escape_string($koneksi, $_POST['answer5']);
    $answer6 = mysqli_real_escape_string($koneksi, $_POST['answer6']);

    // Update query
    $update_query = "
        UPDATE questions 
        SET 
            question_text = '$question_text',
            answer1 = '$answer1',
            answer2 = '$answer2',
            answer3 = '$answer3',
            answer4 = '$answer4',
            answer5 = '$answer5',
            answer6 = '$answer6'
        WHERE id = $id
    ";

    if (mysqli_query($koneksi, $update_query)) {
        header("Location: manage-questions.php?message=Question+updated+successfully");
        exit();
    } else {
        die("Update failed: " . mysqli_error($koneksi));
    }
}
?>

<div class="container my-5">
    <h1>Edit Question</h1>
    <form action="edit-question.php?id=<?= $id ?>" method="POST">
        <div class="form-group">
            <label for="question_text">Question</label>
            <textarea class="form-control" id="question_text" name="question_text" rows="3" required><?= htmlspecialchars($question['question_text']) ?></textarea>
        </div>

        <div class="form-group">
            <label for="answer1">Answer 1</label>
            <input type="text" class="form-control" id="answer1" name="answer1" value="<?= htmlspecialchars($question['answer1']) ?>" required>
        </div>

        <div class="form-group">
            <label for="answer2">Answer 2</label>
            <input type="text" class="form-control" id="answer2" name="answer2" value="<?= htmlspecialchars($question['answer2']) ?>" required>
        </div>

        <div class="form-group">
            <label for="answer3">Answer 3</label>
            <input type="text" class="form-control" id="answer3" name="answer3" value="<?= htmlspecialchars($question['answer3']) ?>" required>
        </div>

        <div class="form-group">
            <label for="answer4">Answer 4</label>
            <input type="text" class="form-control" id="answer4" name="answer4" value="<?= htmlspecialchars($question['answer4']) ?>" required>
        </div>

        <div class="form-group">
            <label for="answer5">Answer 5</label>
            <input type="text" class="form-control" id="answer5" name="answer5" value="<?= htmlspecialchars($question['answer5']) ?>" required>
        </div>

        <div class="form-group">
            <label for="answer6">Answer 6</label>
            <input type="text" class="form-control" id="answer6" name="answer6" value="<?= htmlspecialchars($question['answer6']) ?>" required>
        </div>

        <button type="submit" class="btn btn-success">Save Changes</button>
        <a href="manage-questions.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<!-- Bootstrap 4.3 JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<?php include '../inc/inc_adminfooter.php'; ?>
