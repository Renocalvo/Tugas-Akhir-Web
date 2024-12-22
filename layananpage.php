<?php 
    $pageTitle = "layanan Page - Healpoint";
    include './inc/inc_header.php'; 
?>
<section>
    <div class="container-fluid tag-layanan">
        <div class="row" style="background-color: white; padding: 30px 0 20px 0;">
            <div class="col-md-3 pl-5">
                <img src="assets/layananpage.png" width="200" class="img-thumbnail"
                    style="background-color: transparent; border: none;" alt="...">
            </div>
            <div class="col-md-6">
                <div class="container container-title-layanan">
                    <h2 class="text-center mt-5"
                        style=" background: linear-gradient(90deg, #000, #BB8446); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                        Tes Psikologi Burn-out</h2>
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
    <div class="container-fluid">
        <div class="container my-5 p-5 bg-white" style="border-radius: 15px;">
        
            <div class="form-container">
                <div id="snackbar" class="snackbar">This is a snackbar alert!</div>
                <?php
                    require_once "./inc/inc_connection.php";

                    if (isset($_POST["submit"])) {
                        $age = $_POST["age"];
                        $gender = $_POST["gender"];
                        $location = $_POST["location"];
                        $job = $_POST["job"];
                        
                        $errors = array();

                        // Validasi input
                        if (empty($age) || empty($gender) || empty($location) || empty($job)) {
                            array_push($errors, "Semua kolom harus diisi.");
                        }
                        if (!is_numeric($age) || $age <= 0) {
                            array_push($errors, "Usia harus berupa angka positif.");
                        }

                        // Cek login pengguna
                        if (!isset($_SESSION['user_id'])) {
                            array_push($errors, "Anda harus login terlebih dahulu untuk mengirim data.");
                        } else {
                            $user_id = $_SESSION['user_id'];
                        }

                        // Jika ada error, tampilkan dengan snackbar
                        if (count($errors) > 0) {
                            $jsErrors = json_encode($errors);
                            echo "<script>showSnackbar($jsErrors, 'error');</script>";
                        } else {
                            // Cek apakah data user sudah ada
                            $checkQuery = "SELECT * FROM user_info WHERE user_id = ?";
                            $checkStmt = mysqli_stmt_init($koneksi);

                            if (mysqli_stmt_prepare($checkStmt, $checkQuery)) {
                                mysqli_stmt_bind_param($checkStmt, "i", $user_id);
                                mysqli_stmt_execute($checkStmt);
                                $result = mysqli_stmt_get_result($checkStmt);

                                if (mysqli_num_rows($result) > 0) {
                                    $sql = "UPDATE user_info SET age = ?, gender = ?, location = ?, job = ? WHERE user_id = ?";
                                    $stmt = mysqli_stmt_init($koneksi);

                                    if (mysqli_stmt_prepare($stmt, $sql)) {
                                        mysqli_stmt_bind_param($stmt, "isssi", $age, $gender, $location, $job, $user_id);
                                        mysqli_stmt_execute($stmt);

                                        echo "<script>
                                                window.location.href = 'quizpage.php';
                                            </script>";
                                    } else {
                                        die("Terjadi kesalahan saat memperbarui data.");
                                    }
                                } else {
                                    $sql = "INSERT INTO user_info (user_id, age, gender, location, job) VALUES (?, ?, ?, ?, ?)";
                                    $stmt = mysqli_stmt_init($koneksi);

                                    if (mysqli_stmt_prepare($stmt, $sql)) {
                                        mysqli_stmt_bind_param($stmt, "iisss", $user_id, $age, $gender, $location, $job);
                                        mysqli_stmt_execute($stmt);

                                        echo "<script>
                                                showSnackbar(['Data berhasil disimpan.'], 'success');
                                                setTimeout(function() {
                                                    window.location.href = 'quizpage.php';
                                                }, 2000);
                                            </script>";
                                    } else {
                                        die("Terjadi kesalahan saat menyimpan data.");
                                    }
                                }
                            }
                        }
                    }
                ?>



                <form action="layananpage.php" method="POST" class="form-layanan">
                    <div class="form-group-layanan mb-3">
                        <label for="age-form">Usia<span class="required-dot">*</span></label>
                        <input type="text" name="age" class="form-control" id="age-form"
                            placeholder="Masukkan usia Anda" required>
                    </div>
                    <div class="form-group-layanan mb-3">
                        <label for="gender-dropdown">Gender Biologis<span class="required-dot">*</span></label>
                        <select class="custom-select" id="gender-dropdown" name="gender" required>
                            <option selected disabled>Pilih Gender Kamu..</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group-layanan mb-3">
                        <label for="location-form">Domisili/Daerah tempat tinggal saat ini<span
                                class="required-dot">*</span></label>
                        <input type="text" name="location" class="form-control" id="location-form"
                            placeholder="Masukkan lokasi Anda" required>
                    </div>
                    <div class="form-group-layanan mb-3">
                        <label for="job-form">Pekerjaan<span class="required-dot">*</span></label>
                        <input type="text" name="job" class="form-control" id="job-form"
                            placeholder="Masukkan pekerjaan Anda" required>
                    </div>

                    <button type="submit" name="submit" class="btn btn-primary mt-5 mb-3 btn-lg btn-block"
                        style="color: black; background-color: #FF9292; border:none;">Selanjutnya</button>
                </form>

            </div>


        </div>

    </div>
</section>
<?php 
    include './inc/inc_footer.php'; 
?>