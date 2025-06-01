<?php 
include '../user/user_check.php'; 
include '../db_connection.php'; 
include '../user/header.php'; 
?>

<style>
.add-button {
    display: inline-block;
    background-color: #2575fc;
    color: #fff;
    padding: 10px 16px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: bold;
    margin-bottom: 30px;
    transition: background 0.3s ease;
}
.add-button:hover {
    background-color: #1a5edb;
}

.card-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
}

.card {
    background-color: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    padding: 20px;
    border-left: 5px solid #2575fc;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.card h4 {
    margin: 0 0 10px;
    font-size: 18px;
    color: #333;
}

.card embed {
    width: 100%;
    height: 220px;
    border-radius: 6px;
    border: 1px solid #ccc;
    margin-bottom: 10px;
}

.card .file-icon {
    font-size: 50px;
    margin-bottom: 15px;
    text-align: center;
    color: #2575fc;
}

.card .btn-download {
    text-align: center;
    margin-top: auto;
}

.card a {
    display: inline-block;
    background-color: #2575fc;
    color: #fff;
    padding: 8px 14px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    transition: background 0.3s ease;
}
.card a:hover {
    background-color: #1a5edb;
}

@media (max-width: 992px) {
    .card-grid {
        grid-template-columns: repeat(2, 1fr); /* 2 kolom untuk tablet */
    }
}

@media (max-width: 600px) {
    .card-grid {
        grid-template-columns: 1fr; /* 1 kolom untuk mobile */
    }
}
</style>

<div style="padding: 50px; padding-top: 0px;">
    <h3>Daftar Modul Materi</h3>

    <div class="card-grid">
        <?php
        $result = $conn->query("SELECT * FROM materi");
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $judul = htmlspecialchars($row['judul']);
                $file = htmlspecialchars($row['file']);
                $filePath = "../uploads/$file";
                $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));

                echo "<div class='card'>";
                echo "<h4>$judul</h4>";

                if ($extension === 'pdf') {
                    echo "<embed src='$filePath' type='application/pdf'>";
                    echo "<div class='btn-download'><a href='$filePath' target='_blank'>Lihat / Unduh</a></div>";
                } else {
                    $icon = "📄"; // default
                    if (in_array($extension, ['ppt', 'pptx'])) $icon = "📊";
                    if (in_array($extension, ['doc', 'docx'])) $icon = "📝";
                    if (in_array($extension, ['xls', 'xlsx'])) $icon = "📈";
                    if (in_array($extension, ['zip', 'rar'])) $icon = "🗜️";

                    echo "<div class='file-icon'>$icon</div>";
                    echo "<div class='btn-download'><a href='$filePath' target='_blank'>Unduh File</a></div>";
                }

                echo "</div>";
            }
        } else {
            echo "<p>Tidak ada materi tersedia.</p>";
        }
        ?>
    </div>
</div>

<?php include '../templates/footer.php'; ?>
