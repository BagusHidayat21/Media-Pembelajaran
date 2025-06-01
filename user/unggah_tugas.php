<?php
session_start();
include '../db_connection.php';
include '../user/header.php'; 

$user_id = $_SESSION['user_id'] ?? null;
$tugas_id = $_POST['tugas_id'] ?? null;
$tanggal_kumpul = date('Y-m-d H:i:s');

if (!$user_id || !$tugas_id) {
    die("User ID atau Tugas ID tidak ditemukan.");
}

// Folder penyimpanan file
$target_dir = "../uploads/";
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true);
}

if (!isset($_FILES["file_tugas"])) {
    die("File tugas tidak ditemukan.");
}

if ($_FILES["file_tugas"]["error"] !== UPLOAD_ERR_OK) {
    die("Error saat upload file: " . $_FILES["file_tugas"]["error"]);
}

$file_name = basename($_FILES["file_tugas"]["name"]);
$unique_name = time() . "_" . preg_replace("/[^a-zA-Z0-9\.\-_]/", "", $file_name);
$target_file = $target_dir . $unique_name;
$file_type = strtolower(pathinfo($unique_name, PATHINFO_EXTENSION));

$allowed_types = ['pdf', 'doc', 'docx', 'ppt', 'pptx', 'zip'];
if (!in_array($file_type, $allowed_types)) {
    die("Format file tidak didukung. Hanya diperbolehkan: " . implode(", ", $allowed_types));
}

if (move_uploaded_file($_FILES["file_tugas"]["tmp_name"], $target_file)) {
    // Simpan data ke database
    $stmt = $conn->prepare("INSERT INTO pengumpulan_tugas (tugas_id, user_id, file_tugas, tanggal_kumpul) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $tugas_id, $user_id, $unique_name, $tanggal_kumpul);

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        header("Location: tugas.php?status=berhasil");
        exit;
    } else {
        echo "Gagal menyimpan data ke database: " . $stmt->error;
    }
} else {
    echo "Gagal mengunggah file.";
}

$conn->close();
?>
