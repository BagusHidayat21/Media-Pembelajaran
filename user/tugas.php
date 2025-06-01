<?php 
include '../user/user_check.php';
include '../db_connection.php'; 
include '../user/header.php'; 

function formatTanggalIndonesia($tanggal) {
    $bulan = [
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    $tanggalObj = date_create($tanggal);
    $tgl = date_format($tanggalObj, 'd');
    $bln = $bulan[(int)date_format($tanggalObj, 'm')];
    $thn = date_format($tanggalObj, 'Y');
    return "$tgl $bln $thn";
}

if (isset($_GET['status']) && $_GET['status'] === 'berhasil') {
    echo "<div style='background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #c3e6cb;'>
            ✅ Tugas berhasil diunggah!
          </div>";
}
if (isset($_GET['status']) && $_GET['status'] === 'berhasil'): ?>
    <div style="padding:10px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; margin-bottom: 15px;">
        File berhasil diunggah!
    </div>
<?php endif;
?>

<div style="padding: 50px; padding-top: 0px;">
    <h3>Daftar Tugas</h3>

    <table border="1" cellpadding="10" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Tanggal Dibuat</th>
                <th>Deadline</th>
                <th>Unggah Tugas</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $result = $conn->query("SELECT * FROM tugas ORDER BY batas_pengumpulan ASC");
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($row['judul']) . "</td>
                        <td>" . nl2br(htmlspecialchars($row['deskripsi'])) . "</td>
                        <td><span style='font-size: 12px;'>" . formatTanggalIndonesia($row['tanggal_dibuat']) . "</span></td>
                        <td><span style='font-size: 12px;'>" . formatTanggalIndonesia($row['batas_pengumpulan']) . "</span></td>
                        <td>
                            <form action='unggah_tugas.php' method='POST' enctype='multipart/form-data'>
                                <input type='hidden' name='tugas_id' value='" . $row['id'] . "'>
                                <input type='file' name='file_tugas' accept='.pdf,.doc,.docx,.ppt,.pptx,.zip' required>
                                <button type='submit'>Kirim</button>
                            </form>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Tidak ada tugas tersedia.</td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>

</body>
</html>
