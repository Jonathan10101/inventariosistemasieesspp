(() => {
    'use strict';

    const onReady = (callback) => {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', callback, { once: true });
            return;
        }

        callback();
    };

    onReady(() => {
        const body = document.body;
        const menuButton = document.getElementById('menuButton');
        const navigation = document.getElementById('navigation');
        const faqButtons = document.querySelectorAll('.faq-question');
        const trackedCtas = document.querySelectorAll('[data-analytics="demo-cta"]');
        const frameWrap = document.querySelector('[data-demo-frame]');
        const demoFrame = frameWrap?.querySelector('iframe[data-src]');

        const closeMenu = () => {
            if (!menuButton || !navigation) {
                return;
            }

            menuButton.setAttribute('aria-expanded', 'false');
            menuButton.setAttribute('aria-label', 'Abrir menú');
            navigation.classList.remove('mobile-visible');
            body.classList.remove('menu-open');
        };

        if (menuButton && navigation) {
            menuButton.addEventListener('click', () => {
                const isOpen = menuButton.getAttribute('aria-expanded') === 'true';

                menuButton.setAttribute('aria-expanded', String(!isOpen));
                menuButton.setAttribute('aria-label', isOpen ? 'Abrir menú' : 'Cerrar menú');
                navigation.classList.toggle('mobile-visible', !isOpen);
                body.classList.toggle('menu-open', !isOpen);
            });

            navigation.querySelectorAll('a').forEach((link) => {
                link.addEventListener('click', closeMenu);
            });

            window.addEventListener('resize', () => {
                if (window.innerWidth > 960) {
                    closeMenu();
                }
            }, { passive: true });
        }

        faqButtons.forEach((button) => {
            button.addEventListener('click', () => {
                const item = button.closest('.faq-item');

                if (!item) {
                    return;
                }

                const isOpen = item.classList.contains('open');
                item.classList.toggle('open', !isOpen);
                button.setAttribute('aria-expanded', String(!isOpen));
            });
        });

        const track = (eventName, parameters = {}) => {
            if (typeof window.gtag === 'function') {
                window.gtag('event', eventName, parameters);
            }
        };

        trackedCtas.forEach((cta) => {
            cta.addEventListener('click', () => {
                track('generate_lead', {
                    event_category: 'landing',
                    event_label: cta.dataset.location || 'unknown',
                });
            });
        });

        const loadDemoFrame = () => {
            if (!demoFrame || demoFrame.dataset.loaded === 'true') {
                return;
            }

            const source = demoFrame.dataset.src;

            if (!source) {
                return;
            }

            demoFrame.dataset.loaded = 'true';
            demoFrame.src = source;

            demoFrame.addEventListener('load', () => {
                frameWrap?.classList.add('is-loaded');
                track('demo_form_loaded', { event_category: 'landing' });
            }, { once: true });
        };

        if (frameWrap && demoFrame) {
            if ('IntersectionObserver' in window) {
                const observer = new IntersectionObserver((entries) => {
                    if (entries.some((entry) => entry.isIntersecting)) {
                        loadDemoFrame();
                        observer.disconnect();
                    }
                }, { rootMargin: '500px 0px' });

                observer.observe(frameWrap);
            } else {
                loadDemoFrame();
            }

            document.querySelectorAll('a[href="#formulario-demo"]').forEach((link) => {
                link.addEventListener('click', loadDemoFrame, { passive: true });
            });
        }
    });
})();
