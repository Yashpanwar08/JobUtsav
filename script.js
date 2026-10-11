// Mobile menu toggle (WORKING)
document.addEventListener('DOMContentLoaded', () => {
  const menuBtn = document.getElementById('menuBtn');
  const mobileNav = document.getElementById('mobileNav');

  if (menuBtn && mobileNav) {
    menuBtn.addEventListener('click', () => {
      const open = mobileNav.classList.toggle('show');
      menuBtn.setAttribute('aria-expanded', String(open));
    });

    // Close menu when any link inside mobile nav is clicked
    mobileNav.querySelectorAll('a').forEach(a => {
      a.addEventListener('click', () => {
        mobileNav.classList.remove('show');
        menuBtn.setAttribute('aria-expanded', 'false');
      });
    });
  }

  // Footer year
  const year = document.getElementById('year');
  if (year) year.textContent = new Date().getFullYear();

  // Countdown until Registration Close: 31 May 2026 (live running)
  const dEl = document.getElementById('cdDays');
  const hEl = document.getElementById('cdHours');
  const mEl = document.getElementById('cdMinutes');
  const sEl = document.getElementById('cdSeconds');
  const note = document.getElementById('cdNote');

  if (!dEl || !hEl || !mEl || !sEl) return;

  // Registration closes end of day: 31 May 2026 23:59:59
  const target = new Date(2026, 4, 31, 23, 59, 59); //  CHANGED ONLY THIS LINE

  const pad2 = (n) => String(n).padStart(2, '0');

  function updateCountdown() {
    const now = new Date();
    let diff = target.getTime() - now.getTime();

    if (diff <= 0) {
      dEl.textContent = '00';
      hEl.textContent = '00';
      mEl.textContent = '00';
      sEl.textContent = '00';
      if (note) note.textContent = 'Registration Closed';
      return;
    }

    const totalSeconds = Math.floor(diff / 1000);

    const days = Math.floor(totalSeconds / (3600 * 24));
    const hours = Math.floor((totalSeconds % (3600 * 24)) / 3600);
    const minutes = Math.floor((totalSeconds % 3600) / 60);
    const seconds = totalSeconds % 60;

    dEl.textContent = pad2(days);
    hEl.textContent = pad2(hours);
    mEl.textContent = pad2(minutes);
    sEl.textContent = pad2(seconds);
  }

  updateCountdown();
  setInterval(updateCountdown, 1000);
});