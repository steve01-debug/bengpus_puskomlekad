<?php
// Ambil data pimpinan dari database
if (!function_exists('getDB')) { require_once 'config/db.php'; }
$_conn_p = getDB();
$_currentPimpinan = null;
$_prevPimpinan = [];

$_res_cur = $_conn_p->query("SELECT * FROM pimpinan_db WHERE is_current = 1 ORDER BY id DESC LIMIT 1");
if ($_res_cur && $_res_cur->num_rows > 0) {
    $_currentPimpinan = $_res_cur->fetch_assoc();
}

$_res_prev = $_conn_p->query("SELECT * FROM pimpinan_db WHERE is_current = 0 ORDER BY urutan DESC, id DESC");
if ($_res_prev) {
    while ($r = $_res_prev->fetch_assoc()) { $_prevPimpinan[] = $r; }
}
$_conn_p->close();
?>
  <!-- ========== HALAMAN PIMPINAN ========== -->
  <div class="workshop-page" id="page-pimpinan">
    <button class="back-btn" onclick="showMainPage()">← Kembali</button>

    <section class="workshop-hero">
      <div class="workshop-hero-bg">
        <img src="assets/images/hero-bg.png" alt="Pimpinan BENGPUS PUSKOMLEKAD">
      </div>
      <div class="workshop-hero-content">
        <div class="workshop-badge"><span>BENGPUS PUSKOMLEKAD</span></div>
        <h1>Pimpinan <span class="gold-text">BENGPUS PUSKOMLEKAD</span></h1>
        <p>Daftar pimpinan Bengkel Pusat Pusat Komunikasi dan Elektronika Angkatan Darat</p>
      </div>
    </section>

    <section class="pimpinan-section">
      <div class="container">

        <!-- Pimpinan Saat Ini -->
        <div class="section-title fade-in">Pimpinan <span class="gold-text">Saat Ini</span></div>
        <div class="gold-line"></div>

        <?php if ($_currentPimpinan): ?>
        <div class="pimpinan-current fade-in">
          <div class="pimpinan-card-featured">
            <div class="pimpinan-photo-wrap featured">
              <div class="pimpinan-photo-placeholder featured">
                <span>
                  <?php if ($_currentPimpinan['gambar']): ?>
                  <img src="<?= htmlspecialchars($_currentPimpinan['gambar']) ?>"
                       alt="<?= htmlspecialchars($_currentPimpinan['nama']) ?>"
                       class="pimpinan-kabeng">
                  <?php else: ?>
                  <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="rgba(201,168,76,0.5)" stroke-width="1"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                  <?php endif; ?>
                </span>
              </div>
              <div class="pimpinan-badge-current">Pimpinan Aktif</div>
            </div>
            <div class="pimpinan-info-featured">
              <div class="pimpinan-jabatan-label">Kepala BENGPUS PUSKOMLEKAD</div>
              <h2 class="pimpinan-nama"><?= htmlspecialchars($_currentPimpinan['nama']) ?></h2>
              <div class="pimpinan-period">
                <span>Masa Jabatan: <?= htmlspecialchars($_currentPimpinan['masa_jabatan']) ?></span>
              </div>
            </div>
          </div>
        </div>
        <?php else: ?>
        <div style="text-align:center;padding:40px;color:var(--gray-400);">
          <p>Data pimpinan aktif belum tersedia.</p>
        </div>
        <?php endif; ?>

        <!-- Pimpinan Sebelumnya -->
        <?php if (!empty($_prevPimpinan)): ?>
        <div class="section-title fade-in" style="margin-top: 4rem;">Pimpinan <span class="gold-text">Sebelumnya</span></div>
        <div class="gold-line"></div>

        <div class="pimpinan-timeline">
          <?php foreach ($_prevPimpinan as $p): ?>
          <div class="pimpinan-timeline-item fade-in">
            <div class="timeline-year"><?= htmlspecialchars($p['masa_jabatan']) ?></div>
            <div class="timeline-connector"></div>
            <div class="pimpinan-card-small">
              <div class="pimpinan-photo-small">
                <?php if ($p['gambar']): ?>
                <img src="<?= htmlspecialchars($p['gambar']) ?>"
                     alt="<?= htmlspecialchars($p['nama']) ?>"
                     class="pimpinan-kabeng-lama">
                <?php else: ?>
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="rgba(201,168,76,0.4)" stroke-width="1.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                <?php endif; ?>
              </div>
              <div class="pimpinan-info-small">
                <div class="pimpinan-jabatan-label-small">Kepala BENGPUS PUSKOMLEKAD</div>
                <div class="pimpinan-nama-small"><?= htmlspecialchars($p['nama']) ?></div>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>

      </div>
    </section>
  </div>
