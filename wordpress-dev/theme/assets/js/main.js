/* ============================================================
   LAB'IA LOIRE VALLEY — Main JS
   ============================================================ */
document.documentElement.classList.replace('no-js', 'js');

// ── Navigation scroll behavior ──────────────────────────────
(function() {
  const nav = document.querySelector('.nav');
  if (!nav) return;
  const isDarkPage = document.querySelector('.hero, .page-hero');

  if (isDarkPage) nav.classList.add('nav--dark-page');

  window.addEventListener('scroll', () => {
    if (window.scrollY > 20) {
      nav.classList.add('nav--scrolled');
    } else {
      nav.classList.remove('nav--scrolled');
    }
  }, { passive: true });
})();

// ── Mobile menu ──────────────────────────────────────────────
(function() {
  const burger = document.querySelector('.nav__burger');
  const mobile = document.querySelector('.nav__mobile');
  const closeBtn = document.querySelector('.nav__mobile-close');
  if (!burger || !mobile) return;

  mobile.hidden = true;
  document.querySelectorAll('.nav__dropdown-menu').forEach(menu => { menu.hidden = true; });
  let previousFocus = null;
  let previousOverflow = '';
  const getFocusable = () => Array.from(mobile.querySelectorAll('a[href], button:not([disabled]), [tabindex]:not([tabindex="-1"])'));
  function openMenu() {
    previousFocus = document.activeElement;
    previousOverflow = document.body.style.overflow;
    mobile.hidden = false;
    mobile.classList.add('open');
    mobile.setAttribute('role', 'dialog');
    mobile.setAttribute('aria-modal', 'true');
    burger.setAttribute('aria-expanded', 'true');
    burger.setAttribute('aria-label', 'Fermer le menu');
    document.body.style.overflow = 'hidden';
    (closeBtn || getFocusable()[0] || mobile).focus();
  }
  function closeMenu(restoreFocus = true) {
    mobile.classList.remove('open');
    mobile.hidden = true;
    mobile.setAttribute('role', 'navigation');
    mobile.removeAttribute('aria-modal');
    burger.setAttribute('aria-expanded', 'false');
    burger.setAttribute('aria-label', 'Ouvrir le menu');
    document.body.style.overflow = previousOverflow;
    if (restoreFocus) (previousFocus || burger).focus();
  }

  burger.addEventListener('click', () => {
    if (mobile.hidden) openMenu();
    else closeMenu();
  });
  if (closeBtn) closeBtn.addEventListener('click', () => closeMenu());
  mobile.querySelectorAll('a').forEach(link => link.addEventListener('click', () => closeMenu(false)));
  document.addEventListener('keydown', event => {
    if (mobile.hidden) return;
    if (event.key === 'Escape') {
      event.preventDefault();
      closeMenu();
      return;
    }
    if (event.key === 'Tab') {
      const focusable = getFocusable();
      if (!focusable.length) { event.preventDefault(); mobile.focus(); return; }
      const first = focusable[0];
      const last = focusable[focusable.length - 1];
      if (event.shiftKey && document.activeElement === first) { event.preventDefault(); last.focus(); }
      else if (!event.shiftKey && document.activeElement === last) { event.preventDefault(); first.focus(); }
    }
  });
  mobile.addEventListener('click', event => { if (event.target === mobile) closeMenu(); });
})();

// // ── Active nav link ─────────────────────────────────────────
// (function() {
//   const path = window.location.pathname.split('/').pop() || 'index.html';
//   document.querySelectorAll('.nav__link, .nav__mobile a').forEach(link => {
//     const href = link.getAttribute('href') || '';
//     if (href && path.includes(href.split('/').pop())) {
//       link.classList.add('active');
//     }
//     if ((path === '' || path === 'index.html') && href === 'index.html') {
//       link.classList.add('active');
//     }
//   });
// })();

// ── Scroll reveal ────────────────────────────────────────────
(function() {
  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if (reduceMotion) { document.querySelectorAll('.reveal').forEach(el => el.classList.add('visible')); return; }
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

  document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
})();

