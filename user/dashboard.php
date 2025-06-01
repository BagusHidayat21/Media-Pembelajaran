<?php
include '../user/user_check.php';
include '../user/header.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: ../login.php");
    exit();
}

include '../db_connection.php'; // jangan lupa koneksi DB

date_default_timezone_set('Asia/Jakarta');
$today = date("l, d F Y");

// Ambil tugas dengan deadline dari hari ini ke depan, urutkan berdasarkan tanggal deadline (limit 5)
$query = "SELECT judul, batas_pengumpulan FROM tugas WHERE batas_pengumpulan >= CURDATE() ORDER BY batas_pengumpulan ASC LIMIT 5";
$result = $conn->query($query);
?>

<div style="padding: 50px; padding-top: 0px;">
    <h2>Dashboard</h2>
    <p>Selamat datang di <strong>AccuLearn</strong>, platform pembelajaran yang dirancang untuk mendukung proses belajar Anda dengan materi yang interaktif dan mudah diakses.</p>
    <p>Hari ini: <?= $today; ?></p>
</div>

<!-- Deadline Tugas Mendekat -->
<div class="card" style="padding: 50px; padding-top: 0px;">
    <h3>Deadline Tugas Mendekat</h3>
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background-color: #f0f0f0;">
                <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Judul Tugas</th>
                <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Deadline</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td style="padding: 10px; border: 1px solid #ddd;"><?= htmlspecialchars($row['judul']) ?></td>
                        <td style="padding: 10px; border: 1px solid #ddd;">
                            <?= date('d F Y', strtotime($row['batas_pengumpulan'])) ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="2" style="padding: 10px; border: 1px solid #ddd; text-align: center;">Tidak ada tugas dengan deadline mendekat.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include '../user/footer.php'; ?>
