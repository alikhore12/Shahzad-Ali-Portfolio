const menu = document.querySelector('[data-menu]');
const links = document.querySelector('[data-links]');
menu?.addEventListener('click', () => links?.classList.toggle('open'));

const pageRoutes = { '#about': '/about', '#skills': '/skills', '#projects': '/projects', '#services': '/services', '#journey': '/experience', '#contact': '/contact' };
document.querySelectorAll('a[href^="#"]').forEach((link) => {
    const destination = pageRoutes[link.getAttribute('href')];
    if (destination) link.addEventListener('click', (event) => { event.preventDefault(); window.location.href = destination; });
});

document.querySelectorAll('[data-filter]').forEach((button) => {
    button.addEventListener('click', () => {
        document.querySelectorAll('[data-filter]').forEach((item) => item.classList.remove('active'));
        button.classList.add('active');
        const filter = button.dataset.filter;
        document.querySelectorAll('[data-project]').forEach((project) => { project.hidden = filter !== 'all' && project.dataset.project !== filter; });
    });
});

const observer = new IntersectionObserver((entries) => entries.forEach((entry) => {
    if (entry.isIntersecting) entry.target.classList.add('visible');
}), { threshold: 0.1 });
document.querySelectorAll('.reveal').forEach((element) => observer.observe(element));

let projectOpening = false;
const openProjectWithTransition = (card) => {
    if (projectOpening) return;
    projectOpening = true;

    const targetUrl = card.dataset.projectUrl;
    const bounds = card.getBoundingClientRect();
    const clone = card.cloneNode(true);

    clone.removeAttribute('tabindex');
    clone.removeAttribute('role');
    clone.style.position = 'fixed';
    clone.style.left = `${bounds.left}px`;
    clone.style.top = `${bounds.top}px`;
    clone.style.width = `${bounds.width}px`;
    clone.style.height = `${bounds.height}px`;
    clone.style.margin = '0';
    clone.style.zIndex = '9999';
    clone.style.pointerEvents = 'none';
    clone.style.transformOrigin = 'center center';
    clone.style.transition = 'left 1.45s cubic-bezier(.2,.8,.2,1), top 1.45s cubic-bezier(.2,.8,.2,1), transform 1.45s cubic-bezier(.7,0,.84,0), opacity 1.45s ease';
    document.body.appendChild(clone);
    const orb = document.createElement('div');
    orb.className = 'project-transition-orb';
    orb.setAttribute('aria-hidden', 'true');
    document.body.appendChild(orb);
    document.body.style.overflow = 'hidden';

    requestAnimationFrame(() => {
        clone.style.left = '50%';
        clone.style.top = '50%';
        clone.style.transform = 'translate(-50%, -50%) scale(.18)';
    });

    window.setTimeout(() => {
        clone.style.transform = 'translate(-50%, -50%) scale(18)';
        clone.style.opacity = '0';
    }, 1550);

    window.setTimeout(() => {
        orb.remove();
        clone.remove();
        document.body.style.overflow = '';
        projectOpening = false;
        window.location.href = targetUrl;
    }, 4000);
};

document.querySelectorAll('[data-project-url]').forEach((card) => {
    card.addEventListener('click', () => openProjectWithTransition(card));
    card.addEventListener('keydown', (event) => {
        if (event.key === 'Enter' || event.key === ' ') {
            event.preventDefault();
            openProjectWithTransition(card);
        }
    });
});

document.querySelectorAll('[data-gallery]').forEach((gallery) => {
    const slides = [...gallery.querySelectorAll('[data-gallery-slide]')];
    const dots = [...gallery.querySelectorAll('[data-gallery-dot]')];
    const previous = gallery.querySelector('[data-gallery-prev]');
    const next = gallery.querySelector('[data-gallery-next]');
    if (slides.length < 2) return;

    let current = 0;
    let timer;
    const showSlide = (index) => {
        current = (index + slides.length) % slides.length;
        slides.forEach((slide, slideIndex) => slide.classList.toggle('is-active', slideIndex === current));
        dots.forEach((dot, dotIndex) => dot.classList.toggle('is-active', dotIndex === current));
    };
    const restart = () => {
        window.clearInterval(timer);
        timer = window.setInterval(() => showSlide(current + 1), 4200);
    };

    previous?.addEventListener('click', () => { showSlide(current - 1); restart(); });
    next?.addEventListener('click', () => { showSlide(current + 1); restart(); });
    dots.forEach((dot) => dot.addEventListener('click', () => { showSlide(Number(dot.dataset.galleryDot)); restart(); }));
    gallery.addEventListener('mouseenter', () => window.clearInterval(timer));
    gallery.addEventListener('mouseleave', restart);
    restart();
});

document.querySelectorAll('.detail-footer, .footer').forEach((footer) => {
    footer.querySelectorAll('a[href="https://github.com"]').forEach((link) => {
        link.href = 'https://github.com/alikhore12';
    });
    footer.querySelectorAll('a[href="https://linkedin.com"]').forEach((link) => {
        link.href = 'https://www.linkedin.com/in/shahzad-ali-b2a0063a9';
    });
    footer.querySelectorAll('a[href*="fiverr.com"]').forEach((link) => link.remove());
    const heading = [...footer.querySelectorAll('h3')].find((item) => item.textContent.trim().toLowerCase() === 'elsewhere');
    if (!heading || heading.parentElement.querySelector('a[href*="wa.me"]')) return;

    const whatsapp = document.createElement('a');
    whatsapp.href = 'https://wa.me/923105447307?text=Hello%20Shahzad%2C%20I%20would%20like%20to%20discuss%20a%20project.';
    whatsapp.target = '_blank';
    whatsapp.rel = 'noopener noreferrer';
    whatsapp.textContent = 'WhatsApp ↗';
    heading.parentElement.appendChild(whatsapp);
});
