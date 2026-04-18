---

# 📘 Setup Project POS Kasir (Laravel + MySQL)

## 1. Clone Repository

```bash
git clone <url-repository>
cd Pos-Kasir/laravel
```

---

## 2. Install Dependency

```bash
composer install
```

---

## 3. Setup Environment

Copy file environment:

```bash
cp .env.example .env
```

---

## 4. Konfigurasi Database

Edit file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pos_kasir
DB_USERNAME=root
DB_PASSWORD=12345678
```

---

## 5. Buat Database

Masuk ke **MySQL** lalu jalankan:

```sql
CREATE DATABASE pos_kasir;
```

---

## 6. Generate App Key (optional)

```bash
php artisan key:generate
```

---

## 7. Clear Config

```bash
php artisan config:clear
php artisan cache:clear
```

---

## 8. Jalankan Migration

```bash
php artisan migrate
```

Jika berhasil, tabel seperti:

- users
- cache
- jobs
  akan otomatis dibuat

---

## 9. Jalankan Server

```bash
php artisan serve
```

Akses di browser:

```
http://127.0.0.1:8000
```

---

# ⚙️ Troubleshooting

## ❌ Database tidak ditemukan

Error:

```
Unknown database 'pos_kasir'
```

Solusi:

```sql
CREATE DATABASE pos_kasir;
```

---

## ❌ Tabel tidak ada

Error:

```
Table 'pos_kasir.cache' doesn't exist
```

Solusi:

```bash
php artisan migrate
```

---

## ❌ MySQL tidak connect

- Pastikan MySQL nyala (XAMPP/Laragon/Docker)
- Cek username & password

---

# 👥 Workflow Tim (WAJIB)

## 1. Jangan commit `.env` (optional)

Pastikan `.gitignore` ada:

```
.env
```

---

## 2. Gunakan branch masing-masing

Contoh:

```bash
feature-login
feature-produk
feature-transaksi
```

---

## 3. Ambil update dari develop

```bash
git checkout develop
git pull origin develop
```

---

## 4. Update branch sendiri

```bash
git checkout feature-nama
git merge develop
```

---

## 5. Push kerjaan

```bash
git add .
git commit -m "fitur: tambah produk"
git push origin feature-nama
```

---

## 6. Merge ke develop

- Buat Pull Request
- Review
- Merge

---