// ── Steps vertical progress (6 étapes, rail + points) ──────────────
(function() {
  document.documentElement.classList.add('js');
  const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  const list = document.querySelector('.steps-v');
  if (!list) return;
  const steps = Array.prototype.slice.call(list.querySelectorAll('.steps-v-step'));
  if (!steps.length) return;
  const dots = steps.map(s => s.querySelector('.steps-v-dot'));

  // Couleurs par phase : reprises des badges (Cadrage, Réalisation, Lancement)
  const FALLBACK = [[226, 0, 125], [26, 122, 204], [17, 17, 17]];
  function parseColor(c, fb) {
    const m = /rgba?\((\d+),\s*(\d+),\s*(\d+)/.exec(c || '');
    return m ? [+m[1], +m[2], +m[3]] : fb;
  }
  const phases = Array.prototype.slice.call(list.querySelectorAll('.steps-v-phase'));
  const phaseColors = phases.map((ph, i) => {
    const b = ph.querySelector('.badge');
    return parseColor(b ? getComputedStyle(b).color : '', FALLBACK[i] || FALLBACK[FALLBACK.length - 1]);
  });
  if (phaseColors.length < 2) phaseColors.push(FALLBACK[0]); // garde-fou

  // Dégradé du rail : zones à plat par phase + courtes transitions aux frontières
  const TRANS = 0.04; // demi-largeur d'une transition (fraction de la hauteur du rail)
  let STOPS = [];
  function computeStops() {
    const lr = list.getBoundingClientRect();
    const railTop = lr.top + 16;
    const railH = lr.height - 32;
    if (railH <= 0) return;
    STOPS = [[0, phaseColors[0]]];
    phases.slice(1).forEach((ph, i) => {
      const r = ph.getBoundingClientRect();
      const t = (r.top + r.height / 2 - railTop) / railH;
      STOPS.push([Math.max(0, t - TRANS), phaseColors[i]]);
      STOPS.push([Math.min(1, t + TRANS), phaseColors[i + 1]]);
    });
    STOPS.push([1, phaseColors[phaseColors.length - 1]]);
  }
  function gradColor(t) {
    t = Math.max(0, Math.min(1, t));
    for (let i = 1; i < STOPS.length; i++) {
      if (t <= STOPS[i][0]) {
        const a = STOPS[i - 1], b = STOPS[i];
        const k = (t - a[0]) / ((b[0] - a[0]) || 1);
        return a[1].map((v, j) => Math.round(v + (b[1][j] - v) * k));
      }
    }
    return STOPS[STOPS.length - 1][1];
  }
  function paint() {
    computeStops();
    if (STOPS.length < 2) return;
    list.style.setProperty('--rail-grad',
      'linear-gradient(180deg, ' + STOPS.map(([t, c]) => 'rgb(' + c.join(', ') + ') ' + (t * 100).toFixed(2) + '%').join(', ') + ')');
    const lr = list.getBoundingClientRect();
    const railTop = lr.top + 16;
    const railH = lr.height - 32;
    if (railH <= 0) return;
    dots.forEach((dot, i) => {
      if (!dot) return;
      const dr = dot.getBoundingClientRect();
      const c = gradColor((dr.top + dr.height / 2 - railTop) / railH);
      steps[i].style.setProperty('--dot-color', 'rgb(' + c.join(', ') + ')');
      steps[i].style.setProperty('--dot-glow', 'rgba(' + c.join(', ') + ', .30)');
    });
  }

  // Remplissage du rail + point courant : le bout suit la ligne de lecture (62 % de l'écran)
  function update() {
    const r = list.getBoundingClientRect();
    const railTop = r.top + 16;
    const railH = r.height - 32;
    if (railH <= 0) return;
    const readingY = window.innerHeight * 0.62;
    const pct = Math.max(0, Math.min(1, (readingY - railTop) / railH));
    list.style.setProperty('--fill', (pct * 100).toFixed(2) + '%');

    // Point courant = dernière boule atteinte par le bout de la ligne
    let current = null;
    dots.forEach((dot, i) => {
      if (!dot) return;
      const dr = dot.getBoundingClientRect();
      if (dr.top + dr.height / 2 <= readingY) current = steps[i];
    });
    list.querySelectorAll('.steps-v-step.now').forEach(s => { if (s !== current) s.classList.remove('now'); });
    if (current) current.classList.add('now');
  }
  function finish() {
    steps.forEach(s => s.classList.add('on'));
    steps[steps.length - 1].classList.add('now');
    list.style.setProperty('--fill', '100%');
  }

  paint();
  update();
  if (document.fonts && document.fonts.ready) {
    document.fonts.ready.then(() => { paint(); update(); });
  }
  if (reduce) { finish(); return; }

  let ticking = false;
  window.addEventListener('scroll', () => {
    if (ticking) return;
    ticking = true;
    requestAnimationFrame(() => { update(); ticking = false; });
  }, { passive: true });
  window.addEventListener('resize', () => { paint(); update(); });

  const ioSteps = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('on');
        ioSteps.unobserve(entry.target);
      }
    });
  }, { threshold: 0.4, rootMargin: '0px 0px -8% 0px' });
  steps.forEach(s => ioSteps.observe(s));
})();

