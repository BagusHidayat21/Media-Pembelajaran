<?php
include '../admin/admin_check.php';
include '../templates/header.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
?>

<h2>Dashboard Admin</h2>
<p>Selamat datang di panel admin. Silakan pilih menu di sebelah kiri untuk mengelola konten.</p>

<?php include '../templates/footer.php'; ?>
