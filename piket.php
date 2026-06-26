<?php
session_start();

// Mengatur zona waktu ke Indonesia/Jakarta
date_default_timezone_set('Asia/Jakarta');

// Fungsi untuk membuat tanggal dalam format Indonesia secara manual
function tanggal_indonesia($timestamp) {
    $hari = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
    $bulan = [
        1 => "Januari", "Februari", "Maret", "April", "Mei", "Juni", 
        "Juli", "Agustus", "September", "Oktober", "November", "Desember"
    ];
    
    $num_hari = date('w', $timestamp);
    $tgl = date('j', $timestamp);
    $num_bulan = date('n', $timestamp);
    $tahun = date('Y', $timestamp);
    
    return $hari[$num_hari] . ", " . $tgl . " " . $bulan[$num_bulan] . " " . $tahun;
}

$tanggal_hari_ini = tanggal_indonesia(time());

$daftar_kelas = ["kelas_A", "kelas_B"];
$rekap = $_SESSION['rekap_piket'] ?? [];

// Hitung akumulasi rekapitulasi sekolah total
$jumlah_total = 0;
$jumlah_hadir = 0;
$jumlah_kurang = 0;
$rekap_keterangan = [];

foreach ($rekap as $kelas => $data) {
    $jumlah_total += $data['total'];
    $jumlah_hadir += $data['hadir'];
    $jumlah_kurang += $data['kurang'];
    
    foreach ($data['keterangan'] as $ket => $jumlah) {
        if (isset($rekap_keterangan[$ket])) {
            $rekap_keterangan[$ket] += $jumlah;
        } else {
            $rekap_keterangan[$ket] = $jumlah;
        }
    }
}

