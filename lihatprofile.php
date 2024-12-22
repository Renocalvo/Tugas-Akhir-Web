<?php 
    $pageTitle = "Detail Psikolog - Healpoint";
    include './inc/inc_header.php'; 
    require_once "./inc/inc_connection.php";

    // Check if the ID is passed as a parameter
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        
        // Prepare the SQL query to fetch the psychologist's details
        $sql = "SELECT id, name, specialization, bio, contact, 
                       (SELECT image_path FROM psychologist_images WHERE psychologist_id = psychologists.id LIMIT 1) as image_path
                FROM psychologists
                WHERE id = ?";
        
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        // Check if a psychologist is found
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $name = htmlspecialchars($row['name']);
            $specialization = htmlspecialchars($row['specialization']);
            $bio = htmlspecialchars($row['bio']);
            $contact = htmlspecialchars($row['contact']);
            $imagePath = $row['image_path'] ? htmlspecialchars($row['image_path']) : 'https://via.placeholder.com/150';
            $whatsappLink = "https://wa.me/" . preg_replace('/[^0-9]/', '', $contact);
        } else {
            echo "<p class='text-center'>Psikolog tidak ditemukan.</p>";
            exit;
        }
    } else {
        echo "<p class='text-center'>ID Psikolog tidak ditemukan.</p>";
        exit;
    }

    $koneksi->close();
?>
    <section>
        <div class="container-fluid my-5" style=" display: flex; align-items: center;">
            <div class="container container-profile bg-white border-rounded shadow">
                <img src="<?php echo $imagePath; ?>" class="img-thumbnail picture-view" alt="Psikolog Image">
               
                <h2 class="psikologis-name">
                <?php echo $name; ?>
                </h2>
                <h5 class="specialization">
                 <?php echo $specialization; ?>
                </h5>
                <h5 class="contact">
                <?php echo $contact; ?>
                </h5>
                 <div class=" my-5 bg-white">
                    <q class="bio">
                    <?php echo $bio; ?>
                    </q>
                </div>
                <div class="contact-person mt-3">
                    <a href="klinikpage.php" class="btn btn-primary" style="background-color:#92C9FF; width:100px; border:none; border-radius: 16px;">Back</a>
                </div>
            </div>
        </div>
    </section>
<?php 
    include './inc/inc_footer.php'; 
?>