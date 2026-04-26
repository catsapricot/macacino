# Macacino

Tugas besar ABP dari kelompok 4 IF-47-04 yang beranggotakan:
1. Ghanif Hadiyana Akbar (103012300018)
2. 
3. Daisaq Hadya Albar (103012300158)
4. Taraka Yumna Sarwoko (103012300242)
5. Muhammad Nazriel Ihram (103012300269)
6. Muhammad Zaini (103012300313)

## :books: Judul Proyek
Macacino

## :books: Deskripsi Proyek
Macacino adalah

## :books: Cara Menjalankan Aplikasi

### Prasyarat
- Install XAMPP (Include PHP & phpMyAdmin)
- Uncomment ";extension=zip" dalam file php.ini (C:\xampp\php) 
- Install Composer
- Install Git

### Menjalankan Aplikasi
1. Clone Repository<br />
```
git clone https://github.com/catsapricot/macacino.git
```

2. Masuk ke dalam folder<br />
```
cd macacino
```

3. Install semua dependencies PHP<br />
```
composer install
```

4. Copy file ".env.example" dan rename menjadi ".env"
```
cp .env.example .env
```

5. Edit ".env" dan ubah bagian-bagian ini saja
```
# Ubah nama aplikasi
APP_NAME=Readfolio

# Akan secara otomatis terisi saat "php artisan key:generate"
APP_KEY=

# Arahkan ke file database SQLite
# Gunakan path absolut, sesuaikan dengan lokasi folder project kamu
# Contoh Windows:
DB_DATABASE=C:\Users\namakamu\readfolio\database\readfolio.db
# Contoh Mac/Linux:
DB_DATABASE=/home/namakamu/readfolio/database/readfolio.db

# Isi API key kamu
GROQ_API_KEY=isi_api_key_groq_kamu_di_sini
ELEVENLABS_API_KEY=isi_api_key_elevenlabs_kamu_di_sini
```

6. Generate APP_KEY
```
php artisan key:generate
```

7. Buat file SQLite kosong
```
# Windows
New-Item -Path "database\readfolio.db" -ItemType File
# Linux
touch database/readfolio.db
```

8. Jalankan migration
```
php artisan migrate
```

9. Buat akun admin default
```
php artisan db:seed --class=AdminSeeder
```

10. Buat symlink storage untuk upload PDF
```
php artisan storage:link
```

11. Jalankan aplikasi
```
php artisan serve
```

12. Aplikasi sudah dapat diakses di browser
```
http://localhost:8000
```