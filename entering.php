<?php
session_start();

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: entering.php');
    exit;
}

// Redirect ke dashboard jika sudah login
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: admin/dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username === 'admin' && $password === '123') {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_user'] = 'admin';
        header('Location: admin/dashboard.php');
        exit;
    } else {
        $error = 'Username atau password salah.';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login â€“ BENGPUSKOMLEKAD</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }
    :root {
      --gold: #c9a84c;
      --gold-dark: #8b7028;
      --navy-darkest: #060d1a;
      --navy-dark: #0a1628;
      --navy: #1b3a5c;
      --white: #ffffff;
      --gray-200: #c8cdd6;
      --gray-300: #9aa3b0;
      --gray-400: #6b7685;
    }
    body {
      font-family: 'Inter', sans-serif;
      /* 1. KEMBALI KE GRADASI BIRU GELAP ORIGINAL */
      background: linear-gradient(135deg, #2e343cff 0%, #060d1a 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      overflow: hidden;
    }
    /* Animated background grid */
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
    /* Glowing orb */
    body::after {
      content: '';
      position: fixed;
      top: -80px;
      left: 50%;
      transform: translateX(-50%);
      width: 600px;
      height: 600px;
      background: radial-gradient(circle, rgba(201,168,76,0.08) 0%, transparent 50%);
      pointer-events: none;
    }
    .login-wrapper {
      position: relative;
      z-index: 10;
      width: 100%;
      max-width: 420px;
      padding: 20px;
    }
    
    /* 2. KOTAK KARTU LATAR BELAKANG DIHILANGKAN TOTAL (FRAMELESS) */
    .login-box {
      background: transparent;
      backdrop-filter: none;
      border: none;
      border-radius: 0;
      padding: 10px 0;
      box-shadow: none;
      animation: fadeInUp 0.6s ease both;
    }
    @keyframes fadeInUp {
      from { opacity:0; transform:translateY(30px); }
      to   { opacity:1; transform:translateY(0); }
    }
    .login-logo {
      text-align: center;
      margin-bottom: 32px;
    }
    
    /* 3. UKURAN LOGO */
    .logo-img-wrap {
      width: 200px;
      height: 200px;
      margin: 0 auto 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      top: 40px;
      overflow: hidden;
    }
    .logo-img-wrap img {
      width: 100%;
      height: 100%;
      object-fit: contain;
    }
    .login-logo h1 {
      font-family: 'Oswald', sans-serif;
      font-size: 1.5rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 3px;
      color: var(--white);
    }
    .login-logo h1 span { color: var(--gold); }
    .login-logo p {
      margin-top: 6px;
      font-size: 0.8rem;
      color: var(--white);
      text-transform: uppercase;
      letter-spacing: 2px;
    }
    .divider {
      width: 60px;
      height: 2px;
      background: linear-gradient(90deg, transparent, var(--gold), transparent);
      margin: 20px auto;
    }
    .form-group {
      margin-bottom: 24px;
    }
    .form-group label {
      display: block;
      font-family: 'Oswald', sans-serif;
      font-size: 0.75rem;
      text-transform: uppercase;
      letter-spacing: 2px;
      color: var(--white);
      margin-bottom: 8px;
    }
    
    /* 4. KOTAK INPUT COLORLESS, BOX BORDER DIHILANGKAN (SISA UNDERLINE & NO ROUND) */
    .form-group input {
      width: 100%;
      padding: 12px 0; /* Padding kiri-kanan dihancurkan karena box hilang */
      background: transparent; /* Colorless / Transparan penuh */
      border: none; /* Bingkai luar kotak hilang */
      border-bottom: 1px solid rgba(255,255,255,0.2); /* Sisa garis bawah minimalis */
      border-radius: 0; /* Siku tajam sempurna */
      color: var(--white);
      font-family: 'Inter', sans-serif;
      font-size: 0.95rem;
      transition: all 0.3s;
      outline: none;
    }
    .form-group input:focus {
      border-bottom-color: var(--gold);
      background: transparent;
      box-shadow: none;
    }
    .error-msg {
      background: rgba(220,53,69,0.15);
      border: 1px solid rgba(220,53,69,0.3);
      border-radius: 8px;
      padding: 12px 16px;
      color: #ff6b7a;
      font-size: 0.85rem;
      margin-bottom: 20px;
      text-align: center;
    }
    
    /* 5. BUTTON MASUK DENGAN EFEK GRADASI FLARE (TENGAH TERANG, PINGGIR TRANSPARAN, NO ROUND) */
    .submit-btn {
      width: 100%;
      padding: 15px;
      /* Efek Flare: Kiri Transparan -> Tengah Emas Terang murni -> Kanan Transparan */
      background: linear-gradient(
        to right, 
        rgba(201, 168, 76, 0) 0%, 
        rgba(201, 168, 76, 1) 50%, 
        rgba(201, 168, 76, 0) 100%
      );
      color: var(--navy-darkest);
      font-family: 'Oswald', sans-serif;
      font-size: 0.95rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 3px;
      border: none;
      border-radius: 0; /* Siku kotak tajam di kanan-kiri */
      cursor: pointer;
      transition: all 0.4s ease;
      position: relative;
      overflow: hidden;
    }
    .submit-btn::before {
      display: none; /* Mematikan animasi kilatan lama agar tidak tabrakan dengan efek flare baru */
    }
    .submit-btn:hover {
      color: #000000;
      /* Efek bersinar lebih terang saat diarahkan kursor */
      background: linear-gradient(
        to right, 
        rgba(255, 215, 0, 0) 0%, 
        rgba(255, 215, 0, 1) 50%, 
        rgba(255, 215, 0, 0) 100%
      );
      transform: translateY(-2px);
      filter: drop-shadow(0 0 12px rgba(201, 168, 76, 0.5));
    }
    .back-link {
      display: block;
      text-align: center;
      margin-top: 20px;
      font-size: 0.82rem;
      color: var(--gray-300);
      text-decoration: none;
      transition: color 0.2s;
      letter-spacing: 1px;
    }
    .back-link:hover { color: var(--gold); }
    .classified-badge {
      text-align: center;
      margin-top: 24px;
      font-family: 'Oswald', sans-serif;
      font-size: 0.65rem;
      text-transform: uppercase;
      letter-spacing: 3px;
      color: rgba(201, 168, 76, 0.3);
    }
  </style>
</head>
<body>
  <div class="login-wrapper">
    <div class="login-box">
      <div class="login-logo">
        <div class="logo-img-wrap">
          <img src="assets/images/logo-bengpus.png" alt="Logo BENGPUSKOMLEKAD">
        </div>
        <!--<h1>BENGPUS<span>KOMLEKAD</span></h1>
        <p>Panel Administrasi</p>
        <div class="divider"></div>-->
      </div>

      <?php if ($error): ?>
        <div class="error-msg">âš ï¸ <?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <form method="POST" action="">
        <div class="form-group">
          <label for="username">Username</label>
          <input type="text" id="username" name="username" placeholder="Masukkan username" required autocomplete="username">
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" placeholder="Masukkan password" required autocomplete="current-password">
        </div>
        <button type="submit" class="submit-btn">Masuk &rarr;</button>
      </form>

      <a href="index.php" class="back-link">â† Kembali ke Website</a>
      <!--<div class="classified-badge">ðŸ”’ Akses Terbatas â€“ Personel Berwenang</div>-->
    </div>
  </div>
</body>
</html>