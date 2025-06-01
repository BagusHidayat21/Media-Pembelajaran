<?php 
include '../admin/admin_check.php';
include '../db_connection.php'; 
include '../templates/header.php'; 

if (isset($_POST['submit'])) {
    $kode = $_POST['kode'];
    $nama = $_POST['nama_mapel'];
    $guru = $_POST['guru'];

    $stmt = $conn->prepare("INSERT INTO mata_pelajaran (kode, nama_pelajaran, guru) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $kode, $nama, $guru);
    $stmt->execute();

    header("Location: mata_pelajaran.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Mata Pelajaran</title>
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
    </style>
</head>
<body>
<div class="form-container">
    <h2>Tambah Mata Pelajaran</h2>
    <form method="post" class="mapel-form">
        <input type="text" name="kode" placeholder="Kode Mapel (misal: MPL005)" required>
        <input type="text" name="nama_mapel" placeholder="Nama Mata Pelajaran" required>
        <input type="text" name="guru" placeholder="Nama Guru Pengampu" required>
        <input type="submit" name="submit" value="Simpan">
    </form>
</div>
</body>
</html>
