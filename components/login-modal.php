  <!-- ========== LOGIN MODAL ========== -->
  <div class="login-overlay" id="login-overlay" onclick="closeLoginOverlay(event)">
    <div class="login-modal" onclick="event.stopPropagation()">
      <button class="login-close" onclick="closeLogin()">✕</button>
      <div class="login-header">
        <div class="login-logo">BENGPUSKOMLEKAD</div>
        <h2>Login</h2>
        <p>Masuk ke sistem administrasi</p>
      </div>
      <form class="login-form" id="login-form" onsubmit="handleLogin(event)">
        <div class="form-group">
          <label for="login-email">Email</label>
          <input type="email" id="login-email" placeholder="nama@defensprima.co.id" required>
          <span class="form-icon">✉</span>
        </div>
        <div class="form-group">
          <label for="login-password">Password</label>
          <input type="password" id="login-password" placeholder="••••••••" required>
          <span class="form-icon">🔒</span>
        </div>
        <div class="form-row">
          <label class="remember-me">
            <input type="checkbox" checked>
            <span>Remember me</span>
          </label>
          <a href="#" class="forgot-link">Forgot Password?</a>
        </div>
        <button type="submit" class="login-submit-btn">Login</button>
      </form>
      <div class="login-register">
        Don't have an account? <a href="#">Register</a>
      </div>
    </div>
  </div>
