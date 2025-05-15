# BackEnd Sistem Penjadwalan Sidang Skripsi Otomatis - CodeIgniter 4

## 📋 Apa Itu CodeIgniter?

CodeIgniter adalah framework PHP full-stack yang ringan, cepat, fleksibel, dan aman. Project ini menggunakan CodeIgniter 4 untuk membangun RESTful API untuk sistem penjadwalan sidang skripsi otomatis.

📘 Panduan resmi terkait CodeIgniter dapat dilihat pada [situs resmi](https://codeigniter.com/user_guide/) atau [user guide](https://codeigniter.com/user_guide/).

---

## 🚀 Instalasi

### 1. Clone Repository
Clone repositori backend ke dalam direktori lokal:
```bash
git clone https://github.com/milaaulia21/PBF_Backend.git
```
### 2. Instalasi Dependensi
```bash
composer install
```
### 3. Konfigurasi Environment
Salin file env menjadi .env :
```bash
cp env .env
```
Sesuaikan konfigurasi di file .env :
```bash
CI_ENVIRONMENT = development
app.baseURL = 'http://localhost:8080/'
database.default.hostname = localhost
database.default.database = nama_database
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
```
### 4. Import Database
Import file SQL berikut : [db_sidangskripsi.sql](db_sidangskripsi.sql)

### 5. Jalankan Server Development
```bash
php spark serve
```
Server akan berjalan di `http://localhost:8080/`

### 6. Cek Endpoint API menggunakan Postman
<b>Dosen<b>
*  `GET` → `http://localhost:8080/dosen`
*  `POST` → `http://localhost:8080/dosen`
*  `PUT` → `http://localhost:8080/dosen/{id}`
*  `DELETE` → `http://localhost:8080/dosen/{id}`

<b>Mahasiswa<b>
*  `GET` → `http://localhost:8080/mahasiswa`
*  `POST` → `http://localhost:8080/mahasiswa`
*  `PUT` → `http://localhost:8080/mahasiswa/{id}`
*  `DELETE` → `http://localhost:8080/mahasiswa/{id}`

<b>User<b>
*  `GET` → `http://localhost:8080/user`
*  `POST` → `http://localhost:8080/user`
*  `PUT` → `http://localhost:8080/user/{id}`
*  `DELETE` → `http://localhost:8080/user/{id}`

<b>Ruangan<b>
*  `GET` → `http://localhost:8080/ruangan`
*  `POST` → `http://localhost:8080/ruangan`
*  `PUT` → `http://localhost:8080/ruangan/{id}`
*  `DELETE` → `http://localhost:8080/ruangan/{id}`
