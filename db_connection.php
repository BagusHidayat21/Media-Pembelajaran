<?php
$host = "sql12.freesqldatabase.com";         
$username = "sql12782454";          
$password = "zu1ZaZxuf3";              
$database = "sql12782454";    
$port = 3306;

// Membuat koneksi
$conn = new mysqli($host, $username, $password, $database, $port);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

?>
