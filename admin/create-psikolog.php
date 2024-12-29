<?php
require_once '../inc/inc_adminheader.php';
require_once '../inc/inc_connection.php';
$pageTitle = "Create Psychologist - Healpoint";

// Validasi pengguna admin
if (!isset($_SESSION['user_id'])) {
    header("Location: ../users/login.php");
    exit();
}

// Tangani permintaan untuk menambahkan psikolog baru
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_changes'])) {
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $specialization = isset($_POST['specialization']) ? $_POST['specialization'] : '';
    $bio = isset($_POST['bio']) ? $_POST['bio'] : '';
    $contact = isset($_POST['contact']) ? $_POST['contact'] : '';
    $image_path = null;

    // Validasi koneksi database
    if (!$koneksi) {
        error_log("Database connection failed: " . mysqli_connect_error());
        header("Location: index-psikolog.php?error=Database+connection+failed");
        exit();
    }

    // Tangani pengunggahan file jika ada
    if (!empty($_FILES['image']['name'])) {
        $upload_dir = '../assets/images/';
        $file_name = basename($_FILES['image']['name']);
        $image_path = $upload_dir . $file_name;

        // Pindahkan file yang diunggah
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
            error_log("Failed to upload image.");
            header("Location: create-psikolog.php?error=Failed+to+upload+image");
            exit();
        }

        // Simpan path dalam bentuk relatif untuk disimpan ke database
        $image_path_db = 'assets/images/' . $file_name;
    }

    // Masukkan data psikolog ke tabel psychologists
    $insert_query = "
        INSERT INTO psychologists (name, specialization, bio, contact) 
        VALUES (?, ?, ?, ?)
    ";
    if ($stmt = mysqli_prepare($koneksi, $insert_query)) {
        mysqli_stmt_bind_param($stmt, 'ssss', $name, $specialization, $bio, $contact);

        if (mysqli_stmt_execute($stmt)) {
            // Dapatkan ID psikolog yang baru ditambahkan
            $psychologist_id = mysqli_insert_id($koneksi);

            // Tambahkan gambar ke tabel psychologist_images jika ada
            if (!empty($image_path_db)) {
                $image_query = "
                    INSERT INTO psychologist_images (psychologist_id, image_path) 
                    VALUES (?, ?)
                ";
                $stmt_image = mysqli_prepare($koneksi, $image_query);
                mysqli_stmt_bind_param($stmt_image, 'is', $psychologist_id, $image_path_db);

                if (!mysqli_stmt_execute($stmt_image)) {
                    error_log("Failed to insert image: " . mysqli_error($koneksi));
                    header("Location: create-psikolog.php?error=Failed+to+insert+image");
                    exit();
                }
                mysqli_stmt_close($stmt_image);
            }

            header("Location: index-psikolog.php?success=Psychologist+created+successfully");
            exit();
        } else {
            error_log("Failed to insert psychologist: " . mysqli_error($koneksi));
            header("Location: create-psikolog.php?error=Failed+to+insert+psychologist");
            exit();
        }
        mysqli_stmt_close($stmt);
    }
}
?>

<div class="container my-5">
    <h1>Add New Psychologist</h1>
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="save_changes" value="1">

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="form-group">
            <label for="specialization">Specialization</label>
            <input type="text" class="form-control" id="specialization" name="specialization" required>
        </div>

        <div class="form-group">
            <label for="bio">Bio</label>
            <textarea class="form-control" id="bio" name="bio" rows="4" required></textarea>
        </div>

        <div class="form-group">
            <label for="contact">Contact</label>
            <input type="text" class="form-control" id="contact" name="contact" required>
        </div>

        <div class="form-group">
            <label for="image">Image</label><br>
            <input type="file" class="form-control-file mt-2" id="image" name="image" accept="image/*">
        </div>

        <button type="submit" class="btn btn-success">Save</button>
        <a href="index-psikolog.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<!-- Bootstrap 4.3 JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<?php 
include '../inc/inc_adminfooter.php'; 
?>
