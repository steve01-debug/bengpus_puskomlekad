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

          <div class="pimpinan-timeline-item fade-in">
            <div class="timeline-year">2023 – 2023</div>
            <div class="timeline-connector"></div>
            <div class="pimpinan-card-small">
              <div class="pimpinan-photo-small">
                <img src="assets/images/kabeng-sholeh.jpg" alt="Kolonel Chb Moch. Sholeh, SH., M.M." class="pimpinan-kabeng-lama">
              </div>
              <div class="pimpinan-info-small">
                <div class="pimpinan-jabatan-label-small">Kepala Bengpuskomlekad</div>
                <div class="pimpinan-nama-small">Kolonel Chb Moch. Sholeh, SH., M.M.</div>
                <div class="pimpinan-nrp-small">NRP: 11XXXXXX</div>
              </div>
            </div>
          </div>

          <div class="pimpinan-timeline-item fade-in">
            <div class="timeline-year">2022 – 2023</div>
            <div class="timeline-connector"></div>
            <div class="pimpinan-card-small">
              <div class="pimpinan-photo-small">
                <img src="assets/images/kabeng-umang.jpg" alt="Kolonel Cke Muh. Hatta, M.P.M., MCap.Mgt." class="pimpinan-kabeng-lama">
              </div>
              <div class="pimpinan-info-small">
                <div class="pimpinan-jabatan-label-small">Kepala Bengpuskomlekad</div>
                <div class="pimpinan-nama-small">Kolonel Chb Umang Arfan Latsusmintarto, S.Si</div>
                <div class="pimpinan-nrp-small">NRP: 11XXXXXX</div>
              </div>
            </div>
          </div>

          <div class="pimpinan-timeline-item fade-in">
            <div class="timeline-year">2019 – 2022</div>
            <div class="timeline-connector"></div>
            <div class="pimpinan-card-small">
              <div class="pimpinan-photo-small">
                <img src="assets/images/kabeng-haryono.jpg" alt="Kolonel Chb Try Haryono, S.sos., M.M." class="pimpinan-kabeng-lama">
              </div>
              <div class="pimpinan-info-small">
                <div class="pimpinan-jabatan-label-small">Kepala Bengpuskomlekad</div>
                <div class="pimpinan-nama-small">Kolonel Chb Try Haryono, S.sos., M.M.</div>
                <div class="pimpinan-nrp-small">NRP: 11XXXXXX</div>
              </div>
            </div>
          </div>

          <div class="pimpinan-timeline-item fade-in">
            <div class="timeline-year">2019 – 2020</div>
            <div class="timeline-connector"></div>
            <div class="pimpinan-card-small">
              <div class="pimpinan-photo-small">
                <span> 😬 </span>
              </div>
              <div class="pimpinan-info-small">
                <div class="pimpinan-jabatan-label-small">Kepala Bengpuskomlekad</div>
                <div class="pimpinan-nama-small">Kolonel Chb Anang Murtioso, S.Si.</div>
                <div class="pimpinan-nrp-small">NRP: 11XXXXXX</div>
              </div>
            </div>
          </div>

          <div class="pimpinan-timeline-item fade-in">
            <div class="timeline-year">2018 – 2019</div>
            <div class="timeline-connector"></div>
            <div class="pimpinan-card-small">
              <div class="pimpinan-photo-small">
                <img src="assets/images/kabeng-prayitno.jpg" alt="Kolonel Cke Ir.Agus Budi Prayitno" class="pimpinan-kabeng-lama">
              </div>
              <div class="pimpinan-info-small">
                <div class="pimpinan-jabatan-label-small">Kepala Bengpuskomlekad</div>
                <div class="pimpinan-nama-small">Kolonel Cke Ir.Agus Budi Prayitno</div>
                <div class="pimpinan-nrp-small">NRP: 11XXXXXX</div>
              </div>
            </div>
          </div>

          <div class="pimpinan-timeline-item fade-in">
            <div class="timeline-year">2016 – 2018</div>
            <div class="timeline-connector"></div>
            <div class="pimpinan-card-small">
              <div class="pimpinan-photo-small">
                <img src="assets/images/kabeng-leo.jpg" alt="Kolonel Chb Drs. Leo Yunaidy Wibisono, M.A.P." class="pimpinan-kabeng-lama">
              </div>
              <div class="pimpinan-info-small">
                <div class="pimpinan-jabatan-label-small">Kepala Bengpuskomlekad</div>
                <div class="pimpinan-nama-small">Kolonel Chb Drs. Leo Yunaidy Wibisono, M.A.P.</div>
                <div class="pimpinan-nrp-small">NRP: 11XXXXXX</div>
              </div>
            </div>
          </div>

          <div class="pimpinan-timeline-item fade-in">
            <div class="timeline-year">2015 – 2016</div>
            <div class="timeline-connector"></div>
            <div class="pimpinan-card-small">
              <div class="pimpinan-photo-small">
                <img src="assets/images/kabeng-zakaria.jpg" alt="Kolonel Chb Zakaria" class="pimpinan-kabeng-lama">
              </div>
              <div class="pimpinan-info-small">
                <div class="pimpinan-jabatan-label-small">Kepala Bengpuskomlekad</div>
                <div class="pimpinan-nama-small">Kolonel Chb Zakaria</div>
                <div class="pimpinan-nrp-small">NRP: 11XXXXXX</div>
              </div>
            </div>
          </div>

          <div class="pimpinan-timeline-item fade-in">
            <div class="timeline-year">2014 – 2015</div>
            <div class="timeline-connector"></div>
            <div class="pimpinan-card-small">
              <div class="pimpinan-photo-small">
                <img src="assets/images/kabeng-totok.jpg" alt="Kolonel Chb Totok" class="pimpinan-kabeng-lama">
              </div>
              <div class="pimpinan-info-small">
                <div class="pimpinan-jabatan-label-small">Kepala Bengpuskomlekad</div>
                <div class="pimpinan-nama-small">Kolonel Chb Totok</div>
                <div class="pimpinan-nrp-small">NRP: 11XXXXXX</div>
              </div>
            </div>
          </div>

          <div class="pimpinan-timeline-item fade-in">
            <div class="timeline-year">2011 – 2014</div>
            <div class="timeline-connector"></div>
            <div class="pimpinan-card-small">
              <div class="pimpinan-photo-small">
                <img src="assets/images/kabeng-sasmito.jpg" alt="Kolonel Chb Sasmito Yupitoro, S.T." class="pimpinan-kabeng-lama">
              </div>
              <div class="pimpinan-info-small">
                <div class="pimpinan-jabatan-label-small">Kepala Bengpuskomlekad</div>
                <div class="pimpinan-nama-small">Kolonel Chb Sasmito Yupitoro, S.T.</div>
                <div class="pimpinan-nrp-small">NRP: 11XXXXXX</div>
              </div>
            </div>
          </div>

          <div class="pimpinan-timeline-item fade-in">
            <div class="timeline-year">2006 – 2011</div>
            <div class="timeline-connector"></div>
            <div class="pimpinan-card-small">
              <div class="pimpinan-photo-small">
                <img src="assets/images/kabeng-harijono.jpg" alt="Kolonel Chb Harijono, S.T." class="pimpinan-kabeng-lama">
              </div>
              <div class="pimpinan-info-small">
                <div class="pimpinan-jabatan-label-small">Kepala Bengpuskomlekad</div>
                <div class="pimpinan-nama-small">Kolonel Chb Harijono, S.T.</div>
                <div class="pimpinan-nrp-small">NRP: 11XXXXXX</div>
              </div>
            </div>
          </div>

          <div class="pimpinan-timeline-item fade-in">
            <div class="timeline-year">2003 – 2006</div>
            <div class="timeline-connector"></div>
            <div class="pimpinan-card-small">
              <div class="pimpinan-photo-small">
                <img src="assets/images/kabeng-sumarno.jpg" alt="Kolonel Chb Sumarno" class="pimpinan-kabeng-lama">
              </div>
              <div class="pimpinan-info-small">
                <div class="pimpinan-jabatan-label-small">Kepala Bengpuskomlekad</div>
                <div class="pimpinan-nama-small">Kolonel Chb Sumarno</div>
                <div class="pimpinan-nrp-small">NRP: 11XXXXXX</div>
              </div>
            </div>
          </div>

          <div class="pimpinan-timeline-item fade-in">
            <div class="timeline-year">1997 – 2003</div>
            <div class="timeline-connector"></div>
            <div class="pimpinan-card-small">
              <div class="pimpinan-photo-small">
                <img src="assets/images/kabeng-supribadio.jpg" alt="Kolonel Chb E. Supribadio. TE" class="pimpinan-kabeng-lama">
              </div>
              <div class="pimpinan-info-small">
                <div class="pimpinan-jabatan-label-small">Kepala Bengpuskomlekad</div>
                <div class="pimpinan-nama-small">Kolonel Chb E. Supribadio. TE</div>
                <div class="pimpinan-nrp-small">NRP: 11XXXXXX</div>
              </div>
            </div>
          </div>

          <div class="pimpinan-timeline-item fade-in">
            <div class="timeline-year">1991 – 1997</div>
            <div class="timeline-connector"></div>
            <div class="pimpinan-card-small">
              <div class="pimpinan-photo-small">
                <img src="assets/images/kabeng-wiyono.jpg" alt="Kolonel Chb Wiyono" class="pimpinan-kabeng-lama">
              </div>
              <div class="pimpinan-info-small">
                <div class="pimpinan-jabatan-label-small">Kepala Bengpuskomlekad</div>
                <div class="pimpinan-nama-small">Kolonel Chb Wiyono</div>
                <div class="pimpinan-nrp-small">NRP: 11XXXXXX</div>
              </div>
            </div>
          </div>

          <div class="pimpinan-timeline-item fade-in">
            <div class="timeline-year">1987 – 1991</div>
            <div class="timeline-connector"></div>
            <div class="pimpinan-card-small">
              <div class="pimpinan-photo-small">
                <img src="assets/images/kabeng-widoyo.jpg" alt="Kolonel Chb Widoyo" class="pimpinan-kabeng-lama">
              </div>
              <div class="pimpinan-info-small">
                <div class="pimpinan-jabatan-label-small">Kepala Bengpuskomlekad</div>
                <div class="pimpinan-nama-small">Kolonel Chb Widoyo</div>
                <div class="pimpinan-nrp-small">NRP: 11XXXXXX</div>
              </div>
            </div>
          </div>

          <div class="pimpinan-timeline-item fade-in">
            <div class="timeline-year">1980 – 1987</div>
            <div class="timeline-connector"></div>
            <div class="pimpinan-card-small">
              <div class="pimpinan-photo-small">
                <img src="assets/images/kabeng-priyambodo.jpg" alt="Kolonel Chb Priyambodo" class="pimpinan-kabeng-lama">
              </div>
              <div class="pimpinan-info-small">
                <div class="pimpinan-jabatan-label-small">Kepala Bengpuskomlekad</div>
                <div class="pimpinan-nama-small">Kolonel Chb Priyambodo</div>
                <div class="pimpinan-nrp-small">NRP: 11XXXXXX</div>
              </div>
            </div>
          </div>

          <div class="pimpinan-timeline-item fade-in">
            <div class="timeline-year">1972 – 1980</div>
            <div class="timeline-connector"></div>
            <div class="pimpinan-card-small">
              <div class="pimpinan-photo-small">
                <img src="assets/images/kabeng-karnoto.jpg" alt="Kolonel Chb R. Karnoto (alm)" class="pimpinan-kabeng-lama">
              </div>
              <div class="pimpinan-info-small">
                <div class="pimpinan-jabatan-label-small">Kepala Bengpuskomlekad</div>
                <div class="pimpinan-nama-small">Kolonel Chb R. Karnoto (alm)</div>
                <div class="pimpinan-nrp-small">NRP: 11XXXXXX</div>
              </div>
            </div>
          </div>

          <div class="pimpinan-timeline-item fade-in">
            <div class="timeline-year">1970 – 1972</div>
            <div class="timeline-connector"></div>
            <div class="pimpinan-card-small">
              <div class="pimpinan-photo-small">
                <img src="assets/images/kabeng-harmono.jpg" alt="Letnan Kolonel Chb Harmono (alm)" class="pimpinan-kabeng-lama">
              </div>
              <div class="pimpinan-info-small">
                <div class="pimpinan-jabatan-label-small">Kepala Bengpuskomlekad</div>
                <div class="pimpinan-nama-small">Letnan Kolonel Chb Harmono (alm)</div>
                <div class="pimpinan-nrp-small">NRP: 11XXXXXX</div>
              </div>
            </div>
          </div>

          <div class="pimpinan-timeline-item fade-in">
            <div class="timeline-year">1966 – 1970 </div>
            <div class="timeline-connector"></div>
            <div class="pimpinan-card-small">
              <div class="pimpinan-photo-small">
                <img src="assets/images/kabeng-drondio.jpg" alt="Letnan Kolonel Chb Drondio (alm)" class="pimpinan-kabeng-lama">
              </div>
              <div class="pimpinan-info-small">
                <div class="pimpinan-jabatan-label-small">Kepala Bengpuskomlekad</div>
                <div class="pimpinan-nama-small">Letnan Kolonel Chb Drondio (alm)</div>
                <div class="pimpinan-nrp-small">NRP: 11XXXXXX</div>
              </div>
            </div>
          </div>

          <div class="pimpinan-timeline-item fade-in">
            <div class="timeline-year">1961 – 1966</div>
            <div class="timeline-connector"></div>
            <div class="pimpinan-card-small">
              <div class="pimpinan-photo-small">
                <img src="assets/images/kabeng-poedjadi.jpg" alt="Letnan Kolonel Chb Poedjadi (alm)" class="pimpinan-kabeng-lama">
              </div>
              <div class="pimpinan-info-small">
                <div class="pimpinan-jabatan-label-small">Kepala Bengpuskomlekad</div>
                <div class="pimpinan-nama-small">Letnan Kolonel Chb Poedjadi (alm)</div>
                <div class="pimpinan-nrp-small">NRP: 11XXXXXX</div>
              </div>
            </div>
          </div>

          <div class="pimpinan-timeline-item fade-in">
            <div class="timeline-year">1950 – 1961</div>
            <div class="timeline-connector"></div>
            <div class="pimpinan-card-small">
              <div class="pimpinan-photo-small">
                <img src="assets/images/kabeng-harjadi.jpg" alt="Letnan Satu Chb Harjadi (alm)" class="pimpinan-kabeng-lama">
              </div>
              <div class="pimpinan-info-small">
                <div class="pimpinan-jabatan-label-small">Kepala Bengpuskomlekad</div>
                <div class="pimpinan-nama-small">Letnan Satu Chb Harjadi (alm)</div>
                <div class="pimpinan-nrp-small">NRP: 11XXXXXX</div>
              </div>
            </div>
          </div>

        </div><!-- end timeline -->
      </div>
    </section>
  </div>
