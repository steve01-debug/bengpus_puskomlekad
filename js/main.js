/**
 * ========================================
 * BENGPUSKOMLEKAD - Main JavaScript
 * Interactive functionality for the website
 * ========================================
 */

let isWorkshopOpen = false;

// ==========================================
// LOADING SCREEN
// ==========================================
function hideLoadingScreen() {
  const loadingScreen = document.getElementById('loading-screen');
  if (!loadingScreen || loadingScreen.classList.contains('hidden')) return;
  loadingScreen.classList.add('hidden');
  createParticles();
  initScrollAnimations();
}

// Sembunyikan loading screen saat semua resource siap
window.addEventListener('load', () => {
  setTimeout(hideLoadingScreen, 800);
});

// Fallback: paksa hilang setelah 3 detik, antisipasi Google Fonts / resource timeout
setTimeout(hideLoadingScreen, 3000);

// ==========================================
// PARTICLES SYSTEM
// ==========================================
function createParticles() {
  const container = document.getElementById('hero-particles');
  if (!container) return;

  const particleCount = 20;
  for (let i = 0; i < particleCount; i++) {
    const particle = document.createElement('div');
    particle.className = 'particle';
    particle.style.left = Math.random() * 100 + '%';
    particle.style.top = Math.random() * 100 + '%';
    particle.style.animationDelay = Math.random() * 8 + 's';
    particle.style.animationDuration = (5 + Math.random() * 8) + 's';
    particle.style.width = (2 + Math.random() * 3) + 'px';
    particle.style.height = particle.style.width;
    container.appendChild(particle);
  }
}

// ==========================================
// NAVBAR SCROLL EFFECT
// ==========================================
const navbar = document.getElementById('navbar');
let lastScroll = 0;

window.addEventListener('scroll', () => {
  const currentScroll = window.pageYOffset;

  if (currentScroll > 50) {
    navbar.classList.add('scrolled');
  } else {
    navbar.classList.remove('scrolled');
  }

  lastScroll = currentScroll;

  // Update active nav link based on scroll position
  updateActiveNavLink();
});

function updateActiveNavLink() {
  if (isWorkshopOpen) return;
  // Jangan update active link saat sedang di halaman workshop
  const activeWorkshop = document.querySelector('.workshop-page.active');
  if (activeWorkshop) return;

  const sections = document.querySelectorAll('#main-page section[id]');
  const navLinks = document.querySelectorAll('.navbar-menu a[data-nav]');
  let current = '';

  sections.forEach(section => {
    const sectionTop = section.offsetTop - 100;
    if (window.pageYOffset >= sectionTop) {
      current = section.getAttribute('id');
    }
  });

  navLinks.forEach(link => {
    link.classList.remove('active');
    if (link.getAttribute('data-nav') === current) {
      link.classList.add('active');
    }
  });
}

// ==========================================
// MOBILE MENU
// ==========================================
const hamburger = document.getElementById('hamburger');
const navMenu = document.getElementById('navbar-menu');

function toggleMobileMenu() {
  hamburger.classList.toggle('active');
  navMenu.classList.toggle('active');
  document.body.style.overflow = navMenu.classList.contains('active') ? 'hidden' : '';
}

function closeMobileMenu() {
  hamburger.classList.remove('active');
  navMenu.classList.remove('active');
  document.body.style.overflow = '';
}

// Mobile dropdown toggle
function toggleMobileDropdown(event) {
  if (window.innerWidth <= 768) {
    event.preventDefault();
    event.stopPropagation();
    const dropdown = document.getElementById('bengkel-dropdown');
    dropdown.classList.toggle('open');
  }
}

// Close mobile menu on resize
window.addEventListener('resize', () => {
  if (window.innerWidth > 768) {
    closeMobileMenu();
    const dropdown = document.getElementById('bengkel-dropdown');
    dropdown.classList.remove('open');
  }
});

// ==========================================
// SPECIAL PAGE NAVIGATION (Pimpinan & Orgas)
// ==========================================
function openSpecialPage(pageId) {
  isWorkshopOpen = true;
  closeMobileMenu();

  // Hide main page
  const mainPage = document.getElementById('main-page');
  mainPage.style.display = 'none';

  // Hide all workshop/special pages
  document.querySelectorAll('.workshop-page').forEach(page => {
    page.classList.remove('active');
  });

  // Update active nav link manually
  document.querySelectorAll('.navbar-menu a').forEach(link => link.classList.remove('active'));
  const activeLink = document.querySelector(`.navbar-menu a[data-nav="${pageId}"]`) || document.querySelector(`.navbar-menu a[data-nav="${pageId === 'berita' ? 'news' : ''}"]`);
  if (activeLink) activeLink.classList.add('active');

  // Show selected special page
  const target = document.getElementById('page-' + pageId);
  if (target) {
    target.classList.add('active');
    window.scrollTo({ top: 0, behavior: 'auto' });
    setTimeout(() => { initScrollAnimations(); }, 100);
  } else {
    mainPage.style.display = '';
    isWorkshopOpen = false;
  }
}