// Cek status input kelas aktif
$kelas_aktif = $_GET['edit'] ?? null;
if ($kelas_aktif && !in_array($kelas_aktif, $daftar_kelas)) {
    $kelas_aktif = null;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laporan Piket Harian – BENGPUSKOMLEKAD</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }
    :root {
      --gold: #c9a84c;
      --navy-darkest: #060d1a;
      --white: #ffffff;
      --gray-200: #c8cdd6;
      --gray-300: #9aa3b0;
      --gray-400: #6b7685;
    }
    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(135deg, #273343 0%, #060d1a 100%);
      color: var(--white);
      min-height: 100vh;
      padding: 50px 20px;
    }
    body::before {
      content: '';
      position: fixed;
      inset: 0;
      background-image:
        linear-gradient(rgba(201,168,76,0.02) 1px, transparent 1px),
        linear-gradient(90deg, rgba(201,168,76,0.02) 1px, transparent 1px);
      background-size: 60px 60px;
      animation: gridMove 30s linear infinite;
      pointer-events: none;
    }
    @keyframes gridMove {
      0% { background-position: 0 0; }
      100% { background-position: 60px 60px; }
    }
    .container {
      max-width: 1100px;
      margin: 0 auto;
    }
    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 1px solid rgba(201,168,76,0.2);
      padding-bottom: 20px;
      margin-bottom: 40px;
    }
    .header-title-area {
      display: flex;
      align-items: baseline;
      gap: 15px;
    }
    header h1 {
      font-family: 'Oswald', sans-serif;
      font-size: 1.5rem;
      letter-spacing: 3px;
      text-transform: uppercase;
    }
    header h1 span { color: var(--gold); }
    .header-date {
      font-size: 0.85rem;
      color: var(--gray-300);
      letter-spacing: 0.5px;
      border-left: 1px solid rgba(255,255,255,0.2);
      padding-left: 15px;
    }
    .reset-btn {
      font-family: 'Oswald', sans-serif;
      font-size: 0.75rem;
      color: #ff6b7a;
      text-decoration: none;
      padding: 6px 14px;
      border-radius: 5px;
      border: 1px solid rgba(220,53,69,0.3);
      letter-spacing: 1.5px;
      text-transform: uppercase;
      transition: 0.2s;
    }
    .reset-btn:hover { background: rgba(220,53,69,0.15); }
    
    .grid-layout {
      display: grid;
      grid-template-columns: 1fr 1.2fr;
      gap: 60px;
    }
    @media(max-width: 850px) { .grid-layout { grid-template-columns: 1fr; gap: 40px; } }

    .panel-header {
      font-family: 'Oswald', sans-serif;
      font-size: 1.1rem;
      letter-spacing: 2px;
      text-transform: uppercase;
      color: var(--gold);
      margin-bottom: 4px;
    }
    .gold-line {
      width: 40px;
      height: 2px;
      background: var(--gold);
      margin-bottom: 24px;
    }
    
    /* Input Form Clean Mode */
    .input-border-box {
      border-left: 1px solid rgba(201,168,76,0.3);
      padding-left: 24px;
    }
    .form-group { margin-bottom: 20px; }
    .form-group label {
      display: block;
      font-size: 0.72rem;
      text-transform: uppercase;
      color: var(--gray-400);
      letter-spacing: 1.5px;
      margin-bottom: 6px;
    }
    .form-group input {
      width: 100%;
      background: transparent;
      border: none;
      border-bottom: 1px solid rgba(255,255,255,0.15);
      padding: 8px 0;
      color: var(--white);
      font-size: 1rem;
      outline: none;
      transition: 0.2s;
    }
    .form-group input:focus { border-bottom-color: var(--gold); }
    
    .dynamic-input-row {
      margin-bottom: 10px;
    }
    .dynamic-input-row input {
      width: 100%;
      background: rgba(255,255,255,0.03);
      border: 1px solid rgba(255,255,255,0.08);
      padding: 8px 12px;
      color: var(--white);
      font-size: 0.88rem;
      outline: none;
    }
    .dynamic-input-row input:focus { border-color: var(--gold); }
    
    .submit-btn {
      background: var(--gold);
      color: var(--navy-darkest);
      border: none;
      font-family: 'Oswald', sans-serif;
      font-size: 0.8rem;
      font-weight: 700;
      letter-spacing: 1.5px;
      text-transform: uppercase;
      padding: 10px 24px;
      cursor: pointer;
      transition: 0.2s;
      border-radius: 5px;
    }
    .submit-btn:hover { background: #e8d48b; transform: translateY(-1px); }

    /* Minimalist Cards Line */
    .row-kelas {
      border-bottom: 1px solid rgba(255,255,255,0.05);
      padding: 16px 0;
    }
    .row-kelas:first-child { padding-top: 0; }
    .row-kelas-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .row-kelas-header h3 {
      font-family: 'Oswald', sans-serif;
      font-size: 0.95rem;
      letter-spacing: 1px;
      text-transform: uppercase;
    }
    .action-link {
      font-size: 0.75rem;
      color: var(--gold);
      text-decoration: none;
      letter-spacing: 0.5px;
    }
    .action-link:hover { text-decoration: underline; }
    
    .metrics-line {
      display: flex;
      gap: 28px;
      margin-top: 8px;
      font-size: 0.85rem;
      color: var(--gray-300);
    }
    .metrics-line span strong { color: var(--white); font-weight: 500; }
    
    /* Tags Keterangan Minimalis */
    .tag-container {
      display: flex;
      flex-wrap: wrap;
      gap: 6px;
      margin-top: 10px;
    }
    .tag-piket {
      font-size: 0.72rem;
      background: rgba(255,255,255,0.03);
      padding: 3px 10px;
      border: 1px solid rgba(255,255,255,0.08);
      color: var(--gray-200);
    }

    /* Total Board Boarder-only */
    .summary-box {
      border-top: 1px solid rgba(201,168,76,0.3);
      margin-top: 35px;
      padding-top: 25px;
    }
    .summary-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 15px;
      text-align: left;
    }
    .summary-item {
      border-right: 1px solid rgba(255,255,255,0.1);
      padding-left: 5px;
    }
    .summary-item:last-child { border-right: none; }
    .summary-val {
      font-family: 'Oswald', sans-serif;
      font-size: 2rem;
      line-height: 1;
      color: var(--gold);
    }
    .summary-lbl {
      font-size: 0.68rem;
      text-transform: uppercase;
      color: var(--gray-400);
      letter-spacing: 1px;
      margin-top: 4px;
    }
  </style>
</head>
<body>

