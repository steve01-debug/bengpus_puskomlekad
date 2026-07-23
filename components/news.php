<?php
// Ambil berita dari database
if (!function_exists('getDB')) {
    require_once 'config/db.php';
}
$_conn_news = getDB();
$_beritaRows = [];
$_videoRows = [];

// Fetch Berita
$_res_news = $_conn_news->query("SELECT * FROM berita_db ORDER BY tanggal DESC, id DESC LIMIT 3");
if ($_res_news) {
    while ($r = $_res_news->fetch_assoc()) { 
        $_beritaRows[] = $r; 
    }
}

// Fetch Video Terkait
$_res_video = $_conn_news->query("SELECT * FROM video_terkait_db ORDER BY id DESC LIMIT 3");
if ($_res_video) {
    while ($v = $_res_video->fetch_assoc()) {
        $_videoRows[] = $v;
    }
}

$_conn_news->close();
?>
<section class="news-section" id="news">
  <div class="container">
    <div class="section-title fade-in">
      Berita <span class="gold-text">Terkini</span>
    </div>
    <div class="gold-line"></div>
    <p class="section-subtitle fade-in">
      Informasi seputar kegiatan BENGPUS PUSKOMLEKAD.
    </p>

    <div class="news-grid">
      <?php if (empty($_beritaRows)): ?>
      <div style="grid-column:1/-1;text-align:center;padding:48px;color:var(--gray-400);">
        <p>Belum ada berita yang tersedia.</p>
      </div>
      <?php else: ?>
      <?php foreach ($_beritaRows as $b): ?>
      <div class="news-card fade-in visible">
        <?php 
          // Memastikan jika gambar kosong, otomatis menggunakan gambar gedung default
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
          <a href="berita-detail.php?id=<?= $b['id'] ?>" class="news-card-link">Baca Selengkapnya →</a>
        </div>
      </div>
      <?php endforeach; ?>
      <?php endif; ?>
    </div>

    <div class="news-more text-center fade-in" style="margin-top: 40px; display: flex; justify-content: center;">
      <a href="javascript:void(0)" onclick="openSpecialPage('berita')" class="btn-gold btn-animated">Lihat Semua Berita</a>
    </div>
    
    <div style="margin-top: 80px;"></div>
    
    <div class="section-title fade-in">
      Video <span class="gold-text">Terkait</span>
    </div>
    <div class="gold-line"></div>
    <p class="section-subtitle fade-in">
      Koleksi video terkait seputar BENGPUS PUSKOMLEKAD.
    </p>

    <div class="news-grid" style="margin-top: 40px;">
      <?php if (empty($_videoRows)): ?>
      <div style="grid-column:1/-1;text-align:center;padding:48px;color:var(--gray-400);">
        <p>Belum ada video terkait yang tersedia.</p>
      </div>
      <?php else: ?>
      <?php foreach ($_videoRows as $v): ?>
      <div class="news-card fade-in visible" style="display: flex; flex-direction: column;">
        <?php 
          $thumbPath = !empty($v['thumbnail']) ? $v['thumbnail'] : 'assets/images/gedung-bengpus.jpeg';
        ?>
        <div class="news-card-image" style="background-image: url('<?= htmlspecialchars($thumbPath) ?>'); position: relative; padding-top: 56.25%;">
            <!-- Play icon overlay -->
            <a href="<?= htmlspecialchars($v['url_video']) ?>" target="_blank" style="position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; background: rgba(0,0,0,0.3); text-decoration: none;">
                <div style="width: 50px; height: 50px; border-radius: 50%; background: var(--gold); display: flex; align-items: center; justify-content: center; color: var(--navy-darkest); font-size: 20px; transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">▶</div>
            </a>
        </div>
        <div class="news-card-body" style="flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
          <h3 class="news-card-title"><?= htmlspecialchars($v['judul']) ?></h3>
          <a href="<?= htmlspecialchars($v['url_video']) ?>" target="_blank" class="news-card-link" style="margin-top: 15px;">Tonton Video →</a>
        </div>
      </div>
      <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</section>