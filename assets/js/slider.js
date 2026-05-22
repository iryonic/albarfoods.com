/* Slider Engine - Hero Carousels & Testimonials */

document.addEventListener('DOMContentLoaded', () => {
    // 1. Hero Banner Slider
    const heroSlides = document.querySelectorAll('.hero-slider .slide-item');
    const heroDots = document.querySelectorAll('#hero-slider-dots .slider-dot');
    const heroPrev = document.getElementById('hero-prev-btn');
    const heroNext = document.getElementById('hero-next-btn');
    let currentHeroIndex = 0;
    let heroInterval;

    function showHeroSlide(index) {
        if (heroSlides.length === 0) return;
        heroSlides.forEach(slide => slide.classList.remove('active'));
        heroDots.forEach(dot => dot.classList.remove('active'));
        currentHeroIndex = (index + heroSlides.length) % heroSlides.length;
        heroSlides[currentHeroIndex].classList.add('active');
        if (heroDots[currentHeroIndex]) heroDots[currentHeroIndex].classList.add('active');
    }

    function startHeroAutoplay() {
        if (heroSlides.length <= 1) return;
        heroInterval = setInterval(() => showHeroSlide(currentHeroIndex + 1), 6000);
    }

    function resetHeroAutoplay() {
        clearInterval(heroInterval);
        startHeroAutoplay();
    }

    // Dots
    heroDots.forEach((dot, idx) => {
        dot.addEventListener('click', () => { showHeroSlide(idx); resetHeroAutoplay(); });
    });

    // Arrow buttons
    if (heroPrev) heroPrev.addEventListener('click', () => { showHeroSlide(currentHeroIndex - 1); resetHeroAutoplay(); });
    if (heroNext) heroNext.addEventListener('click', () => { showHeroSlide(currentHeroIndex + 1); resetHeroAutoplay(); });

    // Swipe support
    const heroEl = document.querySelector('.hero-slider');
    let heroStartX = 0;
    if (heroEl) {
        heroEl.addEventListener('touchstart', e => { heroStartX = e.touches[0].clientX; }, { passive: true });
        heroEl.addEventListener('touchend', e => {
            const diff = heroStartX - e.changedTouches[0].clientX;
            if (Math.abs(diff) > 50) { showHeroSlide(currentHeroIndex + (diff > 0 ? 1 : -1)); resetHeroAutoplay(); }
        }, { passive: true });
    }

    // Init
    showHeroSlide(0);
    startHeroAutoplay();

    // 2. Testimonials Carousel (with arrows, dots, swipe, autoplay)
    const testiTrack = document.getElementById('testimonial-track');
    const testiSlides = document.querySelectorAll('.testimonial-slide');
    const testiDots = document.querySelectorAll('.testi-dot');
    const testiPrev = document.getElementById('testi-prev-btn');
    const testiNext = document.getElementById('testi-next-btn');
    let testiIdx = 0;
    let testiTimer;

    function goToTestimonial(index) {
        if (!testiTrack || testiSlides.length === 0) return;
        testiIdx = (index + testiSlides.length) % testiSlides.length;
        testiTrack.style.transform = `translateX(-${testiIdx * 100}%)`;

        // Update dots
        testiDots.forEach((d, i) => {
            d.classList.toggle('active', i === testiIdx);
        });
    }

    function startTestiAutoplay() {
        if (!testiTrack || testiSlides.length <= 1) return;
        testiTimer = setInterval(() => goToTestimonial(testiIdx + 1), 6000);
    }

    function resetTestiAutoplay() {
        clearInterval(testiTimer);
        startTestiAutoplay();
    }

    // Arrow clicks
    if (testiPrev) testiPrev.addEventListener('click', () => { goToTestimonial(testiIdx - 1); resetTestiAutoplay(); });
    if (testiNext) testiNext.addEventListener('click', () => { goToTestimonial(testiIdx + 1); resetTestiAutoplay(); });

    // Dot clicks
    testiDots.forEach(dot => {
        dot.addEventListener('click', () => {
            goToTestimonial(parseInt(dot.dataset.slide, 10));
            resetTestiAutoplay();
        });
    });

    // Pause on hover
    const testiCarousel = document.querySelector('.testimonials-carousel');
    if (testiCarousel) {
        testiCarousel.addEventListener('mouseenter', () => clearInterval(testiTimer));
        testiCarousel.addEventListener('mouseleave', startTestiAutoplay);
    }

    // Swipe support (mobile)
    let testiStartX = 0;
    if (testiCarousel) {
        testiCarousel.addEventListener('touchstart', e => { testiStartX = e.touches[0].clientX; }, { passive: true });
        testiCarousel.addEventListener('touchend', e => {
            const diff = testiStartX - e.changedTouches[0].clientX;
            if (Math.abs(diff) > 50) {
                goToTestimonial(testiIdx + (diff > 0 ? 1 : -1));
                resetTestiAutoplay();
            }
        }, { passive: true });
    }

    // Init
    goToTestimonial(0);
    startTestiAutoplay();
});