<div class="container">
  <header>
    <div class="header-title-area">
      <h1>Piket <span>Bengpus Puskomlekad</span></h1>
      <div class="header-date"><?= $tanggal_hari_ini ?></div>
    </div>
    <a href="kode-piket?action=reset" class="reset-btn" onclick="return confirm('Hapus seluruh rekap absensi hari ini?')">Reset Data</a>
  </header>

  <div class="grid-layout">
    
    <div class="panel-kiri">
      <?php if ($kelas_aktif): ?>
        <h2 class="panel-header">Entri Data: <?= strtoupper(str_replace('_', ' ', $kelas_aktif)) ?></h2>
        <div class="gold-line"></div>
        
        <div class="input-border-box">
          <form action="kode-piket" method="POST">
            <input type="hidden" name="action" value="simpan_piket">
            <input type="hidden" name="kelas" value="<?= $kelas_aktif ?>">
            
            <div class="form-group">
              <label>Kekuatan Kuat (Total Siswa)</label>
              <input type="number" name="total" value="<?= $rekap[$kelas_aktif]['total'] ?? '' ?>" required min="0" id="in_total">
            </div>
            
            <div class="form-group">
              <label>Kurang (Tidak Hadir)</label>
              <input type="number" name="kurang" value="<?= $rekap[$kelas_aktif]['kurang'] ?? '' ?>" required min="0" id="in_kurang" oninput="renderKeteranganInput()">
            </div>

            <div id="dynamic_keterangan_fields">
               <?php if (isset($rekap[$kelas_aktif]['keterangan'])): ?>
                 <label style="display:block; font-size: 0.72rem; text-transform: uppercase; color: var(--gray-400); letter-spacing:1.5px; margin-bottom: 10px;">Keterangan Alasan:</label>
                 <?php foreach ($rekap[$kelas_aktif]['keterangan'] as $ket => $jml): for($i=0; $i<$jml; $i++): ?>
                   <div class="dynamic-input-row"><input type="text" name="keterangan[]" value="<?= htmlspecialchars($ket) ?>" placeholder="Masukkan alasan (Sakit/Izin/Dinas)" required></div>
                 <?php endfor; endforeach; ?>
               <?php endif; ?>
            </div>
            
            <div style="margin-top: 28px;">
              <button type="submit" class="submit-btn">Simpan</button>
              <a href="piket" style="color:var(--gray-400); font-size:0.8rem; margin-left:20px; text-decoration:none; uppercase; letter-spacing:1px;">Batal</a>
            </div>
          </form>
        </div>
      <?php else: ?>
        <h2 class="panel-header">Instruksi Penggunaan</h2>
        <div class="gold-line"></div>
        <div class="input-border-box" style="border-left-color: rgba(201,168,76,0.15)">
          
          <ol style="padding-left: 18px; font-size: 0.88rem; color: var(--gray-300); line-height: 1.8;">
            <li style="margin-bottom: 8px; padding-left: 5px;">Pilih input absensi di bagian Data Apel.</li>
            <li style="margin-bottom: 8px; padding-left: 5px;">Masukkan data yang sesuai.</li>
            <li style="margin-bottom: 8px; padding-left: 5px;">Jika ada keterangan tidak hadir, ketik alasan di kolom keterangan.</li>
            <li style="margin-bottom: 8px; padding-left: 5px;">Pengisian keterangan harap disamakan hurufnya (kapital/huruf kecil).</li>
            <li style="margin-bottom: 0; padding-left: 5px;">Simpan data.</li>
          </ol>

        </div>
      <?php endif; ?>
    </div>

    <div class="panel-kanan">
      <h2 class="panel-header">Data Apel</h2>
      <div class="gold-line"></div>
      
      <div style="margin-bottom: 40px;">
        <?php foreach ($daftar_kelas as $kelas): ?>
          <div class="row-kelas">
            <div class="row-kelas-header">
              <h3><?= strtoupper(str_replace('_', ' ', $kelas)) ?></h3>
              <a href="piket?edit=<?= $kelas ?>" class="action-link">
                <?= isset($rekap[$kelas]) ? '✏️ Koreksi Data' : '+ Input Absensi' ?>
              </a>
            </div>
            
            <?php if (isset($rekap[$kelas])): ?>
              <div class="metrics-line">
                <span>Kuat: <strong><?= $rekap[$kelas]['total'] ?></strong></span>
                <span>Hadir: <strong><?= $rekap[$kelas]['hadir'] ?></strong></span>
                <span>Kurang: <strong style="color:#ff6b7a;"><?= $rekap[$kelas]['kurang'] ?></strong></span>
              </div>
              <?php if (!empty($rekap[$kelas]['keterangan'])): ?>
                <div class="tag-container">
                  <?php foreach ($rekap[$kelas]['keterangan'] as $ket => $jumlah): ?>
                    <span class="tag-piket"><?= htmlspecialchars($ket) ?>: <?= $jumlah ?></span>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
            <?php else: ?>
              <p style="font-size: 0.8rem; color: var(--gray-400); margin-top: 4px; font-style: italic;">Data belum dilaporkan.</p>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>

      <h2 class="panel-header">Laporan</h2>
      <div class="gold-line"></div>
      
      <div class="summary-box">
        <div class="summary-grid">
          <div class="summary-item">
            <div class="summary-val" style="color: #ffffffff;"><?= $jumlah_total ?></div>
            <div class="summary-lbl">Total Personel</div>
          </div>
          <div class="summary-item">
            <div class="summary-val" style="color: #ff6b7a;"><?= $jumlah_kurang ?></div>
            <div class="summary-lbl">Kurang</div>
          </div>
        
          <div class="summary-item">
            <div class="summary-val" style="color: #ffffffff;"><?= $jumlah_hadir ?></div>
            <div class="summary-lbl">Hadir Nyata</div>
          </div>
        </div>  

        <div style="margin-top: 25px; padding: 15px; background: rgba(255,255,255,0.02); border: 1px dashed rgba(201,168,76,0.2); font-size: 0.85rem; line-height: 1.6; color: var(--gray-200);border-radius: 5px;">
          <!--<strong style="color: var(--gold); display: block; margin-bottom: 10px; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 1px;">Laporan Narasi Piket:</strong>-->
          <?php 
          if ($jumlah_total > 0) {
              // Menyusun teks keterangan alasan jika ada yang kurang
              $teks_alasan = [];
              if (!empty($rekap_keterangan)) {
                  foreach ($rekap_keterangan as $ket => $jumlah) {
                      $teks_alasan[] = htmlspecialchars($ket) . " ({$jumlah} orang)";
                  }
              }
              $string_alasan = !empty($teks_alasan) ? implode(", ", $teks_alasan) : "Nihil";

              // Tampilan sejajar menggunakan sistem Grid inline
              echo '
              <div style="display: grid; grid-template-columns: 90px 15px 1fr; row-gap: 6px; font-size: 0.9rem;">
                <div>Jumlah</div> <div>:</div> <div><strong>' . $jumlah_total . ' orang</strong></div>
                <div>Kurang</div> <div>:</div> <div><strong>' . $jumlah_kurang . ' orang</strong></div>
                <div>Hadir</div>  <div>:</div> <div><strong>' . $jumlah_hadir . ' orang</strong></div>
                <div>Keterangan</div> <div>:</div> <div><em>' . $string_alasan . '</em></div>
              </div>';
          } else {
              echo "<span style='font-style: italic; color: var(--gray-400);'>Belum ada data apel.</span>";
          }
          ?>
        </div>
        
        <div style="margin-top: 25px;">
          <p style="font-size: 0.68rem; text-transform: uppercase; color: var(--gray-400); letter-spacing: 1px; margin-bottom: 8px;">Daftar Distribusi Keterangan Absen:</p>
          <?php if (!empty($rekap_keterangan)): ?>
            <div class="tag-container">
              <?php foreach ($rekap_keterangan as $ket => $jumlah): ?>
                <span class="tag-piket" style="border-color: var(--gold); color: var(--gold); font-weight: 500;"><?= htmlspecialchars($ket) ?> : <?= $jumlah ?></span>
              <?php endforeach; ?>
            </div>
          <?php else: ?>
            <p style="font-size: 0.8rem; color: var(--gray-400); font-style: italic;">Nihil (Kekuatan Lengkap).</p>
          <?php endif; ?>
        </div>
      </div>

    </div>

  </div>
</div>

<script>
function renderKeteranganInput() {
    const kurang = parseInt(document.getElementById('in_kurang').value) || 0;
    const container = document.getElementById('dynamic_keterangan_fields');
    
    let html = '<label style="display:block; font-size: 0.72rem; text-transform: uppercase; color: var(--gray-400); letter-spacing:1.5px; margin-bottom: 10px;">Keterangan Alasan:</label>';
    
    if (kurang === 0) {
        container.innerHTML = '';
        return;
    }

    for (let i = 0; i < kurang; i++) {
        html += `
          <div class="dynamic-input-row">
            <input type="text" name="keterangan[]" placeholder="Alasan personel ke-${i+1} (Sakit / Izin / Alpa)" required>
          </div>`;
    }
    
    container.innerHTML = html;
}
</script>

</body>
</html>