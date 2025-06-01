<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>AccuLearn</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            background-color: #f5f5f5;
        }

        .sidebar {
            width: 220px;
            background-color: #d33a2c;
            color: white;
            height: 100vh;
            position: fixed;
            padding: 20px;
        }

        .sidebar a:hover {
            background-color: white;
            color: #d33a2c;
            padding-left: 30px;
            border-radius: 5px;
            transition: all 0.2s ease-in-out;
        }

        .sidebar a:hover i {
            color: #d33a2c;
        }

        .sidebar .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 30px;
        }

        .sidebar .logo img {
            height: 40px;
            border-radius: 8px;
        }

        .sidebar h2 {
            font-size: 18px;
        }

        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            margin-bottom: 12px; /* Spasi antar menu */
            padding: 10px;
            border-radius: 6px;
            transition: all 0.2s ease-in-out;
        }

        .main-content {
            margin-left: 240px; 
        }

        .top-navbar {
            position: sticky;
            top: 0;
            z-index: 999;
            background-color: #d33a2c;
            padding: 15px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 0px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .top-navbar .nav-left span {
            font-size: 25px;
            color: white;
            font-weight: 550;
        }

        .card {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
        }

        .card h3 {
            color: #d33a2c;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            padding: 10px 15px;
            text-align: left;
        }

        th {
            background-color: #e7f0fd;
            color: #007bff;
        }

        tr:nth-child(even) {
            background-color: #f2f6fc;
        }

        .logo strong {
            font-size: 25px;
            font-weight: bold;
            color: white;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <img src="../assets/img/logo.png" alt="Logo">
            <strong>AccuLearn</strong>
        </div>
        <h2><?= htmlspecialchars($_SESSION['username'] ?? 'Guest'); ?><br><small>User</small></h2>
        <hr>
        <a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
        <a href="mata_pelajaran.php"><i class="fas fa-book"></i> Mata Pelajaran</a>
        <a href="materi.php"><i class="fas fa-file-alt"></i> Materi</a>
        <a href="tugas.php"><i class="fas fa-tasks"></i> Tugas</a>
        <a href="absensi.php"><i class="fas fa-calendar-check"></i> Absensi</a>
        <a href="../logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <div class="main-content">
        <!-- Top Navbar -->
        <div class="top-navbar">
            <div class="nav-left">
                <span>Media Pembelajaran</span>
            </div>
        </div>
