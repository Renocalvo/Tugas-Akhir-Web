<?php
$pageTitle = "layanan Page - Healpoint";
include './inc/inc_adminheader.php';
?>
<main>
    <section>
        <div class="container mb-5">
            <div class="bg-white p-4">
                <div class="row about-treatment">
                    <div class="col-md-3 text-center">
                        <img src="assets/layananpage.png" width="130" class="img-thumbnail" alt="...">
                    </div>

                    <div class="col-md-6">
                        <div class="container-title-layanan text-center">
                            <h2>Add Doctors</h2>
                            <hr>
                            <h5>Admin Mode</h5>
                        </div>
                    </div>

                    <div class="col-md-3 text-center">
                        <img src="assets/layananpage1.png" width="200" class="img-thumbnail" alt="...">
                    </div>
                </div>

                <!-- Form Fields -->
                <div class="mt-4">
                    <label for="psikologis-name">Enter Psychologist's Name</label>
                    <div class="form-group">
                        <input type="email" class="form-control" id="psikologis-name" placeholder="Name">
                    </div>

                    <label for="dropdown-role">Select Your Role</label>
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdown-role" data-toggle="dropdown">
                            Who are you..
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#">Psychologist</a>
                            <a class="dropdown-item" href="#">Counselor</a>
                        </div>
                    </div>
                </div>

                <!-- Profile Image Section -->
                <div class="mt-5 text-center">
                    <img id="profile-image" src="https://via.placeholder.com/150" alt="Profile Image" class="profile-image">
                    <input type="file" id="upload-input" class="d-none" accept="image/*">
                </div>

                <!-- Action Buttons -->
                <div class="profile-actions mt-5">
                    <div class="row justify-content-center">
                        <div class="col-md-6 mb-3">
                            <button id="edit-btn-psikologi" class="btn btn-secondary">Edit</button>
                        </div>
                        <div class="col-md-6 mb-3">
                            <button id="save-btn-psikologi" class="btn btn-success">Save</button>
                        </div>
                    </div>
                    <div class="text-center">
                        <button id="delete-btn-psikologi" class="btn btn-danger" style="max-width: 60%;">Delete</button>
                    </div>
                </div>

                <!-- Save/Edit Buttons -->
                <div class="row justify-content-center mt-5">
                    <div class="col-md-6 mb-3">
                        <button id="edit-post-psikologi" class="btn btn-primary">Edit</button>
                    </div>
                    <div class="col-md-6 mb-3">
                        <button id="save-post-psikologi" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Bootstrap 4.6 JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/js/bootstrap.min.js"></script>

<script>
    const profileImage = document.getElementById('profile-image');
    const uploadInput = document.getElementById('upload-input');
    const editBtn = document.getElementById('edit-btn-psikologi');
    const saveBtn = document.getElementById('save-btn-psikologi');
    const deleteBtn = document.getElementById('delete-btn-psikologi');

    let tempImageURL = null;

    // Function to resize image
    function resizeImage(file, maxWidth, maxHeight, callback) {
        const img = document.createElement('img');
        const reader = new FileReader();

        reader.onload = (e) => {
            img.src = e.target.result;
        };

        img.onload = () => {
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');
            let width = img.width;
            let height = img.height;

            if (width > maxWidth || height > maxHeight) {
                if (width > height) {
                    height = Math.floor((height * maxWidth) / width);
                    width = maxWidth;
                } else {
                    width = Math.floor((width * maxHeight) / height);
                    height = maxHeight;
                }
            }

            canvas.width = width;
            canvas.height = height;

            ctx.drawImage(img, 0, 0, width, height);
            callback(canvas.toDataURL('image/png'));
        };

        reader.readAsDataURL(file);
    }

    // Edit button logic
    editBtn.addEventListener('click', () => {
        uploadInput.click();
    });

    // Upload input logic
    uploadInput.addEventListener('change', (event) => {
        const file = event.target.files[0];
        if (file) {
            resizeImage(file, 150, 150, (resizedImage) => {
                tempImageURL = resizedImage; // Store resized image
                profileImage.src = resizedImage; // Preview resized image
                saveBtn.classList.remove('d-none');
            });
        }
    });

    // Save button logic
    saveBtn.addEventListener('click', () => {
        if (tempImageURL) {
            alert('Profile photo saved successfully!');
            saveBtn.classList.add('d-none');
            tempImageURL = null; // Clear temporary URL after saving
        }
    });

    // Delete button logic
    deleteBtn.addEventListener('click', () => {
        const confirmDelete = confirm('Are you sure you want to delete the profile photo?');
        if (confirmDelete) {
            profileImage.src = 'https://via.placeholder.com/150'; // Reset to placeholder
            tempImageURL = null; // Clear temporary URL
        }
    });
</script>
<?php
include './inc/inc_adminfooter.php';
?>