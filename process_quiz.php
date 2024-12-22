<?php
session_start();
require_once './inc/inc_connection.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "Anda harus login untuk mengirim hasil kuis.";
    exit();
}

$user_id = intval($_SESSION['user_id']);
$answers = $_POST['answers'];
$score = 0;

// Fetch the number of questions from the database
$sql = "SELECT COUNT(*) AS total_questions FROM questions";
$result = mysqli_query($koneksi, $sql);
$row = mysqli_fetch_assoc($result);
$num_questions = intval($row['total_questions']);

if ($num_questions === 0) {
    echo "Terjadi kesalahan: Tidak ada soal yang ditemukan.";
    exit();
}

// Define the highest weight as 6 and the lowest as 1
// Adjust weights dynamically based on the number of questions
$base_weight = 6;
$answer_weights = [];
for ($i = 1; $i <= 6; $i++) {
    $answer_weights[$i] = intval(($base_weight - $i + 1) * (100 / ($num_questions * $base_weight)));
}

// Calculate the score
foreach ($answers as $question_id => $answer) {
    $score += $answer_weights[intval($answer)];
}

// Calculate the percentage score and use it as the score
$score = intval($score); // Ensure score is parsed as an integer

// Prepare the SQL query to save score in the database
$sql = "INSERT INTO results (user_id, score) VALUES (?, ?)";
$stmt = mysqli_prepare($koneksi, $sql);

if ($stmt) {
    // Bind the parameters to the SQL query and execute
    mysqli_stmt_bind_param($stmt, "ii", $user_id, $score);
    mysqli_stmt_execute($stmt);

    // Success message with score percentage
    echo "<script>
            alert('Hasil kuis Anda berhasil disimpan. Skor Anda adalah $score%.');
            window.location.href = 'resultpage.php';
          </script>";
} else {
    // Handle SQL preparation error
    echo "Terjadi kesalahan saat menyimpan hasil. Silakan coba lagi nanti.";
}

$koneksi->close();
?>
