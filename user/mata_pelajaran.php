<?php
include '../user/header.php'; 
include '../db_connection.php'; 

// Ambil data dari database
$query = "SELECT * FROM mata_pelajaran";
$result = $conn->query($query);  

$mata_pelajaran = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $mata_pelajaran[] = $row;
    }
}
?>

<div style="padding: 50px; padding-top: 0px;">
    <h2>Daftar Mata Pelajaran</h2>
    <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
        <thead>
            <tr style="background-color: #f1f1f1;">
                <th style="padding: 12px; border-bottom: 1px solid #ddd;">Kode</th>
                <th style="padding: 12px; border-bottom: 1px solid #ddd;">Nama Mata Pelajaran</th>
                <th style="padding: 12px; border-bottom: 1px solid #ddd;">Guru</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($mata_pelajaran)): ?>
                <?php foreach ($mata_pelajaran as $mp): ?>
                    <tr>
                        <td style="padding: 12px; border-bottom: 1px solid #ddd;"><?= htmlspecialchars($mp["kode"]) ?></td>
                        <td style="padding: 12px; border-bottom: 1px solid #ddd;"><?= htmlspecialchars($mp["nama_pelajaran"]) ?></td>
                        <td style="padding: 12px; border-bottom: 1px solid #ddd;"><?= htmlspecialchars($mp["guru"]) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" style="padding: 12px; border-bottom: 1px solid #ddd;">Tidak ada data mata pelajaran.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include '../user/footer.php'; ?>