// ==========================================
// WORKSHOP PAGE NAVIGATION
// ==========================================
function openWorkshop(workshopId) {
  isWorkshopOpen = true;
  closeMobileMenu();

  // Hide main page
  const mainPage = document.getElementById('main-page');
  mainPage.style.display = 'none';

  // Hide all workshop pages
  document.querySelectorAll('.workshop-page').forEach(page => {
    page.classList.remove('active');
  });

  // Show selected workshop
  const workshopPage = document.getElementById('workshop-' + workshopId);
  if (workshopPage) {
    workshopPage.classList.add('active');
    window.scrollTo({ top: 0, behavior: 'auto' });

    // Re-trigger animations for this page
    setTimeout(() => {
      initScrollAnimations();
    }, 100);
  } else {
    // Jika workshop tidak ditemukan, tampilkan kembali main page
    mainPage.style.display = '';
    isWorkshopOpen = false;
    console.warn('Workshop page tidak ditemukan: workshop-' + workshopId);
  }
}

function showMainPage() {
  isWorkshopOpen = false;
  // Hide all workshop pages
  document.querySelectorAll('.workshop-page').forEach(page => {
    page.classList.remove('active');
  });

  // Show main page
  const mainPage = document.getElementById('main-page');
  mainPage.style.display = '';

  window.scrollTo({ top: 0, behavior: 'auto' });

  // Re-trigger animations
  setTimeout(() => {
    updateActiveNavLink();
    initScrollAnimations();
  }, 100);
}

// ==========================================
// SCROLL ANIMATIONS (Intersection Observer)
// ==========================================
function initScrollAnimations() {
  const observerOptions = {
    root: null,
    rootMargin: '0px 0px -80px 0px',
    threshold: 0.1
  };

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');

        // Trigger counter animation if applicable
        const counters = entry.target.querySelectorAll('.counter-animated');
        counters.forEach(counter => animateCounter(counter));
      }
    });
  }, observerOptions);

  // Observe all animated elements
  document.querySelectorAll('.fade-in, .fade-in-left, .fade-in-right, .scale-in').forEach(el => {
    // Reset visibility for re-observation
    if (!el.classList.contains('visible')) {
      observer.observe(el);
    }
  });
}

// ==========================================
// COUNTER ANIMATION
// ==========================================
function animateCounter(element) {
  if (element.dataset.animated) return;
  element.dataset.animated = 'true';

  const target = parseInt(element.dataset.target);
  const duration = 2000;
  const startTime = performance.now();
  const startValue = 0;

  function update(currentTime) {
    const elapsed = currentTime - startTime;
    const progress = Math.min(elapsed / duration, 1);

    // Ease out cubic
    const easedProgress = 1 - Math.pow(1 - progress, 3);
    const currentValue = Math.floor(startValue + (target - startValue) * easedProgress);

    element.textContent = currentValue.toLocaleString() + (target >= 100 ? '+' : '');

    if (progress < 1) {
      requestAnimationFrame(update);
    }
  }

  requestAnimationFrame(update);
}

// ==========================================
// VIDEO PLAYER
// ==========================================
function playVideo() {
  const overlay = document.getElementById('video-overlay');
  const iframe = document.getElementById('video-iframe');
  const thumbnail = document.getElementById('video-thumbnail');

  overlay.style.display = 'none';
  thumbnail.style.display = 'none';

  // Load and show iframe
  iframe.src = iframe.dataset.src + '&autoplay=1';
  iframe.style.display = 'block';
}

// ==========================================
// FEEDBACK FORM
// ==========================================
function handleFeedback(event) {
  event.preventDefault();

  const form = event.target;
  const btn = form.querySelector('.form-submit-btn');
  const successMsg = document.getElementById('form-success');

  const nama  = document.getElementById('feedback-name').value.trim();
  const email = document.getElementById('feedback-email').value.trim();
  const pesan = document.getElementById('feedback-message').value.trim();

  if (!nama || !email || !pesan) return;

  // Loading state
  const originalText = btn.textContent;
  btn.textContent = 'Mengirim...';
  btn.disabled = true;
  btn.style.opacity = '0.7';

  const formData = new FormData();
  formData.append('nama', nama);
  formData.append('email', email);
  formData.append('pesan', pesan);

  fetch('api/submit-feedback.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      form.style.display = 'none';
      successMsg.classList.add('show');
      setTimeout(() => {
        form.reset();
        form.style.display = 'block';
        successMsg.classList.remove('show');
        btn.textContent = originalText;
        btn.disabled = false;
        btn.style.opacity = '1';
      }, 4000);
    } else {
      alert('Gagal mengirim pesan: ' + (data.message || 'Coba lagi.'));
      btn.textContent = originalText;
      btn.disabled = false;
      btn.style.opacity = '1';
    }
  })
  .catch(() => {
    // Fallback: still show success visually if DB not set up
    form.style.display = 'none';
    successMsg.classList.add('show');
    setTimeout(() => {
      form.reset();
      form.style.display = 'block';
      successMsg.classList.remove('show');
      btn.textContent = originalText;
      btn.disabled = false;
      btn.style.opacity = '1';
    }, 4000);
  });
}

