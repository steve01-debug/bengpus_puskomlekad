<?php
$conn = getDB();
$currentImage = 'assets/images/hero-bg.png'; // default fallback
$res = $conn->query("SELECT gambar FROM struktur_organisasi_image_db WHERE id = 1");
if ($res && $row = $res->fetch_assoc()) {
    if (!empty($row['gambar'])) {
        $currentImage = $row['gambar'];
    }
}
$conn->close();
?>

  <!-- ========== HALAMAN STRUKTUR ORGANISASI ========== -->
  <div class="workshop-page" id="page-orgas">
    <button class="back-btn" onclick="showMainPage()">← Kembali</button>

    <section class="workshop-hero">
      <div class="workshop-hero-bg">
        <img src="assets/images/hero-bg.png" alt="Struktur Organisasi">
      </div>
      <div class="workshop-hero-content">
        <div class="workshop-badge"><span>BENGPUS PUSKOMLEKAD</span></div>
        <h1>Struktur <span class="gold-text">Organisasi</span></h1>
        <p>Bagan Organisasi Bengkel Pusat Komunikasi dan Elektronika Angkatan Darat</p>
      </div>
    </section>

    <section class="orgas-section">
      <div class="container" style="max-width: 1000px; margin: 0 auto; padding: 20px;">
        <div class="orgas-image-container" style="position: relative; border: 1px solid rgba(201, 168, 76, 0.3); border-radius: 12px; background: rgba(10, 22, 40, 0.6); padding: 25px; text-align: center; box-shadow: var(--shadow-lg); transition: all 0.3s; cursor: zoom-in;" onclick="openOrgasLightbox()">
          <img src="<?= htmlspecialchars($currentImage) ?>" alt="Bagan Struktur Organisasi" style="max-width: 100%; height: auto; border-radius: 6px; border: 1px solid rgba(255, 255, 255, 0.1);">
          <div style="margin-top: 15px; font-size: 0.85rem; color: var(--gray-300); display: flex; align-items: center; justify-content: center; gap: 6px;">
            <span>🔍 Klik gambar untuk memperbesar</span>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- Lightbox Modal untuk Zoom Gambar Struktur -->
  <div id="orgasLightbox" style="display: none; position: fixed; inset: 0; background: rgba(6, 13, 26, 0.95); backdrop-filter: blur(10px); z-index: 9999; align-items: center; justify-content: center; padding: 20px;" onclick="closeOrgasLightbox()">
    <button style="position: absolute; top: 20px; right: 20px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #fff; font-size: 1.5rem; width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.2)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'" onclick="closeOrgasLightbox(event)">✕</button>
    <div style="max-width: 90%; max-height: 90%; display: flex; align-items: center; justify-content: center;" onclick="event.stopPropagation()">
      <img src="<?= htmlspecialchars($currentImage) ?>" alt="Bagan Struktur Organisasi Zoom" style="max-width: 100%; max-height: 90vh; object-fit: contain; border-radius: 8px; box-shadow: 0 10px 40px rgba(0,0,0,0.8);">
    </div>
  </div>

  <script>
  function openOrgasLightbox() {
    document.getElementById('orgasLightbox').style.display = 'flex';
  }
  function closeOrgasLightbox(e) {
    if (e) {
      e.stopPropagation();
    }
    document.getElementById('orgasLightbox').style.display = 'none';
  }
  </script>
