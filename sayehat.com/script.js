function updateButtonText() {
    const themeToggleBtn = document.getElementById('theme-toggle');
    if (themeToggleBtn) {
        if (document.documentElement.classList.contains('dark-mode')) {
            themeToggleBtn.textContent = '☀️ Gündüz Modu';
        } else {
            themeToggleBtn.textContent = '🌙 Gece Modu';
        }
    }
}

document.addEventListener('DOMContentLoaded', () => {
    updateButtonText();
    
    const themeToggleBtn = document.getElementById('theme-toggle');
    if (themeToggleBtn) {
        themeToggleBtn.onclick = function() {
            document.documentElement.classList.toggle('dark-mode');
            
            if (document.documentElement.classList.contains('dark-mode')) {
                localStorage.setItem('theme', 'dark');
            } else {
                localStorage.setItem('theme', 'light');
            }
            updateButtonText();
        };
    }
});