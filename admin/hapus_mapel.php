<?php 
include '../admin/admin_check.php';
include '../db_connection.php';

$id = intval($_GET['id'] ?? 0);

if ($id > 0) {
    $stmt = $conn->prepare("DELETE FROM mata_pelajaran WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

header("Location: mata_pelajaran.php");
exit();
