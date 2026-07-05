(function () {
    const storageKey = 'intevi-theme';

    function getSavedTheme() {
        return localStorage.getItem(storageKey) || 'light';
    }

    function applyTheme(theme) {
        document.documentElement.setAttribute('data-intevi-theme', theme);
        localStorage.setItem(storageKey, theme);

        const button = document.getElementById('intevi-theme-toggle');

        if (button) {
            const icon = button.querySelector('i');
            const text = button.querySelector('span');

            if (theme === 'dark') {
                icon.className = 'fas fa-sun';
                text.textContent = 'Claro';
                button.setAttribute('title', 'Cambiar a modo claro');
            } else {
                icon.className = 'fas fa-moon';
                text.textContent = 'Oscuro';
                button.setAttribute('title', 'Cambiar a modo oscuro');
            }
        }
    }

    function createThemeButton() {
        if (document.getElementById('intevi-theme-toggle')) {
            return;
        }

        const navbarRight =
            document.querySelector('.main-header .navbar-nav.ml-auto') ||
            document.querySelector('.main-header .navbar-nav.ms-auto') ||
            document.querySelector('.main-header .navbar-nav:last-child');

        if (!navbarRight) {
            return;
        }

        const li = document.createElement('li');
        li.className = 'nav-item';

        li.innerHTML = `
            <button type="button" id="intevi-theme-toggle" class="nav-link intevi-theme-toggle" title="Cambiar tema">
                <i class="fas fa-moon"></i>
                <span>Oscuro</span>
            </button>
        `;

        navbarRight.prepend(li);

        document.getElementById('intevi-theme-toggle').addEventListener('click', function () {
            const currentTheme = document.documentElement.getAttribute('data-intevi-theme') || 'light';
            const nextTheme = currentTheme === 'dark' ? 'light' : 'dark';

            applyTheme(nextTheme);
        });
    }

    document.documentElement.setAttribute('data-intevi-theme', getSavedTheme());

    document.addEventListener('DOMContentLoaded', function () {
        createThemeButton();
        applyTheme(getSavedTheme());
    });
})();