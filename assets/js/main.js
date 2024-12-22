/**
 * fungsi logout pada admin
 */
document.getElementById('logout-link').addEventListener('click', function(e) {
  e.preventDefault(); // Mencegah link bekerja secara default
  this.closest('form').submit(); // Mengirimkan form logout
});
