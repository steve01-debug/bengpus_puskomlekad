<?php 
// 1. Hubungkan ke database dengan aman
if (!function_exists('getDB')) { 
    require_once 'config/db.php'; 
}
$_conn_detail = getDB();

// 2. Ambil parameter ID dari URL browser (?id=...)
$id_berita = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$berita_data = null;

if ($id_berita > 0) {
    // Ambil data berita yang sesuai dengan ID dari tabel berita_db
    $stmt = $_conn_detail->prepare("SELECT * FROM berita_db WHERE id = ?");
    $stmt->bind_param("i", $id_berita);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res && $res->num_rows > 0) {
        $berita_data = $res->fetch_assoc();
    }
    $stmt->close();
}
$_conn_detail->close();

// 3. Jika ID tidak valid atau berita tidak ditemukan di database
if (!$berita_data) {
    echo "<div style='background:#060d1a; min-height:100vh; padding: 150px 20px; text-align: center; color: white; font-family:sans-serif;'>
            <h2>Maaf, berita tidak ditemukan atau telah dihapus.</h2><br>
            <a href='index.php' style='color:#c9a84c; text-decoration:none;'>← Kembali ke Beranda</a>
          </div>";
    exit;
}
?>

<?php include 'components/head.php'; ?>
<?php include 'components/navbar.php'; ?>

<div class="main-page" style="padding-top: 100px; min-height: 100vh; background: linear-gradient(135deg, #273343 0%, #060d1a 100%); color:#fff;">
  <div class="container" style="padding-top: 40px; padding-bottom: 60px; max-width: 900px; margin: 0 auto;">
    
    <span style="color: var(--gold, #c9a84c); text-transform: uppercase; font-size: 0.85rem; font-weight: bold; letter-spacing: 2px;">
        <?= htmlspecialchars($berita_data['kategori']) ?> • <?= date('d M Y', strtotime($berita_data['tanggal'])) ?>
    </span>
    
    <h1 style="color: #fff; margin-top: 12px; margin-bottom: 24px; font-family: 'Oswald', sans-serif; text-transform: uppercase; font-size: 2.3rem; line-height: 1.3; letter-spacing: 1px;">
        <?= htmlspecialchars($berita_data['judul']) ?>
    </h1>
    
    <?php 
      $gambarDetail = !empty($berita_data['gambar']) ? $berita_data['gambar'] : 'assets/images/gedung-bengpus.jpeg'; 
    ?>
    <img src="<?= htmlspecialchars($gambarDetail) ?>" alt="Berita" style="width: 100%; max-height: 480px; object-fit: cover; border-radius: 12px; margin-bottom: 32px; border: 1px solid rgba(201,168,76,0.2); display: block;">
    
    <div style="color: #c8cdd6; line-height: 1.8; font-size: 1.05rem; white-space: pre-line; font-family: 'Inter', sans-serif;">
      <?= nl2br(htmlspecialchars($berita_data['isi'])) ?>
    </div>
    
    <br><br>
    <hr style="border:0; border-top:1px solid rgba(201,168,76,0.15); margin-bottom:24px;">
    
    <a href="index.php" style="text-decoration: none; display: inline-block; padding: 10px 20px; border: 1px solid #c9a84c; color:#c9a84c; border-radius: 6px; font-family:'Oswald',sans-serif; text-transform:uppercase; letter-spacing:1px;">← Kembali</a>
  </div>
</div>

<?php include 'components/footer.php'; ?>
<?php include 'components/footer-scripts.php'; ?>