// ── Stats counter animation ──────────────────────────────────
(function() {
  const counters = document.querySelectorAll('[data-count]');
  if (!counters.length) return;

  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if (reduceMotion) {
    counters.forEach(el => {
      const target = parseFloat(el.dataset.count);
      el.textContent = (el.dataset.prefix || '') + (Number.isInteger(target) ? target : target.toFixed(1)) + (el.dataset.suffix || '');
    });
    return;
  }

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (!entry.isIntersecting) return;
      const el = entry.target;
      const target = parseFloat(el.dataset.count);
      const suffix = el.dataset.suffix || '';
      const prefix = el.dataset.prefix || '';
      const duration = 1800;
      const start = performance.now();

      const animate = (now) => {
        const elapsed = now - start;
        const progress = Math.min(elapsed / duration, 1);
        const ease = 1 - Math.pow(1 - progress, 3);
        const current = target * ease;
        el.textContent = prefix + (Number.isInteger(target) ? Math.round(current) : current.toFixed(1)) + suffix;
        if (progress < 1) requestAnimationFrame(animate);
      };
      requestAnimationFrame(animate);
      observer.unobserve(el);
    });
  }, { threshold: 0.5 });

  counters.forEach(el => observer.observe(el));
})();

// ── Accordion ────────────────────────────────────────────────
(function() {
  document.querySelectorAll('.accordion-trigger').forEach(trigger => {
    trigger.addEventListener('click', () => {
      const item = trigger.closest('.accordion-item');
      const isOpen = item.classList.contains('open');
      // Close all
      document.querySelectorAll('.accordion-item.open').forEach(i => i.classList.remove('open'));
      // Open clicked if it was closed
      if (!isOpen) item.classList.add('open');
    });
  });
})();

