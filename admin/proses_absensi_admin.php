<?php
include '../admin/admin_check.php';
include '../db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data input
    $hadir = $_POST['hadir'] ?? []; // array username yang hadir
    $keterangan = $_POST['keterangan'] ?? []; // array keterangan per username
    $tanggal = date('Y-m-d'); // tanggal hari ini

    // Ambil list user yang ada di form (misal dari tabel user, atau bisa dari absensi hari ini)
    // Tapi karena form mengambil data dari absensi (berdasarkan query), kita harus dapatkan username-nya
    // Untuk contoh, ambil semua username yang ada di POST keterangan (karena semua user ada di select)
    $usernames = array_keys($keterangan);

    foreach ($usernames as $username) {
        // Tentukan status hadir: 1 jika checkbox hadir dipilih, 0 jika tidak
        $is_hadir = in_array($username, $hadir) ? 1 : 0;
        $ket = $keterangan[$username] ?: NULL; // bisa kosong/null

        // Untuk nama lengkap, sebaiknya diambil dari tabel user (jika ada)
        // Contoh: 
        $stmt = $conn->prepare("SELECT nama FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $nama = "";
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $nama = $row['nama'];
        }
        $stmt->close();

        // Cek apakah data absensi untuk user dan tanggal ini sudah ada
        $stmt = $conn->prepare("SELECT id FROM absensi WHERE username = ? AND tanggal = ?");
        $stmt->bind_param("ss", $username, $tanggal);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Update data absensi
            $stmt_update = $conn->prepare("UPDATE absensi SET hadir = ?, keterangan = ? WHERE username = ? AND tanggal = ?");
            $stmt_update->bind_param("isss", $is_hadir, $ket, $username, $tanggal);
            $stmt_update->execute();
            $stmt_update->close();
        } else {
            // Insert data absensi baru
            $stmt_insert = $conn->prepare("INSERT INTO absensi (username, nama, tanggal, hadir, keterangan) VALUES (?, ?, ?, ?, ?)");
            $stmt_insert->bind_param("sssiss", $username, $nama, $tanggal, $is_hadir, $ket);
            $stmt_insert->execute();
            $stmt_insert->close();
        }

        $stmt->close();
    }

    header("Location: absensi.php?success=1");
    exit;
}
?>
