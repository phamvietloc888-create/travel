import './bootstrap';
import Alpine from 'alpinejs';
import Chart from 'chart.js/auto';

window.Alpine = Alpine;

Alpine.store('ui', {
    sidebarOpen: false,
    dark: document.documentElement.classList.contains('dark'),
    toggleSidebar() {
        this.sidebarOpen = !this.sidebarOpen;
    },
    closeSidebar() {
        this.sidebarOpen = false;
    },
    toggleTheme() {
        this.dark = !this.dark;
        document.documentElement.classList.toggle('dark', this.dark);
        localStorage.setItem('admin-theme', this.dark ? 'dark' : 'light');
    },
    init() {
        const saved = localStorage.getItem('admin-theme');
        if (saved) {
            this.dark = saved === 'dark';
        } else {
            this.dark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
        }

        document.documentElement.classList.toggle('dark', this.dark);
    },
});

Alpine.store('ui').init();
Alpine.start();
