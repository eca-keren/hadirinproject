# Hadirin - Sistem Kehadiran SMKN 1 Kota Bengkulu

Sistem berbasis web untuk memudahkan proses absensi dan pengelolaan kehadiran masyarakat yang dalam hal ini adalah Guru di SMKN 1 Kota Bengkulu.  
Dibangun dengan teknologi PHP, MySQL, dan frontend sederhana agar mudah diakses dan digunakan oleh pihak admin.

---

## 📋 Fitur Utama

- Rekap dan cetak kehadiran harian dan mingguan
- Scan QR Code untuk mengisi kehadiran
- Tampilan responsif dan mudah digunakan

---

## 📷 Tampilan Website

### 🔑 Halaman Dashboard
![Dashboard-tools](images/websitepoto/tools.jpeg)
![Dashboard-prints](images/websitepoto/prints.jpeg)
![Dashboard-info](images/websitepoto/info.jpeg)

### 🧍‍♀️ Halaman Tools
![Tools-anggota-utama](images/websitepoto/anggota.jpeg)
![Tools-anggota-edit](images/websitepoto/anggotaedit.jpeg)
![Tools-anggota-tambah](images/websitepoto/anggotaup.jpeg)
![Tools-kegiatan-utama](images/websitepoto/kegiatan.jpeg)
![Tools-kegiatan-edit](images/websitepoto/kegiatanedit.jpeg)
![Tools-kegiatan-tambah](images/websitepoto/kegiatanup.jpeg)
![Tools-generateid](images/websitepoto/generateid.jpeg)
![Tools-scan](images/websitepoto/scan.jpeg)

### 🏠 Halaman Print
![Print-Harian](images/websitepoto/printday.jpeg)
![Print-Bulanan](images/websitepoto/printbulan.jpeg)
![Print-ID](images/websitepoto/printid.jpeg)

---

## 🛠️ Teknologi yang Digunakan

- PHP (backend)
- MySQL (database)
- HTML, CSS tailwind, JavaScript (frontend)
- XAMPP sebagai localhost server

---

## 🚀 Cara Menjalankan

1. Clone repository ini ke local:
```bash
git clone https://github.com/eca-keren/hadirinproject.git
```
2. Setup database pada komputer anda, lalu masukkan kredensial-kredensialnya ke file `.env`.
```bash
```
3. Install dependency.
```bash
composer install
npm install
```
4. Generate app key.
```bash
php artisan key:generate
```
5. Migrate database.
```bash
# Tanpa seeder
php artisan migrate

# Dengan seeder (data dummy)
php artisan migrate --seed
```
6. Jalankan aplikasi.
```bash
php artisan serve
```
7. Buka terminal baru, lalu jalankan.
```bash
npm run dev
```

---

## 👩‍💻 Dibuat Oleh
Cessa Aqillah Jhonaidy
SMKN 1 Kota Bengkulu
GitHub: eca-keren