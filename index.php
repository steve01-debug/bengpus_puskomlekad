<?php include 'components/head.php'; ?>
<?php include 'components/loading-screen.php'; ?>
<?php include 'components/navbar.php'; ?>

  <!-- ========== MAIN PAGE ========== -->
  <div class="main-page" id="main-page">
<?php include 'components/hero.php'; ?>
<?php include 'components/about.php'; ?>
<?php include 'components/video.php'; ?>
<?php include 'components/news.php'; ?>

<?php include 'components/footer.php'; ?>

  <!-- ========== WORKSHOP PAGES ========== -->
  </div> <!-- end .main-page -->

<?php include 'components/workshop-umum.php'; ?>
<?php include 'components/workshop-elektronika.php'; ?>
<?php include 'components/workshop-komunikasi.php'; ?>
<?php include 'components/workshop-senjata.php'; ?>
<?php include 'components/workshop-kendaraan.php'; ?>

<?php include 'components/pimpinan.php'; ?>
<?php include 'components/struktur-organisasi.php'; ?>

<?php include 'components/footer-scripts.php'; ?>

<script>
window.addEventListener('DOMContentLoaded', () => {
  const urlParams = new URLSearchParams(window.location.search);
  const page = urlParams.get('page');
  const workshop = urlParams.get('workshop');
  if (page) {
    setTimeout(() => openSpecialPage(page), 100);
  } else if (workshop) {
    setTimeout(() => openWorkshop(workshop), 100);
  }
});
</script>
