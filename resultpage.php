<?php
session_start();
require_once './inc/inc_connection.php';
if (!isset($_SESSION['user_id'])) {
    echo "Anda harus login untuk melihat hasil kuis.";
    exit();
}


$user_id = $_SESSION['user_id'];

// Ambil hasil kuis terbaru untuk pengguna yang login
$sql = "SELECT * FROM results WHERE user_id = ? ORDER BY created_at DESC LIMIT 1";
$stmt = mysqli_prepare($koneksi, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$quiz_result = mysqli_fetch_assoc($result);
?>


<!DOCTYPE html>
<html lang="id">

<head>
  <link rel="stylesheet" type="text/css" href="style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <meta charset="UTF-8">
  <title>Hasil Kuis</title>
</head>

<body>
  <section>
    <div class="container-fluid"
      style="color:white; background:url(assets/6205209.jpg); justify-content: center; align-items: center; display: flex; flex-direction: column; background-size:cover;">
      <div class="container mt-5"
        style="max-width: 70%; justify-content: center; align-items: center; display: flex; flex-direction: column;">
        <h4>Hasil Test Psikologi Burn-out</h4>
        <?php if ($quiz_result): ?>
        <h3>Skor Anda: <?php echo $quiz_result['score']; ?></h3>
        <?php 
          if ($quiz_result['score'] > 75) {
              echo "<p>Status: <strong>Sehat</strong></p>";
          } elseif ($quiz_result['score'] > 55) {
              echo "<p>Status: <strong>Bermasalah</strong></p>";
          } else {
              echo "<p>Status: <strong>Anda butuh pertolongan</strong></p>";
          }
        ?>
        <span>Tanggal Tes: <?php echo $quiz_result['created_at']; ?></span>

        <?php else: ?>
        <p>Anda belum mengikuti tes.</p>
        <?php endif; ?>

        <img src="assets/rb_2318.png"
          style="filter: drop-shadow(5px 5px black); background-color: transparent; border: none; max-width: 50vh;"
          class="img-thumbnail mt-3" alt="...">
        <h5>
          Terima kasih telah meluangkan waktu untuk mengikuti tes psikologi di situs kami. Partisipasi Anda
          sangat berharga dan membantu kami dalam menyediakan informasi yang relevan dan bermanfaat. Semoga
          hasil tes ini dapat memberikan wawasan baru untuk perkembangan pribadi Anda. Teruslah berkembang
          bersama kami!
        </h5>
        <button type="button" id="btn-home" class="btn btn-primary my-5"
          style="color: black; background-color: #FF9292;">Kembali ke Home</button>
      </div>

    </div>
  </section>
  <?php 
    include './inc/inc_footer.php'; 
?>

</html>