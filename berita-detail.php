<?php include 'components/head.php'; ?>
<?php include 'components/navbar.php'; ?>

<div class="main-page" style="padding-top: 100px; min-height: 100vh;">
  <div class="container" style="padding-top: 40px; padding-bottom: 40px;">
    <h1 style="color: var(--gold); margin-bottom: 20px; font-family: var(--font-display); text-transform: uppercase;">Detail Berita</h1>
    <img src="assets/images/elektronika.jpeg" alt="Berita" style="width: 100%; max-height: 400px; object-fit: cover; border-radius: var(--radius-lg); margin-bottom: 20px;">
    <p style="color: var(--gray-200); line-height: 1.8; font-size: 1.2rem;">
      Ini adalah halaman detail berita. Konten selengkapnya akan ditampilkan di sini berdasarkan ID berita yang dipilih.
    </p>
    <br><br>
    <a href="berita.php" class="btn-outline">← Kembali ke Berita</a>
  </div>
</div>

<?php include 'components/footer.php'; ?>
<?php include 'components/footer-scripts.php'; ?>
