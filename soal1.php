<?php

function hitung_deret_a000124(int $jumlah_suku): string
{
  //validasi sederhana jika angka yang masuk negatif atau nol.
  if ($jumlah_suku <= 0) {
    return "Input harus merupakan angka positif.";
  }

  //Siapkan 'wadah' kosong untuk menampung angka-angka deret.
  $deret_angka = [];

  //lakukan perulangan dari n=0 sampai n lebih kecil dari jumlah suku.
  for ($n = 0; $n < $jumlah_suku; $n++) {
    // Terapkan rumus A000124: (n² + n + 2) / 2
    $suku = ($n ** 2 + $n + 2) / 2;
    //masukkan hasil perhitungan ke dalam wadah/array.
    $deret_angka[] = (int)$suku;
  }
  //Gabungkan semua angka di dalam array menjadi string dengan pemisah '-'.
  return implode('-', $deret_angka);
}

// Siapkan variabel kosong untuk menampung hasil dan input dari pengguna.
$hasil_deret = '';      // Untuk menyimpan string output, misal: "1-2-4-7-11"
$input_sebelumnya = ''; // Untuk menyimpan angka yang diinput pengguna.

// Cek apakah ada data yang dikirim melalui URL dengan nama 'jumlah_suku'.
// `isset()` berarti "apakah ada dan tidak null?".
if (isset($_GET['jumlah_suku']) && !empty($_GET['jumlah_suku'])) {
  // Jika ada, ambil data tersebut dan ubah menjadi angka (integer).
  $input_sebelumnya = (int)$_GET['jumlah_suku'];
  // Panggil fungsi hitung di atas dengan angka dari pengguna.
  $hasil_deret = hitung_deret_a000124($input_sebelumnya);
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Kalkulator Deret A000124</title>
  <style>
    body {
      font-family: system-ui, sans-serif;
      max-width: 600px;
      margin: 40px auto;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 10px;
    }

    form {
      margin-bottom: 20px;
    }

    input {
      font-size: 1em;
      padding: 8px;
    }

    button {
      font-size: 1em;
      padding: 8px 12px;
    }

    .hasil {
      padding: 15px;
      background-color: #eef7ff;
      border-left: 5px solid #0d6efd;
    }
  </style>
</head>

<body>
  <h1>Kalkulator Deret A000124</h1>
  <p>Program ini menghasilkan deret "Lazy Caterer's Sequence" berdasarkan jumlah suku yang Anda masukkan.</p>

  <form action="" method="GET">
    <label for="jumlah"><strong>Masukkan jumlah suku:</strong></label><br><br>

    <input type="number" id="jumlah" name="jumlah_suku" value="<?= htmlspecialchars($input_sebelumnya) ?>" min="1" required>

    <button type="submit">Hitung</button>
  </form>

  <?php
  // Cek apakah variabel `$hasil_deret` sudah berisi (artinya perhitungan sudah dilakukan).
  if ($hasil_deret):
  ?>
    <div class="hasil">
      <h3>Hasil Perhitungan:</h3>
      <p><strong>Input Anda:</strong> <?= htmlspecialchars($input_sebelumnya) ?></p>
      <p><strong>Output Deret:</strong> <?= htmlspecialchars($hasil_deret) ?></p>
    </div>
  <?php
  // Akhiri blok `if`. Jika tidak ada hasil, semua kode di dalam blok ini tidak akan ditampilkan.
  endif;
  ?>

</body>

</html>