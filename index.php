<?php
$hasil = null;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $nilai = $_POST['nilai'] ?? '';

    if ($nama === '') {
        $errors[] = 'Nama wajib diisi.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Email tidak valid.';
    }
    if (!is_numeric($nilai) || $nilai < 0 || $nilai > 100) {
        $errors[] = 'Nilai harus angka 0-100.';
    }

    if (!$errors) {
        $nilai = (float) $nilai;
        $status = $nilai >= 70 ? 'Lulus' : 'Remedial';
        $hasil = compact('nama', 'email', 'nilai', 'status');
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tugas 1 - PHP</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="card">
        <h1>FORMULIR NILAI UJIAN</h1>
        <p class="sub">Masukkan data diri dan nilai ujian untuk melihat hasil kelulusan.</p>

        <?php foreach ($errors as $e): ?>
            <div class="error"><?= htmlspecialchars($e) ?></div>
        <?php endforeach; ?>

        <form method="post">
            <div class="field">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" placeholder="Masukkan nama lengkap Anda..." value="<?= htmlspecialchars($_POST['nama'] ?? '') ?>">
            </div>
            <div class="field">
                <label>Email</label>
                <input type="text" name="email" placeholder="contoh@gmail.com" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
            </div>
            <div class="field">
                <label>Nilai Ujian</label>
                <input type="number" name="nilai" min="0" max="100" placeholder="0 - 100" value="<?= htmlspecialchars($_POST['nilai'] ?? '') ?>">
            </div>
            <button type="submit">Periksa Hasil Ujian</button>
        </form>

        <?php if ($hasil): ?>
            <div class="hasil">
                <h3>Hasil Pemeriksaan</h3>
                <div class="baris"><span>Nama</span><span><?= htmlspecialchars($hasil['nama']) ?></span></div>
                <div class="baris"><span>Email</span><span><?= htmlspecialchars($hasil['email']) ?></span></div>
                <div class="baris"><span>Nilai</span><span><?= $hasil['nilai'] ?></span></div>
                <div class="status <?= $hasil['status'] ?>"><?= strtoupper($hasil['status']) ?></div>
            </div>
        <?php endif; ?>

        <p class="footer">Muhamad Wildan - STTNF - Tugas 1 - Pemrograman PHP</p>
    </div>
</body>
</html>