// ── Hero Canvas network animation ───────────────────────────
(function() {
  const canvas = document.getElementById('hero-canvas');
  if (!canvas || window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

  const ctx = canvas.getContext('2d');
  let w, h, particles, animId;
  const PARTICLE_COUNT = 60;
  const CONNECTION_DIST = 180;
  const COLORS = [
    '79, 176, 255',   // blue
    '71, 82, 151',    // indigo
    '133, 47, 133',   // violet
    '226, 0, 125',    // magenta
  ];

  function resize() {
    const hero = canvas.parentElement;
    w = canvas.width = hero ? hero.offsetWidth : window.innerWidth;
    h = canvas.height = hero ? hero.offsetHeight : window.innerHeight;
  }

  class Particle {
    constructor() { this.reset(true); }
    reset(init) {
      this.x = Math.random() * w;
      this.y = init ? Math.random() * h : Math.random() * h;
      this.vx = (Math.random() - .5) * .4;
      this.vy = (Math.random() - .5) * .4;
      this.r = Math.random() * 2 + 1;
      this.color = COLORS[Math.floor(Math.random() * COLORS.length)];
      this.alpha = Math.random() * .4 + .2;
    }
    update() {
      this.x += this.vx;
      this.y += this.vy;
      if (this.x < -20) this.x = w + 20;
      if (this.x > w + 20) this.x = -20;
      if (this.y < -20) this.y = h + 20;
      if (this.y > h + 20) this.y = -20;
    }
    draw() {
      ctx.beginPath();
      ctx.arc(this.x, this.y, this.r, 0, Math.PI * 2);
      ctx.fillStyle = `rgba(${this.color}, ${this.alpha})`;
      ctx.fill();
    }
  }

  function init() {
    resize();
    particles = Array.from({ length: PARTICLE_COUNT }, () => new Particle());
  }

  function drawConnections() {
    for (let i = 0; i < particles.length; i++) {
      for (let j = i + 1; j < particles.length; j++) {
        const dx = particles[i].x - particles[j].x;
        const dy = particles[i].y - particles[j].y;
        const dist = Math.sqrt(dx * dx + dy * dy);
        if (dist < CONNECTION_DIST) {
          const alpha = (1 - dist / CONNECTION_DIST) * 0.15;
          ctx.beginPath();
          ctx.moveTo(particles[i].x, particles[i].y);
          ctx.lineTo(particles[j].x, particles[j].y);
          ctx.strokeStyle = `rgba(${particles[i].color}, ${alpha})`;
          ctx.lineWidth = 1;
          ctx.stroke();
        }
      }
    }
  }

  function loop() {
    ctx.clearRect(0, 0, w, h);
    drawConnections();
    particles.forEach(p => { p.update(); p.draw(); });
    animId = requestAnimationFrame(loop);
  }

  window.addEventListener('resize', () => { resize(); }, { passive: true });
  init();
  loop();
})();

// ── Accessible desktop dropdown navigation ───────────────────
(function() {
  document.querySelectorAll('.nav__dropdown').forEach(dropdown => {
    const trigger = dropdown.querySelector('.nav__dropdown-toggle');
    const menu = dropdown.querySelector('.nav__dropdown-menu');
    if (!trigger || !menu) return;

    function setOpen(open, returnFocus = false) {
      trigger.setAttribute('aria-expanded', String(open));
      menu.hidden = !open;
      if (returnFocus) trigger.focus();
    }
    trigger.addEventListener('click', () => setOpen(menu.hidden));
    dropdown.addEventListener('focusout', event => {
      if (!dropdown.contains(event.relatedTarget)) setOpen(false);
    });
    dropdown.addEventListener('keydown', event => {
      if (event.key === 'Escape' && !menu.hidden) {
        event.preventDefault();
        setOpen(false, true);
      }
    });
  });
})();

// ── Offre page sticky nav scrollspy ─────────────────────────
(function() {
  const navLinks = document.querySelectorAll('.offre-nav__link');
  if (!navLinks.length) return;

  const sections = Array.from(navLinks)
    .map(a => document.querySelector(a.getAttribute('href')))
    .filter(Boolean);

  function updateActive() {
    // offset = main nav (~72px) + sticky subnav (~52px) + small buffer
    const offset = 130;
    let active = sections[0];
    for (const section of sections) {
      if (section.getBoundingClientRect().top <= offset) {
        active = section;
      }
    }
    navLinks.forEach(link => {
      link.classList.toggle('active', link.getAttribute('href') === '#' + active.id);
    });
  }

  window.addEventListener('scroll', updateActive, { passive: true });
  updateActive();
})();

// ── Smooth anchor scrolling ──────────────────────────────────
document.querySelectorAll('a[href^="#"]').forEach(a => {
  a.addEventListener('click', e => {
    const target = document.querySelector(a.getAttribute('href'));
    if (target) {
      e.preventDefault();
      target.scrollIntoView({ behavior: window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 'auto' : 'smooth', block: 'start' });
    }
  });
});

// ── Presse filter ────────────────────────────────────────────
(function() {
  const filterBtns = document.querySelectorAll('.media-type-btn');
  const timeline = document.getElementById('press-timeline');
  if (!filterBtns.length || !timeline) return;

  filterBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      const type = btn.dataset.type;

      filterBtns.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');

      timeline.querySelectorAll('.press-item').forEach(item => {
        if (type === 'all' || item.dataset.type === type) {
          item.style.display = '';
        } else {
          item.style.display = 'none';
        }
      });

      // Hide year groups that have no visible items
      timeline.querySelectorAll('.press-year-group').forEach(group => {
        const visible = Array.from(group.querySelectorAll('.press-item'))
          .some(item => item.style.display !== 'none');
        group.style.display = visible ? '' : 'none';
      });
    });
  });
})();
