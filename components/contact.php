    <!-- FEEDBACK SECTION -->
    <section class="feedback-section" id="contact">
      <div class="container">
        <div class="section-title fade-in">
          Hubungi <span class="gold-text">Kami</span>
        </div>
        <div class="gold-line"></div>
        <p class="section-subtitle fade-in">
          Kirimkan masukan, pertanyaan, atau saran untuk peningkatan layanan kami.
        </p>

        <div class="feedback-grid">
          <div class="feedback-info fade-in-left">
            <h3>Informasi <span class="gold-text">Kontak</span></h3>
            <p>
              Kami siap melayani Anda. Silakan hubungi kami melalui kontak di bawah ini atau kirimkan pesan langsung melalui formulir feedback.
            </p>

            <div class="info-item">
              <a href="mailto:admin@bengpuskomlek.co.id" class="info-icon">
                ✉
              </a>
              <div>
                <div class="info-label">Email</div>
                <div class="info-value">admin@bengpuskomlekad.co.id</div>
              </div>
            </div>

            <div class="info-item">
              <a href="tel:+62 0000000000" class="info-icon">
                📞
              </a>
              <div>
                <div class="info-label">Telepon</div>
                <div class="info-value">+62 0000000000</div>
              </div>
            </div>

            <div class="info-item">
              <a href="https://www.instagram.com/bengpuskomlek/" target="_blank" class="info-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
              </a>
              <div>
                <div class="info-label">Instagram</div>
                <div class="info-value">@bengpuskomlek</div>
              </div>
            </div>

            <div class="info-item">
              <a href="https://maps.app.goo.gl/pzKhFXDCqxmuwZ7N7" target="_blank" class="info-icon" style="font-size: 1.8rem; display: flex; align-items: center; justify-content: center;">
                📍
              </a>
              <div>
                <div class="info-label">Alamat</div>
                <div class="info-value">Jl. PSM No.50, Sukapura, Kec. Kiaracondong, Kota Bandung, Jawa Barat 40285</div>
              </div>
            </div>
          </div>

          <div class="feedback-form fade-in-right" id="feedback-form-container">
            <form id="feedback-form" onsubmit="handleFeedback(event)">
              <div class="form-group">
                <label for="feedback-name">Nama Lengkap</label>
                <input type="text" id="feedback-name" name="nama" placeholder="Masukkan nama lengkap" required>
              </div>
              <div class="form-group">
                <label for="feedback-email">Email</label>
                <input type="email" id="feedback-email" name="email" placeholder="email@domain.com" required>
              </div>
              <div class="form-group">
                <label for="feedback-message">Pesan</label>
                <textarea id="feedback-message" name="pesan" placeholder="Tulis pesan Anda di sini..." required></textarea>
              </div>
              <button type="submit" class="form-submit-btn">Kirim Pesan →</button>
            </form>
            <div class="form-success" id="form-success">
              <div class="success-icon">✅</div>
              <h3>Pesan Terkirim!</h3>
              <p style="color: var(--gray-300); margin-top: var(--space-sm);">Terima kasih atas pesan Anda.</p>
            </div>
          </div>
        </div>
      </div>
    </section>
