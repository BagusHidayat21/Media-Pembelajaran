<?php 
include '../admin/admin_check.php'; 
include '../db_connection.php'; 
include '../templates/header.php'; 
?>

<style>
.mapel h3 {
    color: #333;
    font-size: 22px;
    margin-bottom: 20px;
}

.mapel a.add-button {
    display: inline-block;
    background-color: #2575fc;
    color: #fff;
    padding: 8px 14px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: bold;
    transition: background 0.3s ease;
    margin-bottom: 20px;
}
.mapel a.add-button:hover {
    background-color: #1a5edb;
}

.mapel-list {
    list-style: none;
    padding-left: 0;
    display: block; 
    grid-template-columns: repeat(3, 1fr); /* 3 kolom */
    gap: 15px;
}
.mapel-list li {
    background-color: #f7f7f7;
    padding: 16px 20px;
    margin-bottom: 12px;
    border-radius: 8px;
    border-left: 4px solid #2575fc;
    font-weight: 500;
    width: 100%;
    box-sizing: border-box;
    line-height: 1.4;
    display: block;
    align-items: center;
    justify-content: space-between;
}

.mapel-list li .info {
    flex-grow: 1;
}

.mapel-list li small {
    color: #666;
    display: block;
    margin-top: 5px;
}

/* Container tombol edit & hapus */
.mapel-list li .actions {
    display: flex;
    gap: 10px;
}

/* Style tombol icon */
.mapel-list li .actions a {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 30px;
    height: 30px;
    background-color: #2575fc;
    color: white;
    border-radius: 6px;
    text-decoration: none;
    font-size: 16px;
    font-weight: bold;
    transition: background-color 0.3s ease;
}
.mapel-list li .actions a:hover {
    background-color: #1a5edb;
}
</style>

<div class="mapel">
    <h3>Daftar Mata Pelajaran</h3>
    <a href="tambah_mapel.php" class="add-button">+ Tambah Mata Pelajaran</a>

    <ul class="mapel-list">
        <?php
        $result = $conn->query("SELECT * FROM mata_pelajaran ORDER BY id DESC");

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $id = $row['id'];
                $kode = htmlspecialchars($row['kode']);
                $namaMapel = htmlspecialchars($row['nama_pelajaran']);
                $guru = htmlspecialchars($row['guru']);

                echo "<li>
                    <div class='info'>
                        <strong>$kode</strong> - $namaMapel<br>
                        <small>Guru: $guru</small>
                    </div>
                    <div class='actions'>
                        <a href='edit_mapel.php?id=$id' title='Edit'>&#9998;</a>
                        <a href='hapus_mapel.php?id=$id' title='Hapus' onclick=\"return confirm('Yakin hapus data ini?')\">&#128465;</a>
                    </div>
                </li>";
            }
        } else {
            echo "<li>Tidak ada data mata pelajaran.</li>";
        }
        ?>
    </ul>
</div>

<?php include '../templates/footer.php'; ?>
