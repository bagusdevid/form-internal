# AGDC Form

## Instalasi

Untuk instalasi:

- Clone project dengan perintah `git clone https://github.com/alfisahr/agdc-form.git`
- Akan ada folder `agdc-form`. Silahkan rename folder tsb sesuai yang dikehendaki, misalkan `penawaran`
- Jalankan perintah `composer install` untuk menginstall dependency
- Buat file `.env` dengan kode kurang lebih spt ini
```
CI_ENVIRONMENT = production

# Masukkan URL
app.baseURL = 'http://localhost:8080/'

database.default.hostname = localhost
database.default.database = DB_Name
database.default.username = 
database.default.password = 
database.default.DBDriver = MySQLi
database.default.DBPrefix =
```

## Generate DB

- Pastikan database dengan nama yang sudah dicantumkan pada `.env` sudah tersedia
- Pada command jalankan `php spark migrate` untuk men-generate db structure

## Running aplikasi

- Buka console persis di directory project ini dan jalankan `php spark serve` untuk menstartup local web server. Gunakan flag port untuk menstartup diluar port default 8080. Seperti ini: `php spark serve --port 5000`
- Jika ingin me-running aplikasi dengan subfolder, contohnya `http://localhost/agdc` atau `http://10.14.83.2/agdc` silahkan ubah file `.htaccess` di `public/.htaccess` menjadi spt ini:
```
# public/.htacess

RewriteEngine on

RewriteCond $1 !^(index\.php|images|assets|css|js|robots\.txt|favicon\.ico)
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule (.*) index.php/$1 [L]

<IfModule mod_headers.c>
  <FilesMatch "\.(ttf|ttc|otf|eot|woff|woff2|font.css|css|js)$">
    Header set Access-Control-Allow-Origin "*"
  </FilesMatch>
</IfModule>
```
Kemudian tambahkan pula file `.htaccess` baru di root aplikasi, dengan kode spt ini:
```
# .htacess

DirectoryIndex index.php
Options -Indexes

RewriteEngine On

# Unconditionally rewrite everything to the "public" subdirectory
RewriteRule (.*) public/$1 [L]
```

## Update remote tracking
Untuk melakukan update atau sync aplikasi terbaru (paling mutakhir) jalankan melalui perintah `git pull origin main`
