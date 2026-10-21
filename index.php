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
    <title>Tugas 1 Pemrograman PHP</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f2f4f8; display: flex; justify-content: center; padding: 40px; }
        .card { background: #fff; padding: 24px; border-radius: 10px; width: 360px; box-shadow: 0 2px 8px rgba(0,0,0,.1); }
        label { display: block; margin-top: 12px; font-weight: bold; }
        input { width: 100%; padding: 8px; margin-top: 4px; box-sizing: border-box; }
        button { margin-top: 16px; width: 100%; padding: 10px; background: #2563eb; color: #fff; border: 0; border-radius: 6px; cursor: pointer; }
        .error { color: #b91c1c; margin-top: 12px; }
        .hasil { margin-top: 20px; padding: 12px; border-radius: 6px; background: #eef2ff; }
        .Lulus { color: #15803d; font-weight: bold; }
        .Remedial { color: #b91c1c; font-weight: bold; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Form Nilai Ujian</h2>
        <form method="post">
            <label>Nama</label>
            <input type="text" name="nama" value="<?= htmlspecialchars($_POST['nama'] ?? '') ?>">
            <label>Email</label>
            <input type="text" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
            <label>Nilai Ujian</label>
            <input type="number" name="nilai" min="0" max="100" value="<?= htmlspecialchars($_POST['nilai'] ?? '') ?>">
            <button type="submit">Kirim</button>
        </form>

        <?php foreach ($errors as $e): ?>
            <div class="error"><?= htmlspecialchars($e) ?></div>
        <?php endforeach; ?>

        <?php if ($hasil): ?>
            <div class="hasil">
                <p>Nama: <?= htmlspecialchars($hasil['nama']) ?></p>
                <p>Email: <?= htmlspecialchars($hasil['email']) ?></p>
                <p>Nilai: <?= $hasil['nilai'] ?></p>
                <p>Status: <span class="<?= $hasil['status'] ?>"><?= $hasil['status'] ?></span></p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>