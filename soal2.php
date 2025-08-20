<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kalkulator Dense Ranking</title>
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
        input, textarea {
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
    <h1>Kalkulator Dense Ranking</h1>
    <p>Program ini menghitung peringkat GITS berdasarkan skema Dense Ranking.</p>
    <form method="post" action="">
        <label for="num_players"><strong>Jumlah Pemain:</strong></label><br><br>
        <input type="number" id="num_players" name="num_players" min="1" value="<?php echo isset($_POST['num_players']) ? htmlspecialchars($_POST['num_players']) : ''; ?>" placeholder="Contoh: 7" required>
        
        <label for="scores"><strong>Skor Pemain (dipisah spasi):</strong></label><br><br>
        <textarea id="scores" name="scores" rows="4" placeholder="Contoh: 100 100 50 40 40 20 10" required><?php echo isset($_POST['scores']) ? htmlspecialchars($_POST['scores']) : ''; ?></textarea>
        
        <label for="gits_games"><strong>Jumlah Permainan GITS:</strong></label><br><br>
        <input type="number" id="gits_games" name="gits_games" min="1" value="<?php echo isset($_POST['gits_games']) ? htmlspecialchars($_POST['gits_games']) : ''; ?>" placeholder="Contoh: 4" required>
        
        <label for="gits_scores"><strong>Skor GITS (dipisah spasi):</strong></label><br><br>
        <textarea id="gits_scores" name="gits_scores" rows="4" placeholder="Contoh: 5 25 50 120" required><?php echo isset($_POST['gits_scores']) ? htmlspecialchars($_POST['gits_scores']) : ''; ?></textarea>
        
        <button type="submit">Hitung Peringkat</button>
    </form>

    <?php
    //memeriksa apakah form telah disubmit melalui metode POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //Inisialisasi array kosong untuk menyimpan pesan error jika validasi gagal
        $errors = [];
        
        //mengambil input jumlah pemain dan memvalidasi bahwa itu adalah integer
        $num_players = filter_input(INPUT_POST, 'num_players', FILTER_VALIDATE_INT);
        //mengambil input skor pemain sebagai string dan menghapus spasi berlebih
        $scores_input = trim($_POST['scores']);
        // Mengambil input jumlah permainan GITS dan memvalidasi bahwa itu adalah integer
        $gits_games = filter_input(INPUT_POST, 'gits_games', FILTER_VALIDATE_INT);
        // Mengambil input skor GITS sebagai string dan menghapus spasi berlebih
        $gits_scores_input = trim($_POST['gits_scores']);

        // Validasi jumlah pemain: harus bilangan bulat positif
        if ($num_players === false || $num_players < 1) {
            $errors[] = "Jumlah pemain harus bilangan bulat positif.";
        }

        // Validasi skor pemain: ubah string skor menjadi array dengan pemisah spasi
        $scores = array_filter(array_map('trim', explode(' ', $scores_input)), 'strlen');
        // Memastikan jumlah skor sesuai dengan jumlah pemain yang diinput
        if (count($scores) !== $num_players) {
            $errors[] = "Jumlah skor harus sama dengan jumlah pemain ($num_players).";
        }
        // Memeriksa setiap skor untuk memastikan itu adalah angka non-negatif
        foreach ($scores as $score) {
            if (!is_numeric($score) || $score < 0) {
                $errors[] = "Semua skor harus berupa angka non-negatif.";
                break; // Hentikan loop jika ada skor tidak valid
            }
        }

        // Validasi jumlah permainan GITS: harus bilangan bulat positif
        if ($gits_games === false || $gits_games < 1) {
            $errors[] = "Jumlah permainan GITS harus bilangan bulat positif.";
        }
        // Validasi skor GITS: ubah string skor GITS menjadi array dengan pemisah spasi
        $gits_scores = array_filter(array_map('trim', explode(' ', $gits_scores_input)), 'strlen');
        // Memastikan jumlah skor GITS sesuai dengan jumlah permainan yang diinput
        if (count($gits_scores) !== $gits_games) {
            $errors[] = "Jumlah skor GITS harus sama dengan jumlah permainan ($gits_games).";
        }
        // Memeriksa setiap skor GITS untuk memastikan itu adalah angka non-negatif
        foreach ($gits_scores as $score) {
            if (!is_numeric($score) || $score < 0) {
                $errors[] = "Semua skor GITS harus berupa angka non-negatif.";
                break; // Hentikan loop jika ada skor tidak valid
            }
        }

        // Jika tidak ada error setelah validasi, lanjutkan ke perhitungan peringkat
        if (empty($errors)) {
            // Konversi semua skor pemain dan skor GITS menjadi integer untuk perhitungan
            $scores = array_map('intval', $scores);
            $gits_scores = array_map('intval', $gits_scores);

            // Fungsi untuk menghitung peringkat dengan skema Dense Ranking
            function getDenseRankings($scores, $gits_scores) {
                // Membuat daftar skor unik untuk menghindari duplikasi skor
                $unique_scores = array_unique($scores);
                // Mengurutkan skor dari besar ke kecil untuk menentukan peringkat
                rsort($unique_scores);
                
                // Membuat peta peringkat: setiap skor unik diberi peringkat
                $rank_map = [];
                $rank = 1; // Peringkat dimulai dari 1 untuk skor tertinggi
                foreach ($unique_scores as $score) {
                    //menetapkan peringkat untuk skor unik, sesuai skema Dense Ranking
                    //skor yang sama mendapat peringkat yang sama
                    $rank_map[$score] = $rank;
                    $rank++; // Tambah peringkat untuk skor berikutnya
                }
                
                // Menghitung peringkat untuk setiap skor GITS
                $result = [];
                foreach ($gits_scores as $score) {
                    // Inisialisasi peringkat awal untuk skor GITS
                    $gits_rank = 1;
                    // Bandingkan skor GITS dengan setiap skor unik
                    foreach ($unique_scores as $unique_score) {
                        // Jika skor GITS lebih besar atau sama dengan skor unik,
                        // gunakan peringkat dari skor unik tersebut
                        if ($score >= $unique_score) {
                            $gits_rank = $rank_map[$unique_score];
                            break; // Keluar dari loop setelah menemukan peringkat
                        }
                        // Jika skor GITS lebih kecil, tambah peringkat
                        // Ini memastikan skor yang lebih kecil dari semua skor unik
                        // mendapat peringkat lebih tinggi (misal, jika skor GITS 5
                        // dan skor terkecil adalah 10, maka peringkatnya adalah 6)
                        $gits_rank++;
                    }
                    // Simpan peringkat GITS ke dalam array hasil
                    $result[] = $gits_rank;
                }
                
                // Kembalikan array berisi peringkat GITS
                return $result;
            }

            // Mendapatkan hasil peringkat dengan memanggil fungsi
            $rankings = getDenseRankings($scores, $gits_scores);
            
            // Menampilkan hasil perhitungan dalam div hasil
            ?>
            <div class="hasil">
                <h3>Hasil Perhitungan:</h3>
                <p><strong>Peringkat GITS:</strong> <?php echo htmlspecialchars(implode(' ', $rankings)); ?></p>
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