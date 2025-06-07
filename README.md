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
![Dashboard-tools](images/tools.jpeg)
![Dashboard-prints](images/prints.jpeg)
![Dashboard-info](images/info.jpeg)

### 🧍‍♀️ Halaman Tools
![Tools-anggota-utama](images/anggota.jpeg)
![Tools-anggota-edit](images/anggotaedit.jpeg)
![Tools-anggota-tambah](images/anggotaup.jpeg)
![Tools-kegiatan-utama](images/kegiatan.jpeg)
![Tools-kegiatan-edit](images/kegiatanedit.jpeg)
![Tools-kegiatan-tambah](images/kegiatanup.jpeg)
![Tools-generateid](images/generateid.jpeg)
![Tools-scan](images/scan.jpeg)

### 🏠 Halaman Print
![Print-Harian](images/printday.jpeg)
![Print-Bulanan](images/printbulan.jpeg)
![Print-ID](images/printid.jpeg)

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