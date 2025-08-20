<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kalkulator Highest Palindrome</title>
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
            width: 100%;
            margin-bottom: 10px;
        }
        button {
            font-size: 1em;
            padding: 8px 12px;
        }
        .error {
            padding: 15px;
            background-color: #ffeeee;
            border-left: 5px solid #dc3545;
        }
        .hasil {
            padding: 15px;
            background-color: #eef7ff;
            border-left: 5px solid #0d6efd;
        }
    </style>
</head>
<body>
    <h1>Kalkulator Highest Palindrome</h1>
    <p>Program ini menghitung palindrom terbesar yang dapat dibentuk dengan mengubah maksimal k digit.</p>
    <form method="post" action="">
        <label for="string"><strong>String Angka:</strong></label><br><br>
        <input type="text" id="string" name="string" value="<?php echo isset($_POST['string']) ? htmlspecialchars($_POST['string']) : ''; ?>" placeholder="Contoh: 3943" required>
        
        <label for="k"><strong>Jumlah Maksimal Perubahan (k):</strong></label><br><br>
        <input type="number" id="k" name="k" min="0" value="<?php echo isset($_POST['k']) ? htmlspecialchars($_POST['k']) : ''; ?>" placeholder="Contoh: 1" required>
        
        <button type="submit">Hitung Palindrom</button>
    </form>

    <?php
    // Memeriksa apakah form telah disubmit melalui metode POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Inisialisasi array untuk menyimpan pesan error jika validasi gagal
        $errors = [];
        
        // Mengambil input string angka dan jumlah perubahan k
        $string = trim($_POST['string']);
        $k = filter_input(INPUT_POST, 'k', FILTER_VALIDATE_INT);

        // Validasi input k: harus bilangan bulat non-negatif
        if ($k === false || $k < 0) {
            $errors[] = "Jumlah perubahan (k) harus bilangan bulat non-negatif.";
        }

        // Validasi input string: harus berisi hanya angka
        if (!preg_match('/^\d+$/', $string)) {
            $errors[] = "String harus berisi hanya angka.";
        }

        // Jika tidak ada error, lanjutkan ke perhitungan palindrom
        if (empty($errors)) {
            // Fungsi rekursif untuk memeriksa apakah string adalah palindrom
            function isPalindrome($str, $left, $right) {
                // Base case: jika left >= right, string adalah palindrom
                if ($left >= $right) {
                    return true;
                }
                // Jika karakter di left dan right berbeda, bukan palindrom
                if ($str[$left] !== $str[$right]) {
                    return false;
                }
                // Lanjutkan memeriksa pasangan berikutnya
                return isPalindrome($str, $left + 1, $right - 1);
            }

            // Fungsi rekursif untuk menghitung minimum perubahan agar menjadi palindrom
            function minChangesToPalindrome($str, $left, $right, &$memo = []) {
                // Kunci untuk memoization berdasarkan indeks left dan right
                $key = "$left-$right";
                if (isset($memo[$key])) {
                    return $memo[$key];
                }
                // Base case: jika left >= right, tidak perlu perubahan lagi
                if ($left >= $right) {
                    return 0;
                }
                // Jika karakter di posisi left dan right berbeda, perlu satu perubahan
                if ($str[$left] !== $str[$right]) {
                    $memo[$key] = 1 + minChangesToPalindrome($str, $left + 1, $right - 1, $memo);
                } else {
                    // Jika karakter sama, lanjutkan ke pasangan berikutnya
                    $memo[$key] = minChangesToPalindrome($str, $left + 1, $right - 1, $memo);
                }
                return $memo[$key];
            }

            // Fungsi rekursif untuk membuat palindrom dengan minimum perubahan
            function makeMinPalindrome($str, $left, $right, $k, &$memo = []) {
                // Kunci untuk memoization berdasarkan indeks left, right, dan k
                $key = "$left-$right-$k";
                if (isset($memo[$key])) {
                    return $memo[$key];
                }
                // Base case: jika left >= right, kembalikan string saat ini
                if ($left >= $right) {
                    return $str;
                }
                // Konversi string ke array untuk memudahkan pengubahan karakter
                $chars = str_split($str);
                // Jika karakter di left dan right berbeda
                if ($chars[$left] !== $chars[$right] && $k >= 1) {
                    // Gunakan karakter minimum untuk menghemat perubahan
                    $min_char = min($chars[$left], $chars[$right]);
                    $chars[$left] = $chars[$right] = $min_char;
                    $new_str = implode('', $chars);
                    $result = makeMinPalindrome($new_str, $left + 1, $right - 1, $k - 1, $memo);
                    $memo[$key] = $result;
                    return $result;
                }
                // Jika karakter sama atau k tidak cukup, lanjutkan ke pasangan berikutnya
                $result = makeMinPalindrome($str, $left + 1, $right - 1, $k, $memo);
                $memo[$key] = $result;
                return $result;
            }

            // Fungsi rekursif untuk membuat palindrom terbesar
            function makeHighestPalindrome($str, $k, $left, $right, &$memo = []) {
                // Kunci untuk memoization berdasarkan indeks left, right, dan k
                $key = "$left-$right-$k";
                if (isset($memo[$key])) {
                    return $memo[$key];
                }
                // Base case: jika left >= right, kembalikan string saat ini
                if ($left >= $right) {
                    return $str;
                }
                // Konversi string ke array untuk memudahkan pengubahan karakter
                $chars = str_split($str);
                // Ambil karakter maksimum dari pasangan left dan right
                $max_char = max($chars[$left], $chars[$right]);
                // Jika karakter di left dan right berbeda
                if ($chars[$left] !== $chars[$right]) {
                    // Jika k cukup, ubah keduanya menjadi '9' untuk maksimalkan nilai
                    if ($k >= 2 && $max_char !== '9') {
                        $chars[$left] = $chars[$right] = '9';
                        $new_str = implode('', $chars);
                        $result = makeHighestPalindrome($new_str, $k - 2, $left + 1, $right - 1, $memo);
                        $memo[$key] = $result;
                        return $result;
                    }
                    // Jika k hanya cukup untuk satu perubahan, gunakan karakter maksimum
                    if ($k >= 1) {
                        $chars[$left] = $chars[$right] = $max_char;
                        $new_str = implode('', $chars);
                        $result = makeHighestPalindrome($new_str, $k - 1, $left + 1, $right - 1, $memo);
                        $memo[$key] = $result;
                        return $result;
                    }
                    // Jika k tidak cukup, kembalikan string kosong (akan menghasilkan -1)
                    $memo[$key] = '';
                    return '';
                }
                // Jika karakter sama, lanjutkan ke pasangan berikutnya tanpa mengurangi k
                $result = makeHighestPalindrome($str, $k, $left + 1, $right - 1, $memo);
                $memo[$key] = $result;
                return $result;
            }

            // Fungsi utama untuk mendapatkan palindrom terbesar dan alternatif
            function highestPalindrome($string, $k) {
                // Periksa apakah string sudah palindrom
                $is_already_palindrome = isPalindrome($string, 0, strlen($string) - 1);
                // Hitung minimum perubahan yang diperlukan untuk membuat palindrom
                $min_changes = minChangesToPalindrome($string, 0, strlen($string) - 1);
                // Jika minimum perubahan melebihi k, tidak mungkin membentuk palindrom
                if ($min_changes > $k) {
                    return ['result' => '-1', 'palindromes' => []];
                }
                // Inisialisasi array untuk menyimpan palindrom yang mungkin
                $palindromes = [];
                // Jika sudah palindrom, tambahkan ke daftar
                if ($is_already_palindrome) {
                    $palindromes[] = "$string => sudah palindrome";
                } else {
                    // Tambahkan palindrom dengan minimum perubahan
                    $min_palindrome = makeMinPalindrome($string, 0, strlen($string) - 1, $min_changes);
                    if (!empty($min_palindrome) && preg_match('/^\d+$/', $min_palindrome)) {
                        $palindromes[] = "$string => $min_palindrome";
                    }
                }
                // Jika k cukup untuk maksimasi, tambahkan palindrom terbesar
                if ($k >= $min_changes) {
                    $max_palindrome = makeHighestPalindrome($string, $k, 0, strlen($string) - 1);
                    if (!empty($max_palindrome) && preg_match('/^\d+$/', $max_palindrome)) {
                        $palindromes[] = "$string => $max_palindrome" . ($k >= 2 ? " (Perlu replacement sebanyak k = $k untuk mendapatkan nilai tertinggi)" : '');
                    }
                }
                // Jika tidak ada palindrom valid, kembalikan -1
                if (empty($palindromes)) {
                    return ['result' => '-1', 'palindromes' => []];
                }
                // Kembalikan palindrom terbesar sebagai hasil dan daftar palindrom
                return ['result' => end($palindromes), 'palindromes' => $palindromes];
            }

            // Mendapatkan hasil palindrom
            $result_data = highestPalindrome($string, $k);
            $result = $result_data['result'];
            $palindromes = $result_data['palindromes'];
            
            // Menampilkan hasil perhitungan dalam div hasil
            ?>
            <div class="hasil">
                <h3>Hasil Perhitungan:</h3>
                <p><strong>String Input:</strong> <?php echo htmlspecialchars($string); ?></p>
                <p><strong>Jumlah Perubahan (k):</strong> <?php echo htmlspecialchars($k); ?></p>
                <p><strong>Palindrom yang Mungkin:</strong></p>
                <ol>
                    <?php foreach ($palindromes as $index => $palindrome) { ?>
                        <li><?php echo htmlspecialchars($palindrome); ?></li>
                    <?php } ?>
                    <?php if (empty($palindromes)) { ?>
                        <li>Tidak dapat membentuk palindrom dengan k perubahan.</li>
                    <?php } ?>
                </ol>
                <p><strong>Palindrom Terbesar:</strong> <?php echo htmlspecialchars($result === '-1' ? '-1' : explode(' => ', $result)[1]); ?></p>
            </div>
            <?php
        } else {
            // Menampilkan pesan error jika validasi gagal
            ?>
            <div class="error">
                <h3>Error:</h3>
                <?php foreach ($errors as $error) { ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php } ?>
            </div>
            <?php
        }
    }
    ?>
</body>
</html>