<?php
session_start();
include '../db_connection.php';

// Pastikan user login dengan role user
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'user') {
    header("Location: ../login.php");
    exit;
}

$username   = $_SESSION['username'];
$nama       = trim($_POST['nama'] ?? '');
$tanggal    = $_POST['tanggal'];
$hadir      = isset($_POST['hadir']) ? 1 : 0;
$keterangan = $_POST['keterangan'] ?? '';

// Validasi nama
if (empty($nama)) {
    echo "❌ Nama wajib diisi.";
    exit;
}

// Cek apakah user sudah absen hari ini
$cek = $conn->prepare("SELECT * FROM absensi WHERE username = ? AND tanggal = ?");
$cek->bind_param("ss", $username, $tanggal);
$cek->execute();
$cek_result = $cek->get_result();

if ($cek_result->num_rows > 0) {
    echo "❌ Anda sudah mengisi absensi hari ini.";
    exit;
}
$cek->close();

// Simpan data absensi
$stmt = $conn->prepare("INSERT INTO absensi (username, nama, tanggal, hadir, keterangan) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssds", $username, $nama, $tanggal, $hadir, $keterangan);

if ($stmt->execute()) {
    header("Location: absensi.php?success=1");
    exit;
} else {
    echo "❌ Gagal menyimpan absensi.";
}
$stmt->close();
?>
