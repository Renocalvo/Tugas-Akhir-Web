<?php
require_once '../inc/inc_connection.php';
$pageTitle = "Add Question - Healpoint";
include '../inc/inc_adminheader.php';

// Fetch available categories
$category_query = "SELECT * FROM category";
$category_result = mysqli_query($koneksi, $category_query);

// Default values for answers
$default_answers = [
    "Tidak pernah",
    "Setidaknya beberapa kali dalam setahun",
    "Setidaknya sebulan sekali",
    "Beberapa kali dalam sebulan",
    "Seminggu sekali",
    "Beberapa kali seminggu",
];

// Proses penyimpanan jika form dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_id = (int)$_POST['category_id'];
    $question_text = mysqli_real_escape_string($koneksi, $_POST['question_text']);
    $answers = array_map(function ($answer) use ($koneksi) {
        return mysqli_real_escape_string($koneksi, $answer);
    }, $_POST['answers']);

    $query = "
        INSERT INTO questions (category_id, question_text, answer1, answer2, answer3, answer4, answer5, answer6)
        VALUES ($category_id, '$question_text', '{$answers[0]}', '{$answers[1]}', '{$answers[2]}', '{$answers[3]}', '{$answers[4]}', '{$answers[5]}')
    ";

    if (mysqli_query($koneksi, $query)) {
        header("Location: index-questions.php?category_id=$category_id");
        exit();
    } else {
        die("Error: " . mysqli_error($koneksi));
    }
}
?>

<div class="container my-5">
    <h1 class="text-center">Add New Question</h1>
    <hr>
    <form method="POST" action="">
        <!-- Dropdown untuk kategori -->
        <div class="form-group">
            <label for="category">Select Category</label>
            <select name="category_id" id="category" class="form-control" required>
                <option value="" disabled selected>Select a category</option>
                <?php while ($category = mysqli_fetch_assoc($category_result)): ?>
                    <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['category_name']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <!-- Input pertanyaan -->
        <div class="form-group">
            <label for="question_text">Question</label>
            <textarea name="question_text" id="question_text" class="form-control" rows="3" placeholder="Enter the question text" required></textarea>
        </div>

        <!-- Input jawaban -->
        <div class="form-group">
            <label>Answers</label>
            <?php foreach ($default_answers as $index => $default_answer): ?>
                <input type="text" name="answers[]" class="form-control mb-2" value="<?= htmlspecialchars($default_answer) ?>" required>
            <?php endforeach; ?>
        </div>


        <!-- Tombol submit -->
        <div class="text-center">
            <button type="submit" class="btn btn-success">Save Question</button>
            <a href="index-questions.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<!-- Bootstrap 4.3 JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<?php include '../inc/inc_adminfooter.php'; ?>
