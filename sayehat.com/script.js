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

    // İletişim formunu AJAX ile Formspree'ye gönder (sayfa yenilenmesin)
    const contactForm = document.getElementById('contact-form');
    const formStatus = document.getElementById('form-status');
    if (contactForm && formStatus) {
        contactForm.addEventListener('submit', async function (e) {
            e.preventDefault(); // sayfanın yenilenmesini engelle
            const submitBtn = contactForm.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.textContent = 'Gönderiliyor...';
            formStatus.hidden = false;
            formStatus.className = 'form-status';
            formStatus.textContent = 'Mesajınız gönderiliyor...';

            try {
                const response = await fetch(contactForm.action, {
                    method: 'POST',
                    body: new FormData(contactForm),
                    headers: { 'Accept': 'application/json' }
                });

                if (response.ok) {
                    formStatus.classList.add('success');
                    formStatus.textContent = '✅ Mesajınız başarıyla gönderildi! En kısa sürede e-posta adresinize yanıt verilecektir.';
                    contactForm.reset();
                } else {
                    const data = await response.json().catch(() => ({}));
                    const msg = (data && data.errors && data.errors.map(err => err.message).join(', '))
                        || 'Mesaj gönderilemedi. Lütfen daha sonra tekrar deneyin.';
                    formStatus.classList.add('error');
                    formStatus.textContent = '❌ ' + msg;
                }
            } catch (err) {
                formStatus.classList.add('error');
                formStatus.textContent = '❌ Bağlantı hatası. İnternet bağlantınızı kontrol edip tekrar deneyin.';
            } finally {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Gönder';
            }
        });
    }
});