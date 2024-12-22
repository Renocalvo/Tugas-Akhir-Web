<?php 
$pageTitle = "Quitioner Page - Healpoint";
include './inc/inc_header.php'; 
require_once './inc/inc_connection.php';

// Pastikan pengguna login
if (!isset($_SESSION['user_id'])) {
    echo "Anda harus login untuk mengakses halaman ini.";
    exit();
}

// Ambil soal-soal dari tabel questions
$sql = "SELECT * FROM questions";
$result = mysqli_query($koneksi, $sql);
?>

<section>
    <div class="container-fluid tag-layanan" style="background-color:white;">
        <div class="row" style="background-color: white; padding: 30px 0 20px 0;">
            <!-- Header Page -->
            <div class="col-md-3 pl-5">
                <img src="assets/layananpage.png" width="200" class="img-thumbnail"
                    style="background-color: transparent; border: none;" alt="...">
            </div>
            <div class="col-md-6">
                <div class="container container-title-klinik">
                    <h2 class="text-center mt-5"
                        style="background: linear-gradient(90deg, #000, #BB8446); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                        Klinik Psikolog</h2>
                    <hr style=" border-width: 3px; width: 100%; background-color: #000;">
                </div>
            </div>
            <div class="col-md-3 pl-5">
                <img src="assets/layananpage1.png" width="270" style="background-color: transparent; border: none;"
                    class="img-thumbnail" alt="...">
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container-fluid mb-5">
        <div class="container bg-white mt-5 p-3" style="width: 70%; border-radius: 15px;">
            <div class="container mt-5 mb-5 p-3" style="width: 80%; background-color: #D9D9D9; border-radius: 10px;">
                <p>
                    Bagaimana Anda memandang pekerjaan Anda? Apakah Anda kelelahan? Seberapa mampukah Anda membangun
                    hubungan Anda dengan orang lain? Sejauh mana diri Anda secara pribadi terpenuhi? Tunjukkan
                    seberapa sering pernyataan-pernyataan berikut terjadi pada Anda. Pilihlah jawaban yang paling
                    sesuai dengan diri Anda.
                </p>
            </div>
            <form action="process_quiz.php" method="POST">
                <div class="container container-question">
                    <ol class="ml-5">
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <li>
                                <?php echo $row['question_text']; ?>
                                <div class="container box-multiple" style="display: inline;">
                                    <?php for ($i = 1; $i <= 6; $i++): ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" 
                                                   name="answers[<?php echo $row['id']; ?>]" 
                                                   id="answer<?php echo $row['id'] . '_' . $i; ?>" 
                                                   value="<?php echo $i; ?>" required>
                                            <label class="form-check-label" for="answer<?php echo $row['id'] . '_' . $i; ?>">
                                                <?php echo $row["answer$i"]; ?>
                                            </label>
                                        </div>
                                    <?php endfor; ?>
                                </div>
                            </li>
                        <?php endwhile; ?>
                    </ol>
                </div>
                <div class="container mb-5" style="justify-content: center; align-items: center; display: flex; gap: 40px;">
                    <a href="layananpage.php" type="button" class="btn btn-primary btn-lg" style="background-color: #FF9292; width: 50vh; color: black;">Sebelumnya</a>
                    <button type="submit" name="submit" class="btn btn-primary btn-lg" style="background-color: #FF9292; width: 50vh; color: #000;">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</section>
<?php 
    include './inc/inc_footer.php'; 
?>