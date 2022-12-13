# Era Quiz

## Requirements

1. PHP 7.4 or greater
2. Laravel version 8

## Installation

```shell
1. git clone https://github.com/bagus-repository/era

2. composer install

3. cp .env.example .env

4. php artisan key:generate

5. Buat db baru dan ubah koneksi db pada .env

6. php artisan migrate --seed

7. Ubah APP_URL pada .env sesuai dengan yang akan dipakai (penting untuk File manager)

8. php storage:link

9. php artisan serve
```
## Usage

### Login

```shell
Admin login

Email : admin@admin.com
Password : 123456
```
### Buat User
1. Silahkan dengan akun admin pada menu 'Daftar User'
2. Buat user role 'User' untuk generate quiz

### Buat Pertanyaan
1. Silahkan dengan akun admin pada menu 'Daftar Pertanyaan'
2. Buat pertanyaan setidaknya 10 dan jawaban minimal 1 maksimal 4, serta masukan score dan jawaban yang benar
3. Pertanyaan bisa diimpor menggunakan file xlsx, ada 2 sheets: 'Questions' untuk master pertanyaan dan 'Answers' untuk master jawaban, Question dan Answer dihubungkan dengan menggunakan ID Question, pastikan ID Question 'Question' dan ID Question 'Answers' sesuai yang diinginkan.
4. Note  *ID Question* bukan ID yang akan digenerate sistem, ini hanya sebgai penghubung antara 'Questions' dan 'Answer'

### Buat Quiz
1. Silahkan dengan akun admin pada menu 'Daftar Quiz'
2. Buat quiz dengan memilih pengguna role 'User' dan tentukan tanggal serta durasi quiz nya minimal 15 (dalam menit)
3. Quiz auto generate 10 soal acak untuk dijadikan sesi
### Mengerjakan Quiz
1. Silahkan login dengan akun role 'User' yang telah dibuatkan quiz
2. Jika ada quiz per hari login maka akan muncul quiz-quiz yang bisa dikerjakan
3. Klik Mulai untuk mengerjakan, klik Lanjutkan untuk melanjutkan mengerjakan, dan klik Lihat Hasil untuk melihat hasil quiz
4. Pertanyaan hanya muncul 1 kali setelah pengguna input jawaban
5. Ketika waktu habis atau soal sudah selesai maka user akan otomatis diarahkan ke halaman summary quiz

### Melakukan API Request
1. Import postman collection 'Quiz.postman_collection.json' pada aplikasi Postman
2. Lakukan login pada 'Request Login' dengan akun admin untuk mengakses API 'Get Questions' dan 'Get Users' (login dengan akun user tidak dapat mengakses API tersebut)
3. Get Questions dan Get Users menggunakan parameter 'page' untuk paging, memberikan angka 0 akan mengambil seluruh data (per page adalah 15 row)