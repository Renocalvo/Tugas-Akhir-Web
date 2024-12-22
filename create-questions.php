<main>
    <section>
        <div class="container px-5 py-5 mb-5">
            <div class=" about-treatment">
                <div class="row" style="background-color: white; padding: 30px 0 20px 0;">

                    <div class="col-md-3 pl-5">
                        <img src="assets/layananpage.png" width="130" style="background-color: transparent; border: none;"
                            class="img-thumbnail" alt="...">
                    </div>

                    <div class="col-md-6">
                        <div class="container container-title-layanan">
                            <h2 class="text-center mt-5"
                                style=" background: linear-gradient(90deg, #000, #BB8446); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                                Create Questions</h2>
                            <hr style=" border-width: 3px; width: 100%; background-color: #000;">
                            <h5 class="text-center">Admin Mode</h5>
                        </div>
                    </div>
                    <div class="col-md-3 pl-5">
                        <img src="assets/layananpage1.png" width="200" class="img-thumbnail"
                            style="background-color: transparent; border: none;" alt="...">
                    </div>
                </div>
            </div>
            <div id="questions-container" class="mt-5">
                <!-- Default Question -->
                <div class="question-item mb-4">
                    <label for="question">Pertanyaan Utama</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Masukkan pertanyaan" />
                    </div>
                    <label for="point">Masukkan Jumlah Poin Pertanyaan</label>
                    <div class="input-group mb-3" style="max-width: 10%;">
                        <input type="number" class="form-control" placeholder="Poin" />
                    </div>
                    <label>Edit Bullet Pertanyaan</label>
                    <div class="container"
                        style="background-color: whitesmoke; border-radius: 15px; padding: 20px;">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="pilihan-1"
                                id="pilihan-1" value="option1" checked>
                            <label class="form-check-label" for="pilihan-1">Tidak Pernah</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="pilihan-1"
                                id="pilihan-2" value="option2">
                            <label class="form-check-label" for="pilihan-2">Setidaknya beberapa kali
                                setiap tahun</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="pilihan-1"
                                id="pilihan-3" value="option3">
                            <label class="form-check-label" for="pilihan-3">Setidaknya sebulan
                                sekali</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="pilihan-1"
                                id="pilihan-4" value="option4">
                            <label class="form-check-label" for="pilihan-4">Beberapa kali dalam
                                sebulan</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="pilihan-" 5
                                id="pilihan-5" value="option5">
                            <label class="form-check-label" for="pilihan-1-5">Seminggu Sekali</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="pilihan-6"
                                id="pilihan-6" value="option6">
                            <label class="form-check-label" for="pilihan-6">Beberapa kali
                                seminggu</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="pilihan-7"
                                id="pilihan-7" value="option7">
                            <label class="form-check-label" for="pilihan-7">Setiap hari</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Buttons to Add or Remove Questions -->
            <div class="text-right">
                <button id="add-question-btn" class="btn btn-success">Tambah Pertanyaan Baru</button>
            </div>
            <div class="container mt-5"
                style="justify-content: center; align-items: center; display: flex; gap: 25px;">
                <button type="button" class="btn btn-primary btn-sm">Save</button>
                <button type="button" class="btn btn-secondary btn-sm">Edit</button>
            </div>
        </div>
        </div>
    </section>
</main>

<!-- Scripts -->
<script>
    let questionCount = 1;

    document.getElementById('add-question-btn').addEventListener('click', function() {
        questionCount++;
        const questionsContainer = document.getElementById('questions-container');

        // Create a new question item
        const newQuestionItem = document.createElement('div');
        newQuestionItem.classList.add('question-item', 'mb-4');
        newQuestionItem.innerHTML = `
          <label>Pertanyaan ${questionCount}</label>
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Masukkan pertanyaan" />
          </div>
          <label>Masukkan Jumlah Poin Pertanyaan</label>
          <div class="input-group mb-3" style="max-width: 10%;">
            <input type="number" class="form-control" placeholder="Poin" />
          </div>

          <!-- Radio Options -->
          <div class="container" style="background-color: grey; border-radius: 15px; padding: 20px;">
            <label>Edit Bullet Pertanyaan</label>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="pilihan-${questionCount}" id="pilihan-${questionCount}-1" value="option1" checked>
              <label class="form-check-label" for="pilihan-${questionCount}-1">Tidak Pernah</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="pilihan-${questionCount}" id="pilihan-${questionCount}-2" value="option2">
              <label class="form-check-label" for="pilihan-${questionCount}-2">Setidaknya beberapa kali setiap tahun</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="pilihan-${questionCount}" id="pilihan-${questionCount}-3" value="option3">
              <label class="form-check-label" for="pilihan-${questionCount}-3">Setidaknya sebulan sekali</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="pilihan-${questionCount}" id="pilihan-${questionCount}-4" value="option4">
              <label class="form-check-label" for="pilihan-${questionCount}-4">Beberapa kali dalam sebulan</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="pilihan-${questionCount}" id="pilihan-${questionCount}-5" value="option5">
              <label class="form-check-label" for="pilihan-${questionCount}-5">Seminggu Sekali</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="pilihan-${questionCount}" id="pilihan-${questionCount}-6" value="option6">
              <label class="form-check-label" for="pilihan-${questionCount}-6">Beberapa kali seminggu</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="pilihan-${questionCount}" id="pilihan-${questionCount}-7" value="option7">
              <label class="form-check-label" for="pilihan-${questionCount}-7">Setiap hari</label>
            </div>
          </div>

          <div class="text-right mt-3">
            <button class="btn btn-danger remove-question-btn">Hapus Pertanyaan</button>
          </div>
        `;

        // Append the new question item
        questionsContainer.appendChild(newQuestionItem);

        // Add event listener to remove button
        newQuestionItem.querySelector('.remove-question-btn').addEventListener('click', function() {
            questionsContainer.removeChild(newQuestionItem);
        });
    });
</script>