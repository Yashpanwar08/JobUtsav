// script (1).js
document.addEventListener('DOMContentLoaded', () => {

  /* =========================
     Mobile Navbar Toggle
  ========================= */
  const menuBtn = document.getElementById('menuBtn');
  const mobileNav = document.getElementById('mobileNav');

  if (menuBtn && mobileNav) {
    menuBtn.addEventListener('click', () => {
      const open = mobileNav.classList.toggle('show');
      menuBtn.setAttribute('aria-expanded', String(open));
    });

    // Close on link click (mobile)
    mobileNav.querySelectorAll('a').forEach(a => {
      a.addEventListener('click', () => {
        mobileNav.classList.remove('show');
        menuBtn.setAttribute('aria-expanded', 'false');
      });
    });
  }

  /* =========================
     Smooth scroll for internal anchors
  ========================= */
  document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', (e) => {
      const id = a.getAttribute('href');
      const target = document.querySelector(id);
      if (target) {
        e.preventDefault();
        const y = target.getBoundingClientRect().top + window.scrollY - 80;
        window.scrollTo({ top: y, behavior: 'smooth' });
      }
    });
  });

  /* =========================
     Counters (Hero + Impact)
     - .counter (plain)
     - .counter-animated[data-target]
  ========================= */
  const reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  function formatNumber(n) {
    return new Intl.NumberFormat('en-US', { maximumFractionDigits: 0 }).format(Math.round(n));
  }

  function animateCounter(el, target, duration = 1200) {
    if (reduceMotion) {
      el.textContent = formatNumber(target);
      return;
    }

    const start = 0;
    const startTime = performance.now();

    function tick(now) {
      const t = Math.min(1, (now - startTime) / duration);
      const eased = 1 - Math.pow(1 - t, 3); // easeOutCubic
      const value = start + (target - start) * eased;
      el.textContent = formatNumber(value);
      if (t < 1) requestAnimationFrame(tick);
      else el.textContent = formatNumber(target);
    }

    requestAnimationFrame(tick);
  }

  // Collect counters
  const heroCounters = Array.from(document.querySelectorAll('.counter'));
  const impactCounters = Array.from(document.querySelectorAll('.counter-animated'));

  // Setup initial values
  heroCounters.forEach(el => el.textContent = '0');
  impactCounters.forEach(el => el.textContent = '0');

  function runAllCounters() {
    heroCounters.forEach(el => {
      const target = parseInt((el.dataset.target || el.textContent || '0').replace(/[^\d]/g, ''), 10) || 0;
      // In your HTML hero counters are already 1000/200/50 in text; use that as target:
      const actualTarget = parseInt(el.getAttribute('data-target') || el.getAttribute('data-value') || el.getAttribute('value') || el.getAttribute('data') || el.textContent, 10);
      // If parsing above fails because we set to 0, read from original in DOM? Not available.
      // So read from a fallback attribute if set. If not set, use the current target variable.
      animateCounter(el, target || actualTarget || 0, 1100);
    });

    impactCounters.forEach(el => {
      const target = parseInt(el.dataset.target || '0', 10) || 0;
      animateCounter(el, target, 1200);
    });
  }

  // Better: store original values before we set to 0
  const heroTargets = heroCounters.map(el => parseInt((el.textContent || '0').replace(/[^\d]/g,''), 10) || 0);
  heroCounters.forEach(el => (el.textContent = '0'));

  function runHeroCounters() {
    heroCounters.forEach((el, idx) => animateCounter(el, heroTargets[idx], 1100));
  }
  function runImpactCounters() {
    impactCounters.forEach(el => animateCounter(el, parseInt(el.dataset.target || '0', 10) || 0, 1200));
  }

  // Run on visible
  const heroSection = document.querySelector('.hero');
  const impactSection = document.querySelector('.impact-section');

  if ('IntersectionObserver' in window) {
    const io = new IntersectionObserver((entries, obs) => {
      entries.forEach(entry => {
        if (!entry.isIntersecting) return;

        if (entry.target === heroSection) {
          runHeroCounters();
        }
        if (entry.target === impactSection) {
          runImpactCounters();
        }
        obs.unobserve(entry.target);
      });
    }, { threshold: 0.35 });

    if (heroSection) io.observe(heroSection);
    if (impactSection) io.observe(impactSection);
  } else {
    // Fallback
    runHeroCounters();
    runImpactCounters();
  }

  /* =========================
     Gallery Filters
  ========================= */
  const filterButtons = Array.from(document.querySelectorAll('.filter-btn'));
  const galleryItems = Array.from(document.querySelectorAll('.gallery-item'));

  function applyFilter(filter) {
    galleryItems.forEach(item => {
      const cat = item.getAttribute('data-category');
      const show = (filter === 'all') || (cat === filter);
      item.classList.toggle('hidden', !show);
    });
  }

  filterButtons.forEach(btn => {
    btn.addEventListener('click', () => {
      filterButtons.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      applyFilter(btn.getAttribute('data-filter'));
    });
  });

  /* =========================
     Lightbox (Zoom)
  ========================= */
  const lightbox = document.getElementById('lightbox');
  const lightboxImg = document.getElementById('lightboxImg');
  const lightboxTitle = document.getElementById('lightboxTitle');
  const lightboxDesc = document.getElementById('lightboxDesc');
  const lightboxClose = document.getElementById('lightboxClose');

  function openLightbox(imgSrc, title, desc) {
    if (!lightbox || !lightboxImg) return;
    lightboxImg.src = imgSrc || '';
    if (lightboxTitle) lightboxTitle.textContent = title || '';
    if (lightboxDesc) lightboxDesc.textContent = desc || '';
    lightbox.classList.add('open');
    document.body.style.overflow = 'hidden';
  }

  function closeLightbox() {
    if (!lightbox) return;
    lightbox.classList.remove('open');
    document.body.style.overflow = '';
  }

  // Open lightbox on zoom button click
  document.querySelectorAll('.gallery-item').forEach(item => {
    const img = item.querySelector('img');
    const titleEl = item.querySelector('.overlay-content h4');
    const descEl = item.querySelector('.overlay-content p');

    const title = titleEl ? titleEl.textContent.trim() : '';
    const desc = descEl ? descEl.textContent.trim() : '';

    // click on zoom button
    const zoomBtn = item.querySelector('.zoom-btn');
    if (zoomBtn) {
      zoomBtn.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        openLightbox(img ? img.src : '', title, desc);
      });
    }

    // click on image area/card
    const card = item.querySelector('.gallery-card');
    if (card) {
      card.addEventListener('click', () => {
        openLightbox(img ? img.src : '', title, desc);
      });
    }
  });

  if (lightboxClose) lightboxClose.addEventListener('click', closeLightbox);

  // close when clicking outside container
  if (lightbox) {
    lightbox.addEventListener('click', (e) => {
      if (e.target === lightbox) closeLightbox();
    });
  }

  // ESC close
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeLightbox();
  });
});