# 🕌 O'sh Viloyati Masjidlari va Namoz Vaqtlari Portali

> Qirg'izistonning O'sh viloyati va O'sh shahri masjidlari uchun jamoat namozi vaqtlari va interaktiv xarita tizimi.

---

## 📌 Asosiy Xususiyatlar

- **1-Bosqich: Namoz Vaqtlari & Masjidlar Katalogi**:
  - Har bir masjid uchun 5 vaqt namozning **Azon** va **Jamoat (Iqomat)** vaqtlari.
  - O'sh viloyati tumanlari bo'yicha tezkor filtr (O'sh shahri, Qorasuv, Novqat, O'zgan, Aravon, Oloy, Qoraqulja, Chon-Oloy).
  - Jonli hisoblagich (Live Countdown): keyingi namozgacha qolgan vaqtni (soat, daqiqa, soniya) real vaqtda ko'rsatish (Asia/Bishkek UTC+6).
  - Masjid admini boshqaruv paneli: har bir masjid mas'uli o'z masjidining iqomat vaqtlarini, e'lonlarini mustaqil boshqaradi.
  - Superadmin boshqaruv paneli: yangi masjidlar va ularga mas'ul adminlarni biriktirish.

- **2-Bosqich: Interaktiv Karta & GPS Geolokatsiya**:
  - **Leaflet.js + OpenStreetMap**: O'sh hududi masjidlarining to'liq interaktiv xaritasi va islomiy gumbazli pinlar.
  - **"Menga eng yaqin masjidlar" (GPS)**: Qurilma lokatsiyasi orqali masofani hisoblash (Haversine) va yaqinlik bo'yicha saralash.
  - **Navigator integratsiyasi**: Har bir masjid uchun Yandex Navigator va Google Xarita orqali yo'nalish olish.
  - **Admin Karta Tanlagich (Map Picker)**: Masjid admini o'z masjidining aniq koordinatalarini xaritadan bosish orqali belgilay oladi.

---

## 🛠️ Texnologik Stek

- **Backend**: Laravel 12 (PHP 8.5)
- **Baza**: MySQL (utf8mb4_unicode_ci)
- **Frontend**: Blade + Tailwind CSS v4 + Alpine.js
- **Xarita**: Leaflet.js + OpenStreetMap
- **Web Server**: Nginx (HTTP/2, Let's Encrypt SSL)

---

## 🚀 O'rnatish va Ishga Tushirish

```bash
# 1. Repozitoriyni klonlash
git clone git@github.com:Iqbolshoh/masjid.vexa.uz.git
cd masjid.vexa.uz

# 2. PHP va Node bog'liqliklarini o'rnatish
composer install
npm install

# 3. Muhit fayli (.env) sozlash
cp .env.example .env
php artisan key:generate

# 4. Migratsiyalar va boshlang'ich ma'lumotlarni yuklash
php artisan migrate --seed

# 5. Frontend aktivlarni yig'ish
npm run build
```

---

## 📄 Litsenziya
Ushbu loyiha ochiq kodli va jamoat manfaati uchun yaratilgan.
