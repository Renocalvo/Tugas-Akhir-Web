<?php
// Pastikan user login dan data tersedia
session_start();
require_once '../inc/inc_connection.php';

if (!isset($_SESSION['user_id'])) {
    echo "Anda harus login untuk mengirim hasil kuis.";
    exit();
}

$user_id = intval($_SESSION['user_id']);
$answers = $_POST['answers'];

// Ambil jumlah total pertanyaan
$sql = "SELECT COUNT(*) AS total_questions FROM questions";
$result = mysqli_query($koneksi, $sql);
$row = mysqli_fetch_assoc($result);
$total_questions = intval($row['total_questions']);

if ($total_questions === 0) {
    echo "Terjadi kesalahan: Tidak ada soal yang ditemukan.";
    exit();
}

// Hitung skor berdasarkan jawaban
$max_value_per_question = $total_questions / 5; // Nilai maksimum untuk jawaban 6
$total_score = 0;

foreach ($answers as $answer) {
    $answer = intval($answer);
    $total_score += (($answer - 1) * $max_value_per_question) / 5;
}

// Hitung skor akhir dalam bentuk persentase
$max_possible_score = $total_questions * $max_value_per_question;
$final_score = 100 - (($total_score / $max_possible_score) * 100);
$final_score = round($final_score);

// Simpan hasil ke database
$sql = "INSERT INTO results (user_id, score) VALUES (?, ?)";
$stmt = mysqli_prepare($koneksi, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "ii", $user_id, $final_score);
    mysqli_stmt_execute($stmt);

    echo "<script>
            alert('Hasil kuis Anda berhasil disimpan. Skor Anda adalah $final_score%.');
            window.location.href = 'resultpage.php';
          </script>";
} else {
    echo "Terjadi kesalahan saat menyimpan hasil. Silakan coba lagi nanti.";
}

$koneksi->close();

?>
