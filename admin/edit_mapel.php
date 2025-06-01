<?php 
include '../admin/admin_check.php';
include '../db_connection.php'; 
include '../templates/header.php';

$id = intval($_GET['id'] ?? 0);
if ($id <= 0) {
    header("Location: mata_pelajaran.php");
    exit();
}

$stmt = $conn->prepare("SELECT kode, nama_pelajaran, guru FROM mata_pelajaran WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    $stmt->close();
    header("Location: mata_pelajaran.php");
    exit();
}
$data = $result->fetch_assoc();
$stmt->close();

$errors = [];

if (isset($_POST['submit'])) {
    $kode = trim($_POST['kode']);
    $nama = trim($_POST['nama_mapel']);
    $guru = trim($_POST['guru']);

    if (!$kode || !$nama || !$guru) {
        $errors[] = "Semua field wajib diisi.";
    }

    if (empty($errors)) {
        // Cek duplikat kode kecuali data sendiri
        $stmt = $conn->prepare("SELECT id FROM mata_pelajaran WHERE kode = ? AND id != ?");
        $stmt->bind_param("si", $kode, $id);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $errors[] = "Kode mata pelajaran sudah digunakan.";
        }
        $stmt->close();

        if (empty($errors)) {
            // Update data
            $stmt = $conn->prepare("UPDATE mata_pelajaran SET kode = ?, nama_pelajaran = ?, guru = ? WHERE id = ?");
            $stmt->bind_param("sssi", $kode, $nama, $guru, $id);
            $stmt->execute();
            $stmt->close();

            header("Location: mata_pelajaran.php");
            exit();
        }
    }
} else {
    // Isi form dengan data lama
    $kode = $data['kode'];
    $nama = $data['nama_pelajaran'];
    $guru = $data['guru'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Mata Pelajaran</title>
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        .form-container {
            max-width: 500px;
            margin: 40px auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 25px;
        }

        .mapel-form input[type="text"],
        .mapel-form input[type="submit"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }

        .mapel-form input[type="submit"] {
            background-color: #2575fc;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        .mapel-form input[type="submit"]:hover {
            background-color: #1a5edb;
        }

        .error-messages {
            color: red;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
<div class="form-container">
    <h2>Edit Mata Pelajaran</h2>

    <?php if (!empty($errors)): ?>
        <div class="error-messages">
            <ul>
                <?php foreach ($errors as $e) echo "<li>$e</li>"; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" class="mapel-form">
        <input type="text" name="kode" placeholder="Kode Mapel (misal: MPL005)" value="<?= htmlspecialchars($kode) ?>" required>
        <input type="text" name="nama_mapel" placeholder="Nama Mata Pelajaran" value="<?= htmlspecialchars($nama) ?>" required>
        <input type="text" name="guru" placeholder="Nama Guru Pengampu" value="<?= htmlspecialchars($guru) ?>" required>
        <input type="submit" name="submit" value="Update">
    </form>
</div>
</body>
</html>
