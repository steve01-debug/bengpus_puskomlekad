<!-- ========== HALAMAN BERITA ========== -->
<div class="workshop-page" id="page-berita">
  <button class="back-btn" onclick="showMainPage()">← Kembali</button>

  <section class="special-page-hero">
    <div class="special-hero-overlay"></div>
    <div class="special-hero-content">
      <div class="hero-content">
        <div class="hero-badge">
          <div class="badge-dot"></div>
          <span>BENGPUS PUSKOMLEKAD</span>
        </div>
        <div class="workshop-hero-content">
          <h1>Berita <span class="gold-text">Lainnya</span></h1>
          <p>Kumpulan berita dan informasi seputar kegiatan BENGPUS PUSKOMLEKAD</p>
        </div>
      </div>
    </div>
  </section>

  <section class="news-section">
    <div class="container">
      <?php
      if (!function_exists('getDB')) { require_once 'config/db.php'; }
      $_conn_berita = getDB();
      $_beritaAll = [];
      $_res_b = $_conn_berita->query("SELECT * FROM berita_db ORDER BY tanggal DESC, id DESC");
      if ($_res_b) { while ($r = $_res_b->fetch_assoc()) { $_beritaAll[] = $r; } }
      $_conn_berita->close();
      ?>
      <div class="news-grid">
        <?php if (empty($_beritaAll)): ?>
        <div style="grid-column:1/-1;text-align:center;padding:48px;color:var(--gray-400);">
          <p>Belum ada berita yang tersedia.</p>
        </div>
        <?php else: ?>
        <?php foreach ($_beritaAll as $b): ?>
        <div class="news-card fade-in visible">
          <div class="news-card-image" style="background-image: url('<?= htmlspecialchars($b['gambar'] ?: 'assets/images/gedung-bengpus.jpeg') ?>');">
            <div class="news-date"><?= date('d M Y', strtotime($b['tanggal'])) ?></div>
          </div>
          <div class="news-card-body">
            <div class="news-card-category"><?= htmlspecialchars($b['kategori']) ?></div>
            <h3 class="news-card-title"><?= htmlspecialchars($b['judul']) ?></h3>
            <p class="news-card-excerpt">
              <?= htmlspecialchars(mb_substr(strip_tags($b['isi']), 0, 160)) ?>...
            </p>
            <a href="berita-detail.php?id=<?= $b['id'] ?>" class="news-card-link">Baca Selengkapnya →</a>
          </div>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>
  </section>
</div>
