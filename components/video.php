    <!-- VIDEO SECTION -->
    <section class="video-section" id="video">
      <div class="container">
        <div class="section-title fade-in">
          Video <span class="gold-text">Profil</span>
        </div>
        <div class="gold-line"></div>
        <p class="section-subtitle fade-in">
          Profil BENGPUS PUSKOMLEKAD terkait layanan fasilitas dan layanan kami melalui video profil perusahaan.
        </p>
        <div class="video-container scale-in" id="video-container">
          <div class="video-play-overlay" id="video-overlay" onclick="playVideo()">
            <div class="play-button">
              <span class="play-icon">▶</span>
            </div>
          </div>
          <!-- YouTube embed placeholder -->
          <iframe 
            id="video-iframe"
            src="" 
            data-src="https://www.youtube.com/embed/EcXRYV2HMng?autoplay=0&rel=0"
            title="Video Profil BENGPUSKOMLEKAD" 
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
            allowfullscreen
            style="display:none;">
          </iframe>
          <!-- Video thumbnail -->
          <img 
            src="assets/images/gedung-bengpus.jpeg" 
            alt="Video Profil" 
            id="video-thumbnail"
            style="position:absolute;top:0;left:0;width:100%;height:100%;object-fit:cover;">
        </div>
      </div>
    </section>
