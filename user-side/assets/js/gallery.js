document.addEventListener('DOMContentLoaded', () => {
    const items = Array.from(document.querySelectorAll('[data-gallery-index]'));
    const lightbox = document.getElementById('galleryLightbox');
    const lightboxImage = document.getElementById('lightboxImage');
    const lightboxCaption = document.getElementById('lightboxCaption');
    const backdrop = lightbox ? lightbox.querySelector('[data-dismiss="lightbox"]') : null;
    const navButtons = lightbox ? lightbox.querySelectorAll('[data-nav]') : [];
    let activeIndex = 0;

    if (!lightbox || items.length === 0) return;

    const setLightbox = (index) => {
        activeIndex = (index + items.length) % items.length;
        const target = items[activeIndex];
        const fullSrc = target.getAttribute('data-full');
        const caption = target.getAttribute('data-caption') || '';

        lightboxImage.src = fullSrc;
        lightboxImage.alt = caption;
        lightboxCaption.textContent = caption;

        // Preload next image for smoother navigation
        const preload = new Image();
        preload.src = items[(activeIndex + 1) % items.length].getAttribute('data-full');
    };

    const openLightbox = (index) => {
        setLightbox(index);
        lightbox.classList.add('is-visible');
        lightbox.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    };

    const closeLightbox = () => {
        lightbox.classList.remove('is-visible');
        lightbox.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    };

    const showNext = () => setLightbox(activeIndex + 1);
    const showPrev = () => setLightbox(activeIndex - 1);

    items.forEach((item) => {
        item.addEventListener('click', () => {
            const index = Number(item.getAttribute('data-gallery-index')) || 0;
            openLightbox(index);
        });
    });

    navButtons.forEach((btn) => {
        btn.addEventListener('click', () => {
            const direction = btn.getAttribute('data-nav');
            if (direction === 'next') {
                showNext();
            } else {
                showPrev();
            }
        });
    });

    if (backdrop) {
        backdrop.addEventListener('click', closeLightbox);
    }

    const closeTriggers = lightbox.querySelectorAll('[data-dismiss="lightbox"]');
    closeTriggers.forEach((trigger) => {
        trigger.addEventListener('click', closeLightbox);
    });

    document.addEventListener('keydown', (event) => {
        if (!lightbox.classList.contains('is-visible')) return;

        if (event.key === 'Escape') {
            closeLightbox();
        }

        if (event.key === 'ArrowRight') {
            showNext();
        }

        if (event.key === 'ArrowLeft') {
            showPrev();
        }
    });
});
