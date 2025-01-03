<?php
require_once '../inc/inc_connection.php';
$pageTitle = "Result Page - Healpoint";
include '../inc/inc_header.php';

if (!isset($_SESSION['user_id'])) {
  echo "Anda harus login untuk melihat hasil kuis.";
  exit();
}

$user_id = $_SESSION['user_id'];

// Ambil hasil terbaru untuk pengguna yang login
$sql_latest = "SELECT score, created_at FROM results WHERE user_id = ? ORDER BY created_at DESC LIMIT 1";
$stmt_latest = mysqli_prepare($koneksi, $sql_latest);
mysqli_stmt_bind_param($stmt_latest, "i", $user_id);
mysqli_stmt_execute($stmt_latest);
$result_latest = mysqli_stmt_get_result($stmt_latest);
$latest_result = mysqli_fetch_assoc($result_latest);

// Ambil semua hasil kuis untuk grafik
$sql_all = "SELECT score, created_at FROM results WHERE user_id = ? ORDER BY created_at ASC";
$stmt_all = mysqli_prepare($koneksi, $sql_all);
mysqli_stmt_bind_param($stmt_all, "i", $user_id);
mysqli_stmt_execute($stmt_all);
$result_all = mysqli_stmt_get_result($stmt_all);

// Buat array untuk data grafik
$scores = [];
$timestamps = [];

while ($row = mysqli_fetch_assoc($result_all)) {
  $scores[] = $row['score'];
  $timestamps[] = $row['created_at'];
}

// Ambil jumlah data berdasarkan status
$sql_status = "SELECT status, COUNT(*) as total FROM results WHERE user_id = ? GROUP BY status";
$stmt_status = mysqli_prepare($koneksi, $sql_status);
mysqli_stmt_bind_param($stmt_status, "i", $user_id);
mysqli_stmt_execute($stmt_status);
$result_status = mysqli_stmt_get_result($stmt_status);

// Siapkan data untuk pie chart
$status_data = [
  'sehat' => 0,
  'bermasalah' => 0,
  'sakit' => 0,
];
$total_results = 0;

while ($row = mysqli_fetch_assoc($result_status)) {
    $status_data[$row['status']] = $row['total'];
    $total_results += $row['total'];
}

// Hitung persentase
$status_percentages = [];
foreach ($status_data as $status => $count) {
    $status_percentages[$status] = ($count / $total_results) * 100;
}

// Encode data ke JavaScript
$status_labels = json_encode(array_keys($status_percentages)); // Label (sehat, bermasalah, sakit)
$status_values = json_encode(array_values($status_percentages)); // Nilai persentase


?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
  .chart-card {
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    max-width: 500px; 
    height: 400px;
    padding: 10px 10px 10px 10px;
    margin: 20px auto;
    justify-content: center;
    align-items: center;
  }

  .chart-card canvas {
    width: 100% !important;
    height: 100% !important;
  }

  .chart-card h5 {
    text-align: center;
    margin-bottom: 15px;
    font-weight: bold;
    color: #333;
  }
</style>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<section>
  <div class="container-fluid"
    style="color:black;  justify-content: center; align-items: center; display: flex; flex-direction: column; background-size:cover;">
    <div class="container mt-5"
      style=" justify-content: center; align-items: center; display: flex; flex-direction: column;">
      <h4>Hasil Test Psikologi</h4>
      <?php if ($latest_result): ?>
        <h3>Skor Anda: <?php echo $latest_result['score']; ?></h3>
        <?php
        if ($latest_result['score'] > 75) {
          echo "<div class='alert alert-success' role='alert'>
            <strong>Status:</strong> Sehat
          </div>";
        } elseif ($latest_result['score'] > 55) {
          echo "<div class='alert alert-warning' role='alert'>
            <strong>Status:</strong> Bermasalah
          </div>";
        } else {
          echo "<div class='alert alert-danger' role='alert'>
            <strong>Status:</strong> Anda butuh pertolongan
          </div>";
        }
        ?>


        <div class="row justify-content-center mt-4">
          <div class="col-lg-7">
            <div class="chart-card py-5">
              <h5>Grafik Perkembangan Skor Anda</h5>
              <canvas id="quizChart"></canvas>
            </div>
          </div>
          <div class="col-lg-5">
            <div class="chart-card py-5">
              <h5>Progres Status Anda</h5>
              <canvas id="pieChart"></canvas>
            </div>
          </div>
        </div>

      <?php else: ?>
        <p>Anda belum mengikuti tes.</p>
      <?php endif; ?>

      <!-- <img src="../assets/rb_2318.png"
          style="filter: drop-shadow(5px 5px black); background-color: transparent; border: none; max-width: 50vh;"
          class="img-thumbnail mt-3" alt="..."> -->


      <div class="mx-5 my-5">
        <blockquote class="blockquote text-center">
          <p class="mb-0">Terima kasih telah meluangkan waktu untuk mengikuti tes psikologi di situs kami. Partisipasi Anda
            sangat berharga dan membantu kami dalam menyediakan informasi yang relevan dan bermanfaat. Semoga
            hasil tes ini dapat memberikan wawasan baru untuk perkembangan pribadi Anda. Teruslah berkembang
            bersama kami!</p>
            <footer class="blockquote-footer">Your partners <cite title="Source Title">Healtpoint</cite></footer>
        </blockquote>
      </div>
    </div>

  </div>
</section>

<!-- Tambahkan Script untuk Chart.js -->
<script>
  // Data dari PHP
  const timestamps = <?php echo json_encode($timestamps); ?>; // Tanggal tes
  const scores = <?php echo json_encode($scores); ?>; // Skor
  const pieLabels = <?php echo $status_labels; ?>; // Labels dari PHP
const pieData = <?php echo $status_values; ?>; // Persentase dari PHP

  // Buat grafik menggunakan Chart.js
  const ctxLine = document.getElementById('quizChart').getContext('2d');
  const quizChart = new Chart(ctxLine, {
    type: 'line',
    data: {
      labels: timestamps,
      datasets: [{
        label: 'Skor Tes',
        data: scores,
        borderColor: 'rgba(75, 192, 192, 1)',
        backgroundColor: 'rgba(75, 192, 192, 0.2)',
        borderWidth: 2,
        tension: 0.3,
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        x: {
          title: {
            display: true,
            text: 'Tanggal Tes'
          }
        },
        y: {
          beginAtZero: true,
          title: {
            display: true,
            text: 'Skor'
          }
        }
      }
    }
  });

  // Grafik Pie Chart
  const ctxPie = document.getElementById('pieChart').getContext('2d');
const pieChart = new Chart(ctxPie, {
    type: 'pie',
    data: {
        labels: pieLabels, // Status (sehat, bermasalah, sakit)
        datasets: [{
            label: 'Status Kesehatan Mental',
            data: pieData, // Persentase status
            backgroundColor: [
                'rgba(75, 192, 192, 0.6)', // Sehat (Hijau)
                'rgba(255, 206, 86, 0.6)', // Bermasalah (Kuning)
                'rgba(255, 99, 132, 0.6)'  // Sakit (Merah)
            ],
            borderColor: [
                'rgba(75, 192, 192, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(255, 99, 132, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
                labels: {
                    color: '#333',
                    font: {
                        size: 14,
                        family: "'Arial', sans-serif"
                    }
                }
            }
        }
    }
});
</script>

<?php
include '../inc/inc_footer.php';
?>