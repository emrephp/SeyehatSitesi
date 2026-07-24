# 🌍 Emre'nin Seyahat Günlüğü

Gezdiğim ülkeler, şehirler ve kendi çektiğim fotoğrafları paylaştığım kişisel seyahat günlüğüm.

## 🚀 Teknolojiler

- **HTML5** + **CSS3** + **Vanilla JavaScript** (framework yok)
- **Formspree** — iletişim formu için (AJAX)
- **Render** — statik site hostu
- **GitHub** — versiyon kontrolü ve otomatik deploy

## 🏠 Yerel Geliştirme

Bilgisayarında görmek için:

```bash
# Repoyu klonla
git clone https://github.com/emrephp/SeyehatSitesi.git
cd SeyehatSitesi

# sayehat.com/index.html dosyasını tarayıcıda aç
```

Hiçbir build adımı gerekmez; her şey statik dosyadır.

## ☁️ Render'a Deploy

Bu repo Render Blueprint (`render.yaml`) ile yapılandırılmıştır. Her `main` branch'e push'landığında otomatik deploy olur.

**İlk kurulum (tek seferlik):**

1. [render.com](https://render.com) adresine GitHub hesabınla giriş yap
2. **"New +"** → **"Blueprint"** tıkla
3. `emrephp/SeyehatSitesi` reposunu seç
4. Render `render.yaml`'ı otomatik algılar, **"Apply"** tıkla
5. ~1-2 dakika içinde `*.onrender.com` adresinde yayında

**Sonraki deploylar:** `main`'e her push otomatik deploy tetikler.

## 📁 Proje Yapısı

```
SeyehatSitesi/
├── render.yaml              # Render Blueprint tanımı
├── .gitignore               # IDE ve sistem dosyalarını dışla
├── LICENSE                  # MIT Lisansı
├── README.md                # Bu dosya
└── sayehat.com/             # Yayınlanan statik site
    ├── index.html           # Ana sayfa (iletişim formu burada)
    ├── Karadag.html         # Ülke sayfaları
    ├── almanya.html
    ├── bulgaristan.html
    ├── hirvatistan.html
    ├── italya.html
    ├── sirbistan.html
    ├── turkiye.html
    ├── 404.html             # Bulunamayan sayfa
    ├── style.css            # Tüm stiller (light + dark mode)
    ├── script.js            # Dark mode toggle + form AJAX
    ├── deneme.php           # PHP öğrenirken test dosyası (deploy edilmez)
    └── images/              # Fotoğraflar (~4 MB)
```

## 📬 İletişim

Site içindeki iletişim formunu kullan ya da `turkiye.html` sayfasındaki e-posta adresine yaz.

## 📝 Lisans

MIT Lisansı — detaylar için [LICENSE](LICENSE) dosyasına bak.
