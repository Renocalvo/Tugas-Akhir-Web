<?php
require_once '../inc/inc_connection.php'; // Include database connection
$pageTitle = "Edit Psychologist - Healpoint";
include '../inc/inc_adminheader.php';

// Get the psychologist ID from the query string
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch psychologist data based on ID
$query = "SELECT * FROM psychologists WHERE id = $id";
$result = mysqli_query($koneksi, $query);

// Check if data exists
if (!$result || mysqli_num_rows($result) == 0) {
    die("Psychologist not found.");
}

$psychologist = mysqli_fetch_assoc($result);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_changes'])) {
    $name = mysqli_real_escape_string($koneksi, $_POST['name']);
    $specialization = mysqli_real_escape_string($koneksi, $_POST['specialization']);
    $bio = mysqli_real_escape_string($koneksi, $_POST['bio']);
    $contact = mysqli_real_escape_string($koneksi, $_POST['contact']);

    // Handle file upload if new image is uploaded
    if (!empty($_FILES['image']['name'])) {
        $image_path = '../assets/uploads/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image_path);
    } else {
        $image_path = $psychologist['image_path']; // Keep existing image if no new file is uploaded
    }

    // Update query
    $update_query = "
        UPDATE psychologists 
        SET 
            name = '$name',
            specialization = '$specialization',
            bio = '$bio',
            contact = '$contact',
            image_path = '$image_path'
        WHERE id = $id
    ";

    if (mysqli_query($koneksi, $update_query)) {
        header("Location: create-psikolog.php?message=Psychologist+updated+successfully");
        exit();
    } else {
        die("Update failed: " . mysqli_error($koneksi));
    }
}
?>

<div class="container my-5">
    <h1>Edit Psychologist</h1>
    <form action="edit-psikolog.php?id=<?= $id ?>" method="POST" enctype="multipart/form-data">
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
                <img src="<?= htmlspecialchars($psychologist['image_path']) ?>" alt="Current Image" style="max-width: 100px; height: auto;">
            <?php else: ?>
                No Image Available
            <?php endif; ?>
            <input type="file" class="form-control-file mt-2" id="image" name="image" accept="image/*">
        </div>

        <!-- Save and Cancel buttons -->
        <button type="submit" name="save_changes" class="btn btn-success">Save Changes</button>
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
