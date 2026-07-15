<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: ../entering.php');
    exit;
}

require_once '../config/db.php';

// Ambil semua feedback dari DB
$conn = getDB();
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';

$whereClause = "";
if ($filter === 'unread') {
    $whereClause = "WHERE is_read = 0";
} elseif ($filter === 'read') {
    $whereClause = "WHERE is_read = 1";
}

$result = $conn->query("SELECT * FROM feedback $whereClause ORDER BY created_at DESC");
$feedbacks = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $feedbacks[] = $row;
    }
}
$conn->close();

$totalFeedback = count($feedbacks);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }
    :root {
      --gold: #c9a84c;
      --gold-dark: #8b7028;
      --gold-light: #e8d48b;
      --navy-darkest: #060d1a;
      --navy-dark: #0a1628;
      --navy: #1b3a5c;
      --white: #ffffff;
      --gray-100: #e4e7ec;
      --gray-200: #c8cdd6;
      --gray-300: #9aa3b0;
      --gray-400: #6b7685;
      --gray-500: #4a5568;
    }
    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(135deg, #273343ff 0%, #060d1a 100%);
      color: var(--white);
      min-height: 100vh;
    }

     body::before {
      content: '';
      position: fixed;
      inset: 0;
      background-image:
        linear-gradient(rgba(201,168,76,0.03) 1px, transparent 1px),
        linear-gradient(90deg, rgba(201,168,76,0.03) 1px, transparent 1px);
      background-size: 60px 60px;
      animation: gridMove 20s linear infinite;
      pointer-events: none;
    }
    @keyframes gridMove {
      0%   { background-position: 0 0; }
      100% { background-position: 60px 60px; }
    }
    
    /* Sidebar */
    .sidebar {
      position: fixed;
      top: 0; left: 0;
      width: 260px;
      height: 100vh;
      background: transparent
      border: none; 
      border-right: 1px solid rgba(201,168,76,0.15); 
      display: flex;
      flex-direction: column;
      z-index: 100;
      padding: 28px 0;

    }
    .sidebar-logo {
      padding: 0 24px 28px;
      border-bottom: 1px solid rgba(201,168,76,0.1);
    }
    .sidebar-logo .logo-img-wrap {
      width: 100px;
      height: 100px;
      border-radius: 10px;
      /*background: rgba(201,168,76,0.1);
      border: 1px solid rgba(201,168,76,0.25);*/
      display: flex; align-items: center; justify-content: center;
      margin-bottom: 12px;
      overflow: hidden;
      padding: 4px;
    }
    .sidebar-logo .logo-img-wrap img { width:100%; height:100%; object-fit:contain; }
    .sidebar-logo h2 {
      font-family: 'Oswald', sans-serif;
      font-size: 1rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 2px;
      color: var(--white);
    }
    .sidebar-logo h2 span { color: var(--gold); }
    .sidebar-logo p {
      font-size: 0.72rem;
      color: var(--gray-400);
      text-transform: uppercase;
      letter-spacing: 1px;
      margin-top: 2px;
    }
    .sidebar-nav {
      padding: 20px 0;
      flex: 1;
    }
    .sidebar-nav a {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 12px 24px;
      font-size: 0.85rem;
      color: var(--gray-300);
      text-decoration: none;
      transition: all 0.2s;
      border-left: 3px solid transparent;
    }
    .sidebar-nav a:hover,
    .sidebar-nav a.active {
      color: var(--gold);
      background: rgba(201,168,76,0.05);
      border-left-color: var(--gold);
    }
    .sidebar-nav a .nav-icon { font-size: 1rem; }
    .sidebar-footer {
      padding: 16px 24px;
      border-top: 1px solid rgba(201,168,76,0.1);
    }
    .logout-btn {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 10px;
      width: 100%;
      padding: 15px;
      background: linear-gradient(to right, rgba(201, 168, 76, 0) 0%, rgba(201, 168, 76, 1) 50%, rgba(201, 168, 76, 0) 100%);
      color: var(--navy-darkest);
      font-family: 'Oswald', sans-serif;
      font-size: 0.95rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 3px;
      border: none;
      border-radius: 0;
      cursor: pointer;
      transition: all 0.4s ease;
      position: relative;
      overflow: hidden;
      text-decoration: none;
    }
    .logout-btn:hover { 
      color: #000000;
      background: linear-gradient(to right, rgba(255, 215, 0, 0) 0%, rgba(255, 215, 0, 1) 50%, rgba(255, 215, 0, 0) 100%);
      transform: translateY(-2px);
      filter: drop-shadow(0 0 12px rgba(201, 168, 76, 0.5));
    }
    /* Main content */
    .main-content {
      margin-left: 260px;
      min-height: 100vh;
      padding: 0;
    }
    .topbar {
      background: rgba(10,22,40,0.8);
      backdrop-filter: blur(20px);
      border-bottom: 1px solid rgba(201,168,76,0.1);
      padding: 20px 36px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      position: sticky;
      top: 0;
      z-index: 50;
    }
    .topbar h1 {
      font-family: 'Oswald', sans-serif;
      font-size: 1.4rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 3px;
      color: var(--white);
    }
    .topbar h1 span { color: var(--gold); }
    .topbar-info {
      display: flex;
      align-items: center;
      gap: 16px;
    }
    /*.admin-badge {
      padding: 6px 16px;
      background: rgba(201,168,76,0.1);
      border: 1px solid rgba(201,168,76,0.3);
      border-radius: 100px;
      font-family: 'Oswald', sans-serif;
      font-size: 0.72rem;
      text-transform: uppercase;
      letter-spacing: 2px;
      color: var(--gold);
    }*/
    .content-area {
      padding: 36px;
    }
    /* Stats cards */
    .stats-row {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 20px;
      margin-bottom: 36px;
    }
    .stat-card {
      background: Colorless
      /*border: 1px solid rgba(201,168,76,0.15);
      border-radius: 12px;*/
      border: none; 
      border-right: 1px solid rgba(255,255,255,0.2); 
      border-radius: 0; 
      padding: 24px;
      transition: all 0.3s;
    }
    /*.stat-card:hover {
      border-color: rgba(201,168,76,0.3);
      transform: translateY(-2px);
    }*/
    .stat-card .stat-icon {
      font-size: 2rem;
      margin-bottom: 12px;
    }
    .stat-card .stat-num {
      font-family: 'Oswald', sans-serif;
      font-size: 2.5rem;
      font-weight: 700;
      color: var(--gold);
      line-height: 1;
    }
    .stat-card .stat-label {
      font-size: 0.78rem;
      text-transform: uppercase;
      letter-spacing: 2px;
      color: var(--gray-400);
      margin-top: 6px;
    }
    /* Feedback table */
    .section-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 20px;
    }
    .section-header h2 {
      font-family: 'Oswald', sans-serif;
      font-size: 1.2rem;
      text-transform: uppercase;
      letter-spacing: 2px;
      color: var(--white);
    }
    .section-header h2 span { color: var(--gold); }
    .gold-line-left {
      width: 50px;
      height: 2px;
      background: linear-gradient(90deg, var(--gold), transparent);
      margin-bottom: 20px;
    }
    .feedback-table-wrap {
      background: rgba(10,22,40,0.5);
      border: 1px solid rgba(201,168,76,0.12);
      border-radius: 12px;
      overflow: hidden;
    }
    .feedback-table {
      width: 100%;
      border-collapse: collapse;
    }
    .feedback-table thead tr {
      background: rgba(201,168,76,0.08);
      border-bottom: 1px solid rgba(201,168,76,0.15);
    }
    .feedback-table thead th {
      padding: 14px 20px;
      font-family: 'Oswald', sans-serif;
      font-size: 0.75rem;
      text-transform: uppercase;
      letter-spacing: 2px;
      color: var(--gold);
      text-align: left;
      font-weight: 600;
    }
    .feedback-table tbody tr {
      border-bottom: 1px solid rgba(255,255,255,0.04);
      transition: background 0.2s;
    }
    .feedback-table tbody tr:last-child { border-bottom: none; }
    .feedback-table tbody tr:hover { background: rgba(201,168,76,0.04); }
    .feedback-table tbody td {
      padding: 16px 20px;
      font-size: 0.88rem;
      color: var(--gray-200);
      vertical-align: top;
    }
    .feedback-table .td-nama { color: var(--white); font-weight: 500; }
    .feedback-table .td-email a {
      color: var(--white);
      text-decoration: none;
      font-size: 0.82rem;
    }
    .feedback-table .td-email a:hover { color: var(--gold-light); text-decoration: underline; }
    .feedback-table .td-pesan {
      color: var(--white);
      max-width: 340px;
      line-height: 1.6;
    }
    .feedback-table .td-waktu {
      font-size: 0.78rem;
      color: var(--white);
      white-space: nowrap;
    }
    .reply-btn {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 7px 14px;
      background: linear-gradient(135deg, var(--gold-dark), var(--gold));
      color: var(--navy-darkest);
      font-family: 'Oswald', sans-serif;
      font-size: 0.72rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 1px;
      border-radius: 6px;
      text-decoration: none;
      transition: all 0.2s;
      white-space: nowrap;
    }
    .reply-btn:hover {
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(201,168,76,0.3);
    }
    .empty-state {
      text-align: center;
      padding: 60px 20px;
      color: var(--gray-400);
    }
    .empty-state .empty-icon { font-size: 3rem; margin-bottom: 16px; }
    .empty-state p { font-size: 0.9rem; }
    .badge-new {
      display: inline-block;
      padding: 2px 8px;
      background: rgba(201,168,76,0.15);
      border: 1px solid rgba(201,168,76,0.3);
      border-radius: 100px;
      font-size: 0.65rem;
      font-family: 'Oswald', sans-serif;
      text-transform: uppercase;
      letter-spacing: 1px;
      color: var(--gold);
      margin-left: 8px;
      vertical-align: middle;
    }
    .badge-read {
      color: var(--white);
      font-size: 0.75rem;
      padding: 6px 12px;
      background: rgba(255,255,255,0.05);
      border-radius: 6px;
      display: inline-block;
    }
    .btn-read {
      display: inline-block;
      margin-top: 8px;
      padding: 6px 12px;
      background: rgba(40,167,69,0.1);
      border: 1px solid rgba(40,167,69,0.3);
      border-radius: 6px;
      color: #28a745;
      font-family: 'Oswald', sans-serif;
      font-size: 0.72rem;
      text-transform: uppercase;
      letter-spacing: 1px;
      text-decoration: none;
      transition: all 0.2s;
    }
    .btn-read:hover {
      background: rgba(40,167,69,0.2);
    }
    .filter-tabs {
      display: flex;
      gap: 12px;
      margin-bottom: 24px;
    }
    .filter-tabs a {
      padding: 8px 16px;
      background: colorless;
      border: none; 
      border-right: 1px solid rgba(255,255,255,0.2); 
      border-radius: 0;
      color: var(--gray-300);
      font-size: 0.85rem;
      text-decoration: none;
      transition: all 0.2s;
    }
    .filter-tabs a:hover {
      border-color: rgba(201,168,76,0.3);
      color: var(--white);
    }
    .filter-tabs a.active {
      background: rgba(201,168,76,0.1);
      border-color: var(--gold);
      color: var(--gold);
    }
    /* Notice banner */
    .notice-banner {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 14px 20px;
      background: rgba(74,139,194,0.1);
      border: 1px solid rgba(74,139,194,0.2);
      border-radius: 10px;
      margin-bottom: 28px;
      font-size: 0.85rem;
      color: var(--gray-200);
    }
    .notice-banner .notice-icon { font-size: 1.2rem; }
    @media (max-width: 900px) {
      .sidebar { width: 220px; }
      .main-content { margin-left: 220px; }
      .stats-row { grid-template-columns: 1fr 1fr; }
    }
      /* Responsive & Mobile Admin */
    .admin-hamburger {
      display: none;
      position: fixed;
      top: 15px;
      right: 20px;
      z-index: 1002;
      background: rgba(255,255,255,0.1);
      border: 1px solid rgba(255,255,255,0.2);
      color: #fff;
      padding: 8px 12px;
      border-radius: 5px;
      font-size: 1.5rem;
      cursor: pointer;
    }
    .admin-overlay {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(0,0,0,0.5);
      z-index: 99;
    }
    .admin-overlay.active { display: block; }
    
    .td-pesan-wrapper {
      max-height: 48px;
      overflow: hidden;
      transition: max-height 0.3s;
    }
    .btn-expand-pesan {
      background: none;
      border: none;
      color: var(--gray-300);
      cursor: pointer;
      font-size: 0.75rem;
      margin-top: 5px;
      display: inline-block;
    }
    .btn-expand-pesan:hover { color: #fff; }

    @media (max-width: 900px) {
      .admin-hamburger { display: block; }
      .sidebar {
        transform: translateX(-100%);
        transition: transform 0.3s;
        background: #060d1a;
      }
      .sidebar.active { transform: translateX(0); }
      .main-content { margin-left: 0; width: 100%; }
      .topbar { padding: 15px 20px; }
      .content-area { padding: 15px; }
      .stats-row { grid-template-columns: 1fr; }
      .feedback-table-wrap { overflow-x: auto; }
    }
  </style>
</head>
<body>

<!-- Hamburger Menu -->
<button class="admin-hamburger" onclick="toggleAdminMenu()">☰</button>
<div class="admin-overlay" onclick="toggleAdminMenu()"></div>
<!-- Sidebar -->
<aside class="sidebar">
  <div class="sidebar-logo">
    <div class="logo-img-wrap">
      <img src="../assets/images/logo-bengpus.png" alt="Logo">
    </div>
    <h2>BENGPUS<span> PUSKOMLEKAD</span></h2>
    <!--<p>Admin Panel</p>-->
  </div>
  <nav class="sidebar-nav">
    <a href="dashboard.php" class="active">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
      Feedback Masuk
    </a>
    <a href="berita.php">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
      Kelola Berita
    </a>
    <a href="pimpinan.php">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
      Kelola Pimpinan
    </a>
    <a href="../index.php" target="_blank">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
      Lihat Website
    </a>
  </nav>
  <div class="sidebar-footer">
    <a href="logout.php" class="logout-btn">
      <span>Logout</span>
    </a>
  </div>
</aside>

<!-- Main content -->
<main class="main-content">
  <div class="topbar">
    <h1>Dashboard <span>Admin</span></h1>
    <!--<div class="topbar-info">
      <span class="admin-badge">Ã°Å¸â€Â Admin</span>
    </div>-->
  </div>

  <div class="content-area">
    <!-- Stats -->
    <div class="stats-row">
      <div class="stat-card">
        <!--<div class="stat-icon">Total Feedback</div>-->
        <div class="stat-label">Total Feedback</div>
        <div class="stat-num"><?= $totalFeedback ?></div>
        <!--<div class="stat-label">Total Feedback</div>-->
      </div>
      <div class="stat-card">
        <!--<div class="stat-icon">Ã°Å¸â€œâ€¦</div>-->
        <div class="stat-label">Tanggal</div>
        <div class="stat-num"><?= date('d F Y') ?></div>
        <!--<div class="stat-label"><?= date('F Y') ?></div>-->
      </div>
      <!--<div class="stat-card">
        <div class="stat-icon">Ã°Å¸â€ºÂ¡Ã¯Â¸Â</div>
        <div class="stat-num">1</div>
        <div class="stat-label">Admin Aktif</div>
      </div>-->
    </div>

    <!-- Notice -->
    <div class="notice-banner">
      <span class="notice-icon">ℹ️</span>
      <span>Sebagai admin, Anda <strong>hanya dapat melihat dan membalas</strong> feedback. Data tidak dapat dihapus atau diubah untuk menjaga integritas catatan.</span>
    </div>

    <!-- Feedback list -->
    <div class="section-header">
      <h2>Daftar <span>Feedback</span></h2>
    </div>
    <div class="gold-line-left"></div>

    <div class="filter-tabs">
      <a href="dashboard.php?filter=all" class="<?= $filter=='all'?'active':'' ?>">Semua</a>
      <a href="dashboard.php?filter=unread" class="<?= $filter=='unread'?'active':'' ?>">Belum Dibaca</a>
      <a href="dashboard.php?filter=read" class="<?= $filter=='read'?'active':'' ?>">Sudah Dibaca</a>
    </div>

    <div class="feedback-table-wrap">
      <?php if (empty($feedbacks)): ?>
        <div class="empty-state">
          <div class="empty-icon">Ã°Å¸â€œÂ­</div>
          <p>Belum ada feedback yang masuk.</p>
        </div>
      <?php else: ?>
        <table class="feedback-table">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Email</th>
              <th>Pesan</th>
              <th>Waktu</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($feedbacks as $i => $fb): 
              $replySubject = urlencode('Re: Feedback kepada BENGPUSKOMLEKAD');
              $replyBody    = urlencode("Kepada Yth. " . $fb['nama'] . ",\n\nTerima kasih atas feedback Anda.\n\n---\nPesan Anda:\n" . $fb['pesan'] . "\n\n---\nHormat kami,\nTim BENGPUSKOMLEKAD");
              $mailtoLink   = "mailto:" . htmlspecialchars($fb['email']) . "?subject=" . $replySubject . "&body=" . $replyBody;
            ?>
            <tr>
              <td style="color:var(--white); font-size:0.78rem;"><?= $i + 1 ?></td>
              <td class="td-nama">
                <?= htmlspecialchars($fb['nama']) ?>
                <?php if (isset($fb['is_read']) && $fb['is_read'] == 0): ?>
                  <span class="badge-new">Baru</span>
                <?php endif; ?>
              </td>
              <td class="td-email">
                <a href="mailto:<?= htmlspecialchars($fb['email']) ?>"><?= htmlspecialchars($fb['email']) ?></a>
              </td>
              <td class="td-pesan">
                <div class="td-pesan-wrapper">
                  <?= nl2br(htmlspecialchars($fb['pesan'])) ?>
                </div>
                <?php if (strlen($fb['pesan']) > 100): ?>
                  <button class="btn-expand-pesan" onclick="togglePesan(this)">Selengkapnya</button>
                <?php endif; ?>
              </td>
              <td class="td-waktu"><?= date('d M Y', strtotime($fb['created_at'])) ?><br><span style="color:var(--white);"><?= date('H:i', strtotime($fb['created_at'])) ?></span></td>
              <td>
                <a href="<?= $mailtoLink ?>" class="reply-btn">Balas</a>
                <br>
                <?php if (isset($fb['is_read']) && $fb['is_read'] == 0): ?>
                  <a href="mark_read.php?id=<?= $fb['id'] ?>&filter=<?= $filter ?>" class="btn-read">Ã¢Å“â€ Tandai Dibaca</a>
                <?php else: ?>
                  <span class="badge-read" style="margin-top: 8px;">Tandai Dibaca</span>
                <?php endif; ?>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </div>
  </div>
</main>

<script>
function toggleAdminMenu() {
  document.querySelector('.sidebar').classList.toggle('active');
  document.querySelector('.admin-overlay').classList.toggle('active');
}
function togglePesan(btn) {
  const textDiv = btn.previousElementSibling;
  if (textDiv.style.maxHeight) {
    textDiv.style.maxHeight = null;
    btn.innerHTML = 'Selengkapnya';
  } else {
    textDiv.style.maxHeight = 'fit-content';
    btn.innerHTML = 'Tutup';
  }
}
</script>
</body>
</html>
