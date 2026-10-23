/**
 * JobUtsav - College Page Animation Layer
 * File: college-animations.js
 * Spec-compliant, high-performance vanilla JS animation layer
 */

(function () {
  'use strict';

  /* ==========================================================================
     TIMING CONFIGURATION
     Tweak these values anytime to adjust pacing
     ========================================================================== */
  var CONFIG = {
    introProgressDuration: 1200,   // ms: progress bar fill duration
    introHoldDuration: 1500,       // ms: time before overlay slides up
    introSlideDuration: 950,       // ms: slide-up transition duration
    rotatingPhraseInterval: 3600,  // ms: interval between rotating phrases in hero h1
    headingWordStagger: 60,        // ms: delay per word for h1/h2/h3 reveals
    leadWordStagger: 28,           // ms: delay per word for .lead paragraph
    counterDuration: 1600,         // ms: ease-out quart number count-up duration
    navScrollThreshold: 30,        // px: scroll distance to trigger navbar shrink
    spotlightRadius: 350           // px: radial spotlight size
  };

  // Expose configuration globally if user wishes to inspect or tweak dynamically
  window.JOBUTSAV_ANIMATION_CONFIG = CONFIG;

  var prefersReducedMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var isFineHover = window.matchMedia && window.matchMedia('(hover: hover) and (pointer: fine)').matches;

  /* ==========================================================================
     A) PAGE-LOAD INTRO OVERLAY (DISABLED)
     ========================================================================== */
  function initIntroOverlay(onComplete) {
    document.documentElement.classList.add('intro-done');
    if (typeof onComplete === 'function') {
      onComplete();
    }
  }

  /* ==========================================================================
     B) WORD-BY-WORD TEXT SPLITTING & REVEAL
     ========================================================================== */
  var rotatingPhrases = ['Placement Cell', 'Campus Hiring', 'Student Careers'];
  var currentPhraseIndex = 0;
  var phraseRotationTimer = null;

  function splitElementIntoWords(element, isLead) {
    if (!element || element.getAttribute('data-word-split') === 'true') return;
    element.setAttribute('data-word-split', 'true');

    var wordIndex = 0;

    function processNode(node) {
      if (node.nodeType === Node.TEXT_NODE) {
        var text = node.textContent;
        // Don't modify whitespace-only text
        if (!text.trim()) return node;

        var fragment = document.createDocumentFragment();
        // Split while capturing words and spaces
        var tokens = text.split(/(\s+)/);

        for (var i = 0; i < tokens.length; i++) {
          var token = tokens[i];
          if (/^\s+$/.test(token)) {
            fragment.appendChild(document.createTextNode(token));
          } else if (token.length > 0) {
            var mask = document.createElement('span');
            mask.className = 'word-mask';

            var inner = document.createElement('span');
            inner.className = 'word-inner';
            inner.style.setProperty('--w-idx', wordIndex);
            inner.textContent = token;

            mask.appendChild(inner);
            fragment.appendChild(mask);
            wordIndex++;
          }
        }
        return fragment;
      } else if (node.nodeType === Node.ELEMENT_NODE) {
        // Skip svg, img, or dot icons inside .eyebrow
        var tagName = node.tagName.toLowerCase();
        if (tagName === 'svg' || tagName === 'img' || tagName === 'i') {
          return node;
        }

        // Check if this is the highlighted span in Hero H1
        if (element.closest('.hero') && element.tagName.toLowerCase() === 'h1' && tagName === 'span') {
          return setupHeroRotatingSpan(node);
        }

        // Recurse children to preserve <b>, <span>, <i>, etc.
        var child = node.firstChild;
        while (child) {
          var next = child.nextSibling;
          var replacement = processNode(child);
          if (replacement && replacement !== child) {
            node.replaceChild(replacement, child);
          }
          child = next;
        }
        return node;
      }
      return node;
    }

    var childNode = element.firstChild;
    while (childNode) {
      var nextSibling = childNode.nextSibling;
      var replacementNode = processNode(childNode);
      if (replacementNode && replacementNode !== childNode) {
        element.replaceChild(replacementNode, childNode);
      }
      childNode = nextSibling;
    }
  }

  function setupHeroRotatingSpan(spanElement) {
    var wrap = document.createElement('span');
    wrap.className = 'rotating-phrase-wrap';
    wrap.setAttribute('aria-label', rotatingPhrases[0]);

    var currentSpan = document.createElement('span');
    currentSpan.className = 'rotating-phrase current';
    currentSpan.textContent = rotatingPhrases[0];

    wrap.appendChild(currentSpan);
    return wrap;
  }

  function rotateHeroPhrase() {
    var wrap = document.querySelector('.rotating-phrase-wrap');
    if (!wrap) return;

    currentPhraseIndex = (currentPhraseIndex + 1) % rotatingPhrases.length;
    var nextText = rotatingPhrases[currentPhraseIndex];

    var currentSpan = wrap.querySelector('.rotating-phrase.current');
    var nextSpan = document.createElement('span');
    nextSpan.className = 'rotating-phrase enter-from-down';
    nextSpan.textContent = nextText;

    wrap.appendChild(nextSpan);
    wrap.setAttribute('aria-label', nextText);

    // Force layout reflow
    void nextSpan.offsetWidth;

    if (currentSpan) {
      currentSpan.classList.remove('current');
      currentSpan.classList.add('exit-up');
      setTimeout(function () {
        if (currentSpan.parentNode) {
          currentSpan.parentNode.removeChild(currentSpan);
        }
      }, 600);
    }

    nextSpan.classList.remove('enter-from-down');
    nextSpan.classList.add('current');
  }

  function initWordSplitting() {
    // Target h1, h2, h3, .lead, and .eyebrow outside of footer
    var headings = document.querySelectorAll('main h1, main h2, main h3');
    headings.forEach(function (h) {
      splitElementIntoWords(h, false);
    });

    var leads = document.querySelectorAll('main .lead');
    leads.forEach(function (p) {
      splitElementIntoWords(p, true);
    });

    if (prefersReducedMotion) {
      document.querySelectorAll('.word-inner, .eyebrow, .lead').forEach(function (el) {
        el.classList.add('text-revealed');
      });
      return;
    }

    // IntersectionObserver for non-hero headings & leads
    if ('IntersectionObserver' in window) {
      var textIo = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            entry.target.classList.add('text-revealed');
            textIo.unobserve(entry.target);
          }
        });
      }, { threshold: 0.3 });

      document.querySelectorAll('main section:not(.hero) h2, main section:not(.hero) h3, main section:not(.hero) .lead, main section:not(.hero) .eyebrow').forEach(function (el) {
        textIo.observe(el);
      });
    } else {
      document.querySelectorAll('main h1, main h2, main h3, main .lead, main .eyebrow').forEach(function (el) {
        el.classList.add('text-revealed');
      });
    }
  }

  /* ==========================================================================
     C) NUMBERS COUNT-UP (1.6s ease-out quart)
     ========================================================================== */
  function parseCounterInfo(text) {
    if (!text) return null;
    var trimmed = text.trim();
    // Check if string contains any digit
    if (!/\d/.test(trimmed)) return null;

    // Matches prefix, numeric value (with commas/decimals), and suffix
    var match = trimmed.match(/^([^\d]*)([\d,]+(?:\.\d+)?)(.*)$/);
    if (!match) return null;

    var prefix = match[1] || '';
    var rawNum = match[2].replace(/,/g, '');
    var suffix = match[3] || '';
    var target = parseFloat(rawNum);

    if (isNaN(target)) return null;

    var hasDecimals = rawNum.indexOf('.') !== -1;
    var decimalPlaces = hasDecimals ? (rawNum.split('.')[1] || '').length : 0;
    var useComma = match[2].indexOf(',') !== -1 || target >= 1000;

    return {
      prefix: prefix,
      target: target,
      decimalPlaces: decimalPlaces,
      suffix: suffix,
      useComma: useComma
    };
  }

  function formatIndianNumber(num, decimalPlaces) {
    if (decimalPlaces > 0) {
      var parts = num.toFixed(decimalPlaces).split('.');
      var intPart = parseInt(parts[0], 10).toLocaleString('en-IN');
      return intPart + '.' + parts[1];
    }
    return Math.round(num).toLocaleString('en-IN');
  }

  function animateCounter(element) {
    if (!element || element.getAttribute('data-counter-active') === 'true') return;
    element.setAttribute('data-counter-active', 'true');

    var originalText = element.textContent;
    var info = parseCounterInfo(originalText);
    if (!info) return;

    var startTime = null;
    var duration = CONFIG.counterDuration;

    function step(timestamp) {
      if (!startTime) startTime = timestamp;
      var elapsed = timestamp - startTime;
      var t = Math.min(1, elapsed / duration);

      // Ease-out Quart formula: 1 - (1 - t)^4
      var ease = 1 - Math.pow(1 - t, 4);
      var current = info.target * ease;

      var formattedNum = info.useComma
        ? formatIndianNumber(current, info.decimalPlaces)
        : (info.decimalPlaces > 0 ? current.toFixed(info.decimalPlaces) : Math.round(current));

      element.textContent = info.prefix + formattedNum + info.suffix;

      if (t < 1) {
        requestAnimationFrame(step);
      } else {
        // Ensure exact final string matches original
        element.textContent = originalText;
      }
    }

    requestAnimationFrame(step);
  }

  function initCounters() {
    var statElements = document.querySelectorAll('.stat b, .four b');

    if (prefersReducedMotion) return;

    if ('IntersectionObserver' in window) {
      var counterIo = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            animateCounter(entry.target);
            counterIo.unobserve(entry.target);
          }
        });
      }, { threshold: 0.25 });

      statElements.forEach(function (el) {
        counterIo.observe(el);
      });
    } else {
      statElements.forEach(function (el) {
        animateCounter(el);
      });
    }
  }

  function playHeroSequence() {
    var hero = document.querySelector('.hero');
    if (hero) {
      hero.classList.add('hero-revealed');
    }

    // Reveal hero eyebrow, h1 words, lead words
    var heroEyebrow = document.querySelector('.hero .eyebrow');
    if (heroEyebrow) heroEyebrow.classList.add('text-revealed');

    var heroH1 = document.querySelector('.hero h1');
    if (heroH1) heroH1.classList.add('text-revealed');

    var heroLead = document.querySelector('.hero .lead');
    if (heroLead) heroLead.classList.add('text-revealed');

    // Trigger hero counters
    var heroCoin = document.querySelector('.hero .coin b');
    if (heroCoin) animateCounter(heroCoin);

    var heroCtc = document.querySelector('.hero .ctc b');
    if (heroCtc) animateCounter(heroCtc);

    // Start rotating phrase timer
    if (!phraseRotationTimer && !prefersReducedMotion) {
      phraseRotationTimer = setInterval(rotateHeroPhrase, CONFIG.rotatingPhraseInterval);
    }
  }

  /* ==========================================================================
     E) HERO EXTRAS (Blobs, 3D Arch Tilt, Scroll Parallax)
     ========================================================================== */
  function initHeroExtras() {
    var hero = document.querySelector('.hero');
    if (!hero) return;

    // Inject blurred floating blobs if not already present
    if (!hero.querySelector('.hero-blobs')) {
      var blobsContainer = document.createElement('div');
      blobsContainer.className = 'hero-blobs';
      blobsContainer.setAttribute('aria-hidden', 'true');
      blobsContainer.innerHTML =
        '<div class="hero-blob hero-blob-1"></div>' +
        '<div class="hero-blob hero-blob-2"></div>' +
        '<div class="hero-blob hero-blob-3"></div>';
      hero.insertBefore(blobsContainer, hero.firstChild);
    }

    // Mouse-move 3D tilt on .archimg (hover devices only)
    if (isFineHover && !prefersReducedMotion) {
      var arch = document.querySelector('.arch');
      var archImg = document.querySelector('.archimg');

      if (arch && archImg) {
        arch.style.perspective = '1000px';
        var tiltRaf = null;

        arch.addEventListener('mousemove', function (e) {
          var rect = arch.getBoundingClientRect();
          var x = (e.clientX - rect.left) / rect.width - 0.5; // -0.5 to 0.5
          var y = (e.clientY - rect.top) / rect.height - 0.5;

          if (tiltRaf) cancelAnimationFrame(tiltRaf);
          tiltRaf = requestAnimationFrame(function () {
            var tiltX = -y * 10; // max ~10deg
            var tiltY = x * 10;
            archImg.style.transform = 'rotateX(' + tiltX.toFixed(2) + 'deg) rotateY(' + tiltY.toFixed(2) + 'deg)';
          });
        });

        arch.addEventListener('mouseleave', function () {
          if (tiltRaf) cancelAnimationFrame(tiltRaf);
          archImg.style.transition = 'transform 0.5s ease-out';
          archImg.style.transform = 'rotateX(0deg) rotateY(0deg)';
          setTimeout(function () {
            archImg.style.transition = '';
          }, 500);
        });
      }
    }
  }

  /* ==========================================================================
     F) GLOBAL POLISH (Scroll Progress, Nav Shrink, Cursor Spotlights)
     ========================================================================== */
  function initGlobalPolish() {
    // Top scroll progress bar
    var progressBar = document.createElement('div');
    progressBar.id = 'scroll-progress-bar';
    progressBar.setAttribute('aria-hidden', 'true');
    document.body.appendChild(progressBar);

    var navbar = document.querySelector('.nav');
    var b1 = document.querySelector('.hero-blob-1');
    var b2 = document.querySelector('.hero-blob-2');
    var b3 = document.querySelector('.hero-blob-3');

    function onScroll() {
      var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
      var docHeight = document.documentElement.scrollHeight - window.innerHeight;

      // Update scroll progress bar
      if (docHeight > 0 && progressBar) {
        var progress = Math.min(1, Math.max(0, scrollTop / docHeight));
        progressBar.style.transform = 'scaleX(' + progress + ')';
      }

      // Navbar shrink & shadow
      if (navbar) {
        if (scrollTop > CONFIG.navScrollThreshold) {
          navbar.classList.add('nav-scrolled');
        } else {
          navbar.classList.remove('nav-scrolled');
        }
      }

      // Light blob parallax in hero
      if (scrollTop < 800 && !prefersReducedMotion) {
        if (b1) b1.style.transform = 'translateY(' + (scrollTop * 0.12).toFixed(1) + 'px)';
        if (b2) b2.style.transform = 'translateY(' + (scrollTop * -0.08).toFixed(1) + 'px)';
        if (b3) b3.style.transform = 'translateY(' + (scrollTop * 0.15).toFixed(1) + 'px)';
      }
    }

    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();

    // Cursor spotlight on .perk, .career-feature-card, .stat, and .duo cards (hover devices only)
    if (isFineHover) {
      var spotlightCards = document.querySelectorAll('.perk, .career-feature-card, .stat, .duo > div');
      spotlightCards.forEach(function (card) {
        card.addEventListener('mousemove', function (e) {
          var rect = card.getBoundingClientRect();
          card.style.setProperty('--spot-x', (e.clientX - rect.left) + 'px');
          card.style.setProperty('--spot-y', (e.clientY - rect.top) + 'px');
        });
      });
    }
  }

  /* ==========================================================================
     INIT ORCHESTRATION
     ========================================================================== */
  function init() {
    // Prepare DOM elements (word splits, counters, hero extras)
    initWordSplitting();
    initHeroExtras();
    initCounters();
    initGlobalPolish();

    // Trigger orchestrated intro sequence
    initIntroOverlay(function () {
      playHeroSequence();
    });
  }

  // Initialize when DOM is ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

})();
