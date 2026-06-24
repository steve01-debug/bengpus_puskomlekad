<?php include 'components/head.php'; ?>
<?php include 'components/navbar.php'; ?>

<!-- ========== HALAMAN BERITA ========== -->
<div class="main-page" style="padding-top: 0; min-height: 100vh;">
  <section class="workshop-hero">
    <div class="workshop-hero-bg">
      <img src="assets/images/hero-bg.png" alt="Berita">
    </div>
    <div class="workshop-hero-content">
      <div class="workshop-badge"><span>BENGPUSKOMLEKAD</span></div>
      <h1>Berita <span class="gold-text">Lainnya</span></h1>
      <p>Kumpulan berita dan informasi seputar kegiatan BENGPUSKOMLEKAD</p>
    </div>
  </section>

  <section class="news-section">
    <div class="container">
      <div class="news-grid">
        <!-- News Card 1 -->
        <div class="news-card fade-in visible">
          <div class="news-card-image" style="background-image: url('assets/images/elektronika.jpeg');">
            <div class="news-date">12 Jun 2026</div>
          </div>
          <div class="news-card-body">
            <div class="news-card-category">LITBANG</div>
            <h3 class="news-card-title">Drone Interceptor</h3>
            <p class="news-card-excerpt">
              BENGPUSKOMLEKAD sebagai unsur pelaksana pusat kecabangan berpartisipasi dalam gelar manuver lapangan yang merupakan bagian dari program Pendidikan Komponen Cadangan.
            </p>
            <a href="berita-detail.php?id=1" class="news-card-link">Baca Selengkapnya →</a>
          </div>
        </div>

        <!-- News Card 2 -->
        <div class="news-card fade-in visible">
          <div class="news-card-image" style="background-image: url('assets/images/gedung-bengpus.jpeg');">
            <div class="news-date">08 Jun 2026</div>
          </div>
          <div class="news-card-body">
            <div class="news-card-category">Teknologi</div>
            <h3 class="news-card-title">Modernisasi Fasilitas Bengkel Elektronika dengan Peralatan Terkini</h3>
            <p class="news-card-excerpt">
              Investasi besar dalam peralatan modern untuk mendukung pemeliharaan sistem elektronika pertahanan generasi terbaru.
            </p>
            <a href="berita-detail.php?id=2" class="news-card-link">Baca Selengkapnya →</a>
          </div>
        </div>

        <!-- News Card 3 -->
        <div class="news-card fade-in visible">
          <div class="news-card-image" style="background-image: url('assets/images/sumga.jpeg');">
            <div class="news-date">01 Jun 2026</div>
          </div>
          <div class="news-card-body">
            <div class="news-card-category">Kerjasama</div>
            <h3 class="news-card-title">Penandatanganan MoU dengan Industri Pertahanan Australia</h3>
            <p class="news-card-excerpt">
              Kerjasama strategis dengan mitra internasional untuk bertukar ilmu pengetahuan seputar Teknologi.
            </p>
            <a href="berita-detail.php?id=3" class="news-card-link">Baca Selengkapnya →</a>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>


<?php include 'components/footer-scripts.php'; ?>
