<?php 
include '../admin/admin_check.php';
include '../db_connection.php'; 
include '../templates/header.php'; 

if (isset($_POST['submit'])) {
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $tanggal_dibuat = date('Y-m-d'); // otomatis tanggal hari ini
    $batas_pengumpulan = $_POST['batas_pengumpulan'];

    $stmt = $conn->prepare("INSERT INTO tugas (judul, deskripsi, tanggal_dibuat, batas_pengumpulan) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $judul, $deskripsi, $tanggal_dibuat, $batas_pengumpulan);
    $stmt->execute();

    header("Location: tugas.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Tugas</title>
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        .form-container {
            max-width: 600px;
            margin: 40px auto;
            padding: 30px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }

        form input[type="text"],
        form textarea,
        form input[type="date"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 16px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        form textarea {
            resize: vertical;
            min-height: 100px;
        }

        form input[type="submit"] {
            background-color: #2575fc;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        form input[type="submit"]:hover {
            background-color: #1a5edb;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Buat Tugas Baru</h2>
    <form method="post">
        <input type="text" name="judul" placeholder="Judul Tugas" required>

        <textarea name="deskripsi" placeholder="Deskripsi Tugas" required></textarea>

        <label for="batas_pengumpulan">Batas Pengumpulan:</label>
        <input type="date" name="batas_pengumpulan" required>

        <input type="submit" name="submit" value="Simpan Tugas">
    </form>
</div>

<?php include '../templates/footer.php'; ?>
</body>
</html>
