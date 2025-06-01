<?php 
include '../admin/admin_check.php';
include '../db_connection.php'; 
include '../templates/header.php'; 
?>

<style>
.form-container {
    max-width: 500px;
    margin: 30px auto;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 12px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

.form-container h2 {
    text-align: center;
    margin-bottom: 20px;
    color: #333;
}

.form-container input[type="text"],
.form-container input[type="file"] {
    width: 100%;
    padding: 10px;
    margin: 10px 0 20px;
    border: 1px solid #ccc;
    border-radius: 8px;
}

.form-container input[type="submit"] {
    width: 100%;
    background-color: #2575fc;
    color: white;
    padding: 10px;
    border: none;
    border-radius: 8px;
    font-weight: bold;
    cursor: pointer;
    transition: background 0.3s ease;
}

.form-container input[type="submit"]:hover {
    background-color: #1a5edb;
}
</style>

<div class="form-container">
    <h2>Upload Modul Materi</h2>
    <form method="post" enctype="multipart/form-data">
        <input type="text" name="judul" placeholder="Judul Materi" required><br>
        <input type="file" name="file" required><br>
        <input type="submit" name="submit" value="Upload">
    </form>
</div>

<?php
if (isset($_POST['submit'])) {
    $judul = $_POST['judul'];
    $fileName = basename($_FILES["file"]["name"]);
    $targetDir = "../uploads/";
    $targetFile = $targetDir . $fileName;

    // Validasi ekstensi (opsional)
    $allowedTypes = ['pdf','ppt','pptx','doc','docx','xls','xlsx','txt'];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    if (in_array($fileExtension, $allowedTypes)) {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
            $stmt = $conn->prepare("INSERT INTO materi (judul, file) VALUES (?, ?)");
            $stmt->bind_param("ss", $judul, $fileName);
            $stmt->execute();
            header("Location: materi.php");
            exit();
        } else {
            echo "<p style='color:red; text-align:center;'>Gagal mengupload file.</p>";
        }
    } else {
        echo "<p style='color:red; text-align:center;'>Tipe file tidak diizinkan.</p>";
    }
}
?>

<?php include '../templates/footer.php'; ?>
