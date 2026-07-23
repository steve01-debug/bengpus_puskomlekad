<?php 
// Memuat kerangka desain dan menu atas
include 'components/head.php'; 
include 'components/navbar.php'; 

// Hubungkan ke database
if (!function_exists('getDB')) { require_once 'config/db.php'; }
$_conn_berita = getDB();
$_beritaAll = [];

// Mengambil data dari tabel berita_db
$_res_b = $_conn_berita->query("SELECT * FROM berita_db ORDER BY tanggal DESC, id DESC");

if ($_res_b) { 
    while ($r = $_res_b->fetch_assoc()) { 
        $_beritaAll[] = $r; 
    } 
}
$_conn_berita->close();
?>

<!-- ========== HALAMAN BERITA ========== -->
<div class="main-page" style="padding-top: 0; min-height: 100vh;">
  <section class="workshop-hero">
    <div class="workshop-hero-bg">
      <img src="assets/images/hero-bg.png" alt="Berita">
    </div>
    <div class="workshop-hero-content">
      <div class="workshop-badge"><span>BENGPUS PUSKOMLEKAD</span></div>
      <h1>Berita <span class="gold-text">Lainnya</span></h1>
      <p>Kumpulan berita dan informasi seputar kegiatan BENGPUS PUSKOMLEKAD</p>
    </div>
  </section>

  <section class="news-section">
    <div class="container">
      <div class="news-grid">
        
        <?php if (empty($_beritaAll)): ?>
          <div style="grid-column: 1/-1; text-align: center; padding: 48px; color: var(--gray-400);">
            <p>Belum ada berita yang tersedia saat ini.</p>
          </div>
        <?php else: ?>
          <?php foreach ($_beritaAll as $b): ?>
            <div class="news-card fade-in visible">
              <?php 
                // Gunakan gambar dari database, jika kosong gunakan default
                $gambarPath = !empty($b['gambar']) ? $b['gambar'] : 'assets/images/gedung-bengpus.jpeg';
              ?>
              <div class="news-card-image" style="background-image: url('<?= htmlspecialchars($gambarPath) ?>');">
                <div class="news-date"><?= date('d M Y', strtotime($b['tanggal'])) ?></div>
              </div>
              <div class="news-card-body">
                <div class="news-card-category"><?= htmlspecialchars($b['kategori']) ?></div>
                <h3 class="news-card-title"><?= htmlspecialchars($b['judul']) ?></h3>
                <p class="news-card-excerpt">
                  <?= htmlspecialchars(mb_substr(strip_tags($b['isi']), 0, 120)) ?>...
                </p>
                <!-- Arahkan link ke detail berita dengan membawa parameter ID -->
                <a href="berita-detail.php?id=<?= $b['id'] ?>" class="news-card-link">Baca Selengkapnya →</a>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>

      </div>
    </div>
  </section>
</div>

<?php 
// Memuat footer dan script javascript pendukung
include 'components/footer.php'; 
include 'components/footer-scripts.php'; 
?>