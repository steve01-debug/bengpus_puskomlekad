<?php
// Ambil berita dari database
if (!function_exists('getDB')) {
    require_once 'config/db.php';
}
$_conn_news = getDB();
$_beritaRows = [];
$_res_news = $_conn_news->query("SELECT * FROM berita ORDER BY tanggal DESC, id DESC LIMIT 3");
if ($_res_news) {
    while ($r = $_res_news->fetch_assoc()) { $_beritaRows[] = $r; }
}
$_conn_news->close();
?>
    <!-- NEWS SECTION -->
    <section class="news-section" id="news">
      <div class="container">
        <div class="section-title fade-in">
          Berita <span class="gold-text">Terkini</span>
        </div>
        <div class="gold-line"></div>
        <p class="section-subtitle fade-in">
          Informasi seputar kegiatan BENGPUSKOMLEKAD.
        </p>

        <div class="news-grid">
          <?php if (empty($_beritaRows)): ?>
          <div style="grid-column:1/-1;text-align:center;padding:48px;color:var(--gray-400);">
            <p>Belum ada berita yang tersedia.</p>
          </div>
          <?php else: ?>
          <?php foreach ($_beritaRows as $b): ?>
          <div class="news-card fade-in">
            <div class="news-card-image" style="background-image: url('<?= htmlspecialchars($b['gambar'] ?: 'assets/images/gedung-bengpus.jpeg') ?>');">
              <div class="news-date"><?= date('d M Y', strtotime($b['tanggal'])) ?></div>
            </div>
            <div class="news-card-body">
              <div class="news-card-category"><?= htmlspecialchars($b['kategori']) ?></div>
              <h3 class="news-card-title"><?= htmlspecialchars($b['judul']) ?></h3>
              <p class="news-card-excerpt">
                <?= htmlspecialchars(mb_substr(strip_tags($b['isi']), 0, 150)) ?>...
              </p>
              <a href="berita-detail.php?id=<?= $b['id'] ?>" class="news-card-link">Baca Selengkapnya →</a>
            </div>
          </div>
          <?php endforeach; ?>
          <?php endif; ?>
        </div>

        <div class="news-more-wrap fade-in" style="text-align: center; margin-top: 3rem;">
          <a href="berita.php" class="btn-outline">Berita Lainnya</a>
        </div>
      </div>
    </section>
