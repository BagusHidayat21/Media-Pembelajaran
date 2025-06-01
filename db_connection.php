<?php
$host = "localhost";         
$username = "root";          
$password = "";              
$database = "e_learning";    

// Membuat koneksi
$conn = new mysqli($host, $username, $password, $database);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

?>
