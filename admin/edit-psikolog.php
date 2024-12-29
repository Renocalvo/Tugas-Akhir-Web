<?php
require_once '../inc/inc_adminheader.php';
require_once '../inc/inc_connection.php';
$pageTitle = "Edit Psychologist - Healpoint";

// Validasi pengguna admin
if (!isset($_SESSION['user_id'])) {
    header("Location: ../users/login.php");
    exit();
}

// Tangani permintaan update menggunakan metode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_changes'])) {
    $id = isset($_POST['psychologist_id']) ? (int)$_POST['psychologist_id'] : 0;
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
            header("Location: edit-psikolog.php?id=$id&error=Failed+to+upload+image");
            exit();
        }

        // Simpan path dalam bentuk relatif untuk disimpan ke database
        $image_path_db = 'assets/images/' . $file_name;

        // Masukkan atau perbarui gambar di tabel psychologist_images
        $image_query = "
            INSERT INTO psychologist_images (psychologist_id, image_path) 
            VALUES (?, ?)
            ON DUPLICATE KEY UPDATE image_path = VALUES(image_path)
        ";
        $stmt_image = mysqli_prepare($koneksi, $image_query);
        mysqli_stmt_bind_param($stmt_image, 'is', $id, $image_path_db);

        if (!mysqli_stmt_execute($stmt_image)) {
            error_log("Failed to update image: " . mysqli_error($koneksi));
            header("Location: edit-psikolog.php?id=$id&error=Failed+to+update+image");
            exit();
        }
        mysqli_stmt_close($stmt_image);
    }

    // Update data psikolog
    $update_query = "
        UPDATE psychologists 
        SET 
            name = ?, 
            specialization = ?, 
            bio = ?, 
            contact = ?
        WHERE id = ?
    ";

    if ($stmt = mysqli_prepare($koneksi, $update_query)) {
        mysqli_stmt_bind_param($stmt, 'ssssi', $name, $specialization, $bio, $contact, $id);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: index-psikolog.php?success=Psychologist+updated+successfully");
            exit();
        } else {
            error_log("Failed to update psychologist: " . mysqli_error($koneksi));
            header("Location: edit-psikolog.php?id=$id&error=Failed+to+update+psychologist");
            exit();
        }
        mysqli_stmt_close($stmt);
    }
}

// Fetch psychologist data
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$query = "
    SELECT p.*, i.image_path 
    FROM psychologists p 
    LEFT JOIN psychologist_images i 
    ON p.id = i.psychologist_id 
    WHERE p.id = ?
";
$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result || mysqli_num_rows($result) == 0) {
    die("Psychologist not found.");
}

$psychologist = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);
?>

<div class="container my-5">
    <h1>Edit Psychologist</h1>
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="save_changes" value="1">
        <input type="hidden" name="psychologist_id" value="<?= $id ?>">

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($psychologist['name']) ?>" required>
        </div>

        <div class="form-group">
            <label for="specialization">Specialization</label>
            <input type="text" class="form-control" id="specialization" name="specialization" value="<?= htmlspecialchars($psychologist['specialization']) ?>" required>
        </div>

        <div class="form-group">
            <label for="bio">Bio</label>
            <textarea class="form-control" id="bio" name="bio" rows="4" required><?= htmlspecialchars($psychologist['bio']) ?></textarea>
        </div>

        <div class="form-group">
            <label for="contact">Contact</label>
            <input type="text" class="form-control" id="contact" name="contact" value="<?= htmlspecialchars($psychologist['contact']) ?>" required>
        </div>

        <div class="form-group">
            <label for="image">Image</label><br>
            <?php if (!empty($psychologist['image_path'])): ?>
                <img src="<?= htmlspecialchars($psychologist['image_path']) ?>" alt="Current Image" style="max-width: 100px; height: auto;"><br>
            <?php endif; ?>
            <input type="file" class="form-control-file mt-2" id="image" name="image" accept="image/*">
        </div>

        <button type="submit" class="btn btn-success">Save Changes</button>
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
