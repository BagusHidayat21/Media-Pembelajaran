<?php 
include '../admin/admin_check.php'; 
include '../db_connection.php'; 
include '../templates/header.php'; 
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Absensi Digital</title>
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f6f9;
        }

        .absen-container {
            max-width: 900px;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        .absen-container h3 {
            text-align: center;
            margin-bottom: 25px;
            font-size: 24px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th, table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }

        table th {
            background-color: #f1f1f1;
            color: #333;
        }

        select, input[type="checkbox"] {
            padding: 6px;
            font-size: 14px;
        }

        input[type="submit"] {
            padding: 12px 20px;
            background-color: #2575fc;
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
            display: block;
            margin: auto;
            transition: background 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #1a5edb;
        }
    </style>
</head>
<body>

<div class="absen-container">
    <h3>Absensi Digital</h3>
    
    <form method="post" action="proses_absensi_admin.php">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Nama Lengkap</th>
                    <th>Hadir</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $query = $conn->query("SELECT * FROM absensi ORDER BY tanggal DESC");
            $no = 1;
            while ($row = $query->fetch_assoc()) {
                echo "<tr>
                    <td>{$no}</td>
                    <td>".htmlspecialchars($row['username'])."</td>
                    <td>".htmlspecialchars($row['nama'])."</td>
                    <td><input type='checkbox' name='hadir[]' value='{$row['username']}'></td>
                    <td>
                        <select name='keterangan[{$row['username']}]'>
                            <option value=''>-</option>
                            <option value='Sakit'>Sakit</option>
                            <option value='Izin'>Izin</option>
                            <option value='Alpha'>Alpha</option>
                        </select>
                    </td>
                </tr>";
                $no++;
            }
            ?>
            </tbody>
        </table>
        <input type="submit" name="submit" value="Simpan Absensi">
    </form>
</div>

<?php include '../templates/footer.php'; ?>
<?php if (isset($_GET['success'])): ?>
<script>
    alert("Absensi berhasil disimpan!");
</script>
<?php endif; ?>

<?php if (isset($_GET['success'])): ?>
<div id="popup-success" style="
    position: fixed;
    top: 20px;
    right: 20px;
    background-color: #4caf50;
    color: white;
    padding: 15px 20px;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    z-index: 9999;
    font-family: Arial, sans-serif;
">
    ✅ Absensi berhasil disimpan!
</div>
<script>
    setTimeout(() => {
        const popup = document.getElementById('popup-success');
        if (popup) popup.remove();
    }, 3000); // hilang dalam 3 detik
</script>
<?php endif; ?>

</body>
</html>