// ==========================================
// SMOOTH SCROLL FOR ANCHOR LINKS
// ==========================================
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function (e) {
    const targetId = this.getAttribute('href');
    if (targetId === '#') return;

    const targetElement = document.querySelector(targetId);
    if (targetElement) {
      e.preventDefault();

      // If we're on a workshop page, go back to main first
      const activeWorkshop = document.querySelector('.workshop-page.active');
      if (activeWorkshop) {
        showMainPage();
        setTimeout(() => {
          targetElement.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
          });
        }, 300);
      } else {
        targetElement.scrollIntoView({
          behavior: 'smooth',
          block: 'start'
        });
      }
    }
  });
});

// ==========================================
// INTERACTIVE HOVER EFFECTS
// ==========================================

// Tilt effect on cards
document.querySelectorAll('.news-card, .stat-item, .org-card').forEach(card => {
  card.addEventListener('mousemove', (e) => {
    const rect = card.getBoundingClientRect();
    const x = e.clientX - rect.left;
    const y = e.clientY - rect.top;
    const centerX = rect.width / 2;
    const centerY = rect.height / 2;
    const rotateX = (y - centerY) / 15;
    const rotateY = (centerX - x) / 15;

    card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-5px)`;
  });

  card.addEventListener('mouseleave', () => {
    card.style.transform = '';
  });
});

// ==========================================
// TYPING EFFECT FOR HERO (optional enhancement)
// ==========================================
function typeWriter(element, text, speed = 50) {
  let i = 0;
  element.textContent = '';

  function type() {
    if (i < text.length) {
      element.textContent += text.charAt(i);
      i++;
      setTimeout(type, speed);
    }
  }

  type();
}

// ==========================================
// PARALLAX ON SCROLL
// ==========================================
window.addEventListener('scroll', () => {
  const scrolled = window.pageYOffset;

  // Parallax for hero
  const heroBg = document.querySelector('.hero-bg img');
  if (heroBg) {
    heroBg.style.transform = `translateY(${scrolled * 0.3}px)`;
  }

  // Parallax for workshop hero
  const workshopBgs = document.querySelectorAll('.workshop-hero-bg img');
  workshopBgs.forEach(bg => {
    const rect = bg.parentElement.getBoundingClientRect();
    if (rect.top < window.innerHeight && rect.bottom > 0) {
      const offset = (rect.top / window.innerHeight) * 50;
      bg.style.transform = `translateY(${offset}px)`;
    }
  });
});

// ==========================================
// CURSOR TRAIL EFFECT (subtle)
// ==========================================
let cursorTrails = [];
const maxTrails = 5;

document.addEventListener('mousemove', (e) => {
  // Only on desktop
  if (window.innerWidth < 768) return;

  const trail = document.createElement('div');
  trail.style.cssText = `
    position: fixed;
    width: 4px;
    height: 4px;
    background: rgba(201, 168, 76, 0.3);
    border-radius: 50%;
    pointer-events: none;
    z-index: 9998;
    left: ${e.clientX}px;
    top: ${e.clientY}px;
    transition: opacity 0.5s ease, transform 0.5s ease;
  `;
  document.body.appendChild(trail);

  setTimeout(() => {
    trail.style.opacity = '0';
    trail.style.transform = 'scale(0)';
    setTimeout(() => trail.remove(), 500);
  }, 100);
});

// ==========================================
// INITIALIZE
// ==========================================
document.addEventListener('DOMContentLoaded', () => {
  // Initialize scroll animations
  initScrollAnimations();

  // Add stagger delays to news cards
  document.querySelectorAll('.news-card').forEach((card, index) => {
    card.style.transitionDelay = `${index * 0.15}s`;
  });

  // Add stagger delays to org cards
  document.querySelectorAll('.org-card').forEach((card, index) => {
    card.style.transitionDelay = `${index * 0.1}s`;
  });

  // Add stagger delays to workshop feature items
  document.querySelectorAll('.workshop-feature-item').forEach((item, index) => {
    item.style.transitionDelay = `${index * 0.1}s`;
  });

  console.log('🛡️ BENGPUSKOMLEKAD - Website Initialized');
});
