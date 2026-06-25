<?php
$currentPage = basename($_SERVER['PHP_SELF']);
$isHome = ($currentPage == 'index.php' || $currentPage == '');
$base = $isHome ? '' : 'index.php';
?>
  <!-- ========== NAVBAR ========== -->
  <nav class="navbar" id="navbar">
    <div class="container">
      <a href="<?= $base ?>#" class="navbar-logo" id="nav-logo" onclick="<?= $isHome ? 'showMainPage(); return false;' : '' ?>">
        <div class="logo-img-container">
          <img src="assets/images/logo-bengpus.png" alt="Logo BENGPUSKOMLEKAD">
        </div>
        <div class="logo-text">BENGPUS<span>KOMLEKAD</span></div>
      </a>

      <div class="navbar-menu" id="navbar-menu">
        <a href="<?= $base ?>#home" class="<?= $isHome ? 'active' : '' ?>" data-nav="home" onclick="<?= $isHome ? 'closeMobileMenu()' : '' ?>">Beranda</a>
        <a href="<?= $base ?>#about" data-nav="about" onclick="<?= $isHome ? 'closeMobileMenu()' : '' ?>">Tentang</a>

        <!---<div class="nav-dropdown" id="bengkel-dropdown">
          <button class="dropdown-trigger" onclick="toggleMobileDropdown(event)">
            Bengkel <span class="arrow">▼</span>
          </button>
          <div class="dropdown-menu">
            <a href="<?= $base ?>#" onclick="<?= $isHome ? "openWorkshop('sumga'); return false;" : "window.location.href='index.php?workshop=sumga';" ?>">Bengkel Power Sistem dan Sumber Tenaga</a>
            <a href="<?= $base ?>#" onclick="<?= $isHome ? "openWorkshop('elektronika'); return false;" : "window.location.href='index.php?workshop=elektronika';" ?>">Bengkel Sistem Elektronika</a>
            <a href="<?= $base ?>#" onclick="<?= $isHome ? "openWorkshop('komunikasi'); return false;" : "window.location.href='index.php?workshop=komunikasi';" ?>">Bengkel Sistem Komunikasi</a>
          </div>
        </div>-->

        <a href="<?= $base ?>#news" data-nav="news" onclick="<?= $isHome ? 'closeMobileMenu()' : '' ?>">Berita</a>
        <a href="<?= $base ?>#contact" data-nav="contact" onclick="<?= $isHome ? 'closeMobileMenu()' : '' ?>">Kontak</a>
        <div class="nav-dropdown" id="bengkel-dropdown">
          <button class="dropdown-trigger" onclick="toggleMobileDropdown(event)">
            Unit <span class="arrow">▼</span>
          </button>
            <div class="dropdown-menu">
              <a href="<?= $base ?>#" onclick="<?= $isHome ? "openWorkshop('sumga'); return false;" : "window.location.href='index.php?workshop=sumga';" ?>">Bengkel Power Sistem dan Sumber Tenaga</a>
              <a href="<?= $base ?>#" onclick="<?= $isHome ? "openWorkshop('elektronika'); return false;" : "window.location.href='index.php?workshop=elektronika';" ?>">Bengkel Sistem Elektronika</a>
              <a href="<?= $base ?>#" onclick="<?= $isHome ? "openWorkshop('komunikasi'); return false;" : "window.location.href='index.php?workshop=komunikasi';" ?>">Bengkel Sistem Komunikasi</a>
              <a href="<?= $base ?>#" onclick="<?= $isHome ? "openWorkshop('senjata'); return false;" : "window.location.href='index.php?workshop=senjata';" ?>">Bnegkel Jaringan Internet & TIK</a>
              <a href="<?= $base ?>#" onclick="<?= $isHome ? "openWorkshop('kendaraan'); return false;" : "window.location.href='index.php?workshop=kendaraan';" ?>">Gudang</a>
            </div>
          </div>
        <a href="<?= $base ?>#" data-nav="pimpinan" onclick="<?= $isHome ? "openSpecialPage('pimpinan'); closeMobileMenu(); return false;" : "window.location.href='index.php?page=pimpinan';" ?>">Pimpinan</a>
        <a href="<?= $base ?>#" data-nav="orgas" onclick="<?= $isHome ? "openSpecialPage('orgas'); closeMobileMenu(); return false;" : "window.location.href='index.php?page=orgas';" ?>">Struktur Organisasi</a>
      </div>

      <button class="hamburger" id="hamburger" onclick="toggleMobileMenu()">
        <span></span>
        <span></span>
        <span></span>
      </button>
    </div>
  </nav>
