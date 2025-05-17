# README.md - Backend Laravel Aplikasi Manajemen Tugas dan Remunerasi

## 1. Arsitektur Solusi Backend

### Alur Data Backend


- Backend menggunakan Laravel sebagai framework PHP untuk RESTful API.
- Data task, employee, dan remunerasi disimpan di database relasional.
- Memakai arsitektur Clean Architecture (Controller → Service → Repository) untuk pemisahan tanggung jawab dan mudah pengujian.
- Perhitungan remunerasi dilakukan di Service Layer untuk memastikan logika bisnis terpusat dan reusable.
- Validasi request menggunakan Laravel Form Request.
- Endpoint API menggunakan resource controller (`apiResource`) untuk CRUD operasi.

---

## 2. Penjelasan Desain Backend

- **Clean Architecture** memudahkan maintenance dan scalability dengan pemisahan antara controller, service, dan repository.
- **Service Layer** mengelola logika bisnis, seperti perhitungan remunerasi dan update data terkait.
- **Repository Pattern** untuk abstraksi akses database dan memudahkan penggantian storage atau testing.
- **Error handling** menggunakan exception handler Laravel untuk memberikan response yang konsisten.
- Integrasi dengan frontend melalui API JSON yang terstruktur dan mudah dipanggil.

---

## 3. Setup & Deploy

### Prasyarat

- PHP >= 8.x
- Composer
- Database MySQL
- Server web Apache

### Instalasi

1. Clone repository backend:
   ```bash
   git clone <repository-url>
   cd project-backend

2. Install dependencies:
    composer install

3. Konfigurasi environment
    Salin .env.example menjadi .env, lalu sesuaikan konfigurasi database dan lainnya:
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=nama_database
    DB_USERNAME=root
    DB_PASSWORD=password

4. Generate application key:
    php artisan key:generate

5. Jalankan migrasi database:
    php artisan migrate

6. (Opsional) Seed database:
    php artisan db:seed

7. Jalankan server development:
    php artisan serve

8. API dapat diakses di:
    http://localhost:8000/api

## 4. Tantangan & Solusi

### Tantangan

- Menjaga agar logika bisnis perhitungan remunerasi tidak tersebar di berbagai tempat.

- Mengelola update data remunerasi saat data employee atau task berubah agar
    konsisten.

- Membuat struktur kode yang modular dan mudah di-maintain serta di-test.

- Menjaga performa query dan operasi update agar tidak memberatkan database.

### Solusi

- Menggunakan Clean Architecture dengan service layer untuk pemisahan logika bisnis.

- Membuat method terpisah updateTaskRemuneration yang terpusat untuk mengelola update
    remunerasi.

- Menggunakan repository pattern agar akses database terisolasi dan mudah dimock saat 
    testing.

- Optimasi query dan penggunaan eager loading untuk mengurangi beban database.

