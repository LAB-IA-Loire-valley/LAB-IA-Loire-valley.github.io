/* ============================================================
   LAB'IA LOIRE VALLEY — Main JS
   ============================================================ */

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

  burger.addEventListener('click', () => {
    mobile.classList.toggle('open');
    document.body.style.overflow = mobile.classList.contains('open') ? 'hidden' : '';
  });
  if (closeBtn) {
    closeBtn.addEventListener('click', () => {
      mobile.classList.remove('open');
      document.body.style.overflow = '';
    });
  }
  mobile.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', () => {
      mobile.classList.remove('open');
      document.body.style.overflow = '';
    });
  });
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

// ── Stats counter animation ──────────────────────────────────
(function() {
  const counters = document.querySelectorAll('[data-count]');
  if (!counters.length) return;

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
  if (!canvas) return;

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

// ── Dropdown nav (with hover delay) ─────────────────────────
(function() {
  document.querySelectorAll('.nav__dropdown').forEach(dropdown => {
    const menu = dropdown.querySelector('.nav__dropdown-menu');
    if (!menu) return;
    let closeTimer;

    dropdown.addEventListener('mouseenter', () => {
      clearTimeout(closeTimer);
      menu.style.display = 'block';
      // Small delay before showing for clean UX
      requestAnimationFrame(() => { menu.style.opacity = '1'; menu.style.transform = 'translateX(-50%) translateY(0)'; });
    });

    dropdown.addEventListener('mouseleave', () => {
      closeTimer = setTimeout(() => {
        menu.style.display = '';
        menu.style.opacity = '';
        menu.style.transform = '';
      }, 220);
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
      target.scrollIntoView({ behavior: 'smooth', block: 'start' });
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
