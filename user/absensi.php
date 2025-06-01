<?php
session_start();
include '../db_connection.php';
include '../user/header.php';

// Cek login dan role user
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'user') {
    header("Location: ../login.php");
    exit;
}

$username = $_SESSION['username'];
$tanggal = date('Y-m-d');

// Cek apakah user sudah absen hari ini
$stmt = $conn->prepare("SELECT * FROM absensi WHERE username = ? AND tanggal = ?");
$stmt->bind_param("ss", $username, $tanggal);
$stmt->execute();
$result = $stmt->get_result();
$sudah_absen = $result->num_rows > 0;
$data_absen = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Absensi</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #eef2f7;
            margin: 0;
            padding: 0;
        }
        .absen-container {
            max-width: 600px;
            margin: 80px auto;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        h3 {
            text-align: center;
            color: #333;
        }
        form {
            margin-top: 30px;
        }
        label {
            display: block;
            margin: 15px 0 5px;
            font-weight: bold;
        }
        input[type="text"], select {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
        input[type="checkbox"] {
            transform: scale(1.3);
            margin-right: 10px;
        }
        input[type="submit"] {
            margin-top: 25px;
            width: 100%;
            padding: 12px;
            font-size: 16px;
            background-color: #2575fc;
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #1a5edb;
        }
        .alert {
            padding: 15px;
            background-color: #d4edda;
            color: #155724;
            border-radius: 8px;
            margin-top: 20px;
            border: 1px solid #c3e6cb;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="absen-container">
    <h3>Absensi Hari Ini</h3>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert">
            ✅ Absensi berhasil disimpan!
        </div>
    <?php endif; ?>

    <?php if ($sudah_absen): ?>
        <div class="alert">
            ✅ Anda sudah mengisi absensi hari ini.<br>
            Status: <strong><?= $data_absen['hadir'] ? 'Hadir' : 'Tidak Hadir'; ?></strong><br>
            Keterangan: <?= htmlspecialchars($data_absen['keterangan']); ?>
        </div>
    <?php else: ?>
        <form action="proses_absensi_user.php" method="post">
            <input type="hidden" name="tanggal" value="<?= $tanggal ?>">

            <label for="nama">Nama Lengkap:</label>
            <input type="text" name="nama" id="nama" required>

            <label><input type="checkbox" name="hadir" value="1"> Saya hadir hari ini</label>

            <label for="keterangan">Keterangan (jika tidak hadir):</label>
            <select name="keterangan" id="keterangan">
                <option value="">-</option>
                <option value="Sakit">Sakit</option>
                <option value="Izin">Izin</option>
                <option value="Alpha">Alpha</option>
            </select>

            <input type="submit" value="Kirim Absensi">
        </form>
    <?php endif; ?>
</div>

</body>
</html>
