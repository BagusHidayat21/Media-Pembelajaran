<?php 
include '../admin/admin_check.php';
include '../db_connection.php'; 
include '../templates/header.php'; 
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Tugas</title>
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .tugas-container {
            padding: 30px;
            max-width: 900px;
            margin: auto;
        }

        .tugas-container h3 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        .add-button {
            display: inline-block;
            background-color: #2575fc;
            color: #fff;
            padding: 10px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            margin-bottom: 20px;
            transition: background 0.3s ease;
        }

        .add-button:hover {
            background-color: #1a5edb;
        }

        .tugas-list {
            list-style: none;
            padding: 0;
        }

        .tugas-list li {
            background: #f8f8f8;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 15px;
            border-left: 5px solid #2575fc;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        }

        .tugas-title {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-bottom: 6px;
        }

        .tugas-deskripsi {
            font-size: 14px;
            color: #555;
            margin-bottom: 8px;
        }

        .tugas-info {
            font-size: 13px;
            color: #777;
        }
    </style>
</head>
<body>

<div class="tugas-container">
    <h3>Daftar Tugas</h3>
    <a href="tambah_tugas.php" class="add-button">+ Buat Tugas</a>

    <ul class="tugas-list">
    <?php
    $result = $conn->query("SELECT * FROM tugas ORDER BY batas_pengumpulan ASC");
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<li>
                    <div class='tugas-title'>" . htmlspecialchars($row['judul']) . "</div>
                    <div class='tugas-deskripsi'>" . nl2br(htmlspecialchars($row['deskripsi'])) . "</div>
                    <div class='tugas-info'>
                        Dibuat: " . htmlspecialchars($row['tanggal_dibuat']) . "<br>
                        Deadline: " . htmlspecialchars($row['batas_pengumpulan']) . "
                    </div>
                  </li>";
        }
    } else {
        echo "<li>Tidak ada tugas tersedia.</li>";
    }
    ?>
    </ul>
</div>

<?php include '../templates/footer.php'; ?>
</body>
</html>
