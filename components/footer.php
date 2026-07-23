    <!-- FOOTER -->
    <footer class="footer">
      <div class="container">
        <div class="footer-grid">
          <div class="footer-brand">
            <div class="logo-text">BENGPUS <span>PUSKOMLEKAD</span></div>
            <p>Bengkel Pusat Komunikasi dan Elektronika Angkatan Darat.</p>
            <!--<div class="social-links">
              <a href="mailto:admin@bengpuskomlek.co.id" class="social-link" data-tooltip="Email">✉</a>
              <a href="tel:+622155557890" class="social-link" data-tooltip="Telepon">📞</a>
              <a href="https://www.instagram.com/bengpuskomlek/" class="social-link" target="_blank" data-tooltip="Instagram">📷</a>
            </div>-->
          </div>

          <div class="footer-column">
            <h4>Navigasi</h4>
            <ul>
              <li><a href="#home">Beranda</a></li>
              <li><a href="#about">Tentang Kami</a></li>
              <li><a href="#video">Video Profil</a></li>
              <li><a href="#news">Berita</a></li>
            </ul>
          </div>

          <div class="footer-column">
            <h4>Mitra</h4>
            <ul>
              <li><a href="#">PT. BALATO INDONESIA</a></li>
              <li><a href="#">PT. RANTIS TELEKOMUNIKASI INDONESIA</a></li>
              <li><a href="#">CV. SYAFIRA INDIRA</a></li>
              <li><a href="#">CV. IRPAN PUTRA</a></li>
            </ul>
          </div>

          <div class="footer-column">
            <h4>Bengkel</h4>
            <ul>
              <li><a href="#" onclick="openWorkshop('umum'); return false;">Power Sistem & Sumga</a></li>
              <li><a href="#" onclick="openWorkshop('elektronika'); return false;">Sistem Elektronika</a></li>
              <li><a href="#" onclick="openWorkshop('komunikasi'); return false;">Sistem Komunikasi</a></li>
              <li><a href="#" onclick="openWorkshop('senjata'); return false;">Bengkel Jaringan Internet & TIK</a></li>
              <li><a href="#" onclick="openWorkshop('kendaraan'); return false;">Gudang</a></li>
            </ul>
          </div>

          <div class="footer-column">
            <!--<h4>Kontak</h4>
            <div class="footer-contact-item">
              <div class="footer-contact-icon">
                <a href="mailto:admin@bengpuskomlek.co.id">✉</a>
              </div>
              <div class="footer-contact-text">
                <strong>Email</strong>
                admin@bengpuskomlekad.co.id
              </div>
            </div>

            <div class="footer-contact-item">
              <div class="footer-contact-icon">
                <a href="tel:+62 0000000000">📞</a>
              </div>
              <div class="footer-contact-text">
                <strong>Telepon</strong>
                +62 0000000000
              </div>
            </div>

            <div class="footer-contact-item">
              <div class="footer-contact-icon">
                <a href="https://www.instagram.com/bengpuskomlek/">📷</a>
              </div>
              <div class="footer-contact-text">
                <strong>Instagram</strong>
                @bengpuskomlek
              </div>
            </div>
            -->
          </div>
        </div>

        <div class="footer-bottom" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
          <span style="white-space: nowrap;">&copy; <?= date('Y') ?> Universitas Pertahanan Republik Indonesia</span>
          <div class="footer-social-icons" style="display: flex; gap: 20px; align-items: center;">
            <a href="https://www.instagram.com/bengpuskomlek/" target="_blank" style="color: var(--gray-300); text-decoration: none; display: flex; align-items: center; gap: 6px; transition: color 0.3s;" onmouseover="this.style.color='var(--gold)'" onmouseout="this.style.color='var(--gray-300)'">
              <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
              <!--<span style="font-size: 0.9rem;">Instagram</span>-->
            </a>
            <a href="https://maps.app.goo.gl/pzKhFXDCqxmuwZ7N7" target="_blank" style="color: var(--gray-300); text-decoration: none; display: flex; align-items: center; gap: 6px; transition: color 0.3s;" onmouseover="this.style.color='var(--gold)'" onmouseout="this.style.color='var(--gray-300)'">
              <span style="font-size: 1.8rem;">🏠︎</span>
              <!--<span style="font-size: 0.9rem;">Lokasi</span>-->
            </a>
          </div>
        </div>
      </div>
    </footer>
