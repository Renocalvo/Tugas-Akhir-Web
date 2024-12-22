// fungsi untuk treatmentpage
document.addEventListener("DOMContentLoaded", function() {
    const cards = document.querySelectorAll(".card-content");
    const infoBox = document.getElementById("info-box");
    const infoTitle = document.getElementById("info-title");
    const infoDescription = document.getElementById("info-description");
    const buttonsContainer = infoBox.querySelector(".box-button");
    const bacaArtikelButton = buttonsContainer.querySelector(".btn-outline-dark:nth-child(1)");

    // Awalnya sembunyikan tombol
    buttonsContainer.style.display = "none";

    cards.forEach(card => {
        card.addEventListener("click", function() {
            // Hapus status aktif dari semua kartu
            cards.forEach(c => c.classList.remove("active"));

            // Tambahkan status aktif ke kartu yang diklik
            card.classList.add("active");

            // Ambil data title, description, dan wiki dari kartu yang diklik
            const titleText = card.getAttribute("data-title");
            const descriptionText = card.getAttribute("data-description");
            const wikiUrl = card.getAttribute("data-artikel");

            // Tampilkan title dan description di infoBox
            infoTitle.textContent = titleText;
            infoDescription.textContent = descriptionText;
            infoBox.style.display = "block";
            buttonsContainer.style.display = "flex";  // Tampilkan tombol

            // Setel URL pada tombol "Baca Artikel"
            bacaArtikelButton.onclick = () => {
                window.open(wikiUrl, "_blank");
            };
        });
    });

    // Sembunyikan infoBox dan hapus status aktif ketika klik di luar kartu
    document.addEventListener("click", function(event) {
        if (!event.target.closest(".card-content")) {
            cards.forEach(c => c.classList.remove("active"));
            infoBox.style.display = "none";
            buttonsContainer.style.display = "none";  // Sembunyikan tombol
        }
    });
});

// end fungsi treatment

//fungsi snackbar
function showSnackbar(messages, type) {
    var snackbar = document.getElementById("snackbar");

    function displayMessage(index) {
        if (index >= messages.length) return;

        snackbar.textContent = messages[index];
        snackbar.classList.remove("snackbar-error", "snackbar-success");

        if (type === "error") {
            snackbar.classList.add("snackbar-error");
        } else if (type === "success") {
            snackbar.classList.add("snackbar-success");
        }

        snackbar.classList.add("show");

        setTimeout(function() {
            snackbar.classList.remove("show");
            setTimeout(function() {
                displayMessage(index + 1);
            }, 500);
        }, 3000);
    }

    displayMessage(0);
};

// fungsi resultpage
document.getElementById('btn-home').addEventListener('click', function () {
    window.location.href = 'landingpage.php';
});