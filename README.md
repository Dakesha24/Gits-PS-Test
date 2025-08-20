Tautan
Akses di: https://gits-test.gt.tc/

Daftar Soal
Soal 1: Kalkulator Deret A000124 of Sloane's OEIS (soal1.php)
Menghasilkan deret "Lazy Caterer's Sequence" berdasarkan jumlah suku yang dimasukkan.
Deret dihitung menggunakan rumus: (n² + n + 2) / 2 untuk n mulai dari 0.
Contoh: Input (5) → Output: "1-2-4-7-11".

Soal 2: Dense Ranking (soal2.php)
Menghitung peringkat pemain berdasarkan skema Dense Ranking, di mana skor yang sama mendapatkan peringkat yang sama.
Input: Jumlah pemain, daftar skor pemain, jumlah permainan GITS, dan skor GITS.
Output: Peringkat GITS untuk setiap skornya.
Contoh: Input (7, "100 100 50 40 40 20 10", 4, "5 25 50 120") → Output: "6 4 2 1".

Soal 3: Highest Palindrome (soal3.php)
Menemukan palindrom terbesar yang dapat dibentuk dengan mengubah maksimal k digit pada string angka.
Menggunakan pendekatan rekursif tanpa loop atau fungsi bawaan untuk pencarian/penyortiran.
Output menampilkan semua palindrom yang mungkin dan palindrom terbesar.
Contoh: Input ("3943", 1) → Output: "1. 3943 => 3443", "2. 3943 => 3993", Palindrom Terbesar: "3993".
Contoh: Input ("932239", 2) → Output: "1. 932239 => sudah palindrome", "2. 932239 => 992299 (Perlu replacement sebanyak k = 2 untuk mendapatkan nilai tertinggi)", Palindrom Terbesar: "992299".

Prasyarat
Untuk menjalankan proyek ini secara lokal, Anda memerlukan:
- Server web dengan PHP (misalnya, XAMPP, WAMP, atau PHP built-in server).
- Browser web (Chrome, Firefox, dll.).

Cara Menjalankan Secara Lokal
- Clone atau Unduh Proyek
- Unduh file proyek atau clone repositori ini ke direktori lokal Anda.
- Siapkan Server Web
- Salin semua file (index.php, soal1.php, soal2.php, soal3.php) ke direktori server web Anda (misalnya, htdocs pada XAMPP).
Alternatif: Jalankan server PHP bawaan dengan perintah:
php -S localhost:8000

Akses Halaman Indeks
- Buka browser dan kunjungi http://localhost:8000/index.php (atau sesuai port server Anda).
- Halaman indeks akan menampilkan tautan ke masing-masing soal.
- Navigasi ke Soal: Klik tautan pada halaman indeks untuk mengakses soal1.php, soal2.php, atau soal3.php.

Masukkan input sesuai petunjuk pada masing-masing halaman.
