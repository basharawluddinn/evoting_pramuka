<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

include '../config.php';

// Cek isi session admin
if (is_array($_SESSION['admin'])) {
    // Kalau session menyimpan array (misalnya seluruh data admin)
    $id_admin = $_SESSION['admin']['id'];
} else {
    // Kalau session hanya menyimpan id admin
    $id_admin = $_SESSION['admin'];
}

// Ambil data admin dari database
$query = mysqli_query($conn, "SELECT * FROM admin WHERE id='$id_admin'");
$dataAdmin = mysqli_fetch_assoc($query);

// Tentukan path foto
if (!empty($dataAdmin['foto'])) {
    $foto = '../assets/img/' . $dataAdmin['foto'];
} else {
    $foto = '../assets/img/default.png';
}


?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Panel Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f6f9;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 240px;
            background: #2c3e50;
            color: white;
            padding-top: 20px;
        }

        .sidebar h3 {
            text-align: center;
            margin-bottom: 30px;
            font-weight: bold;
        }

        .sidebar a {
            display: block;
            padding: 12px 20px;
            color: white;
            text-decoration: none;
            transition: background 0.3s;
        }

        .sidebar a:hover {
            background: #1a252f;
        }

        .sidebar a.active {
            background: #16a085;
        }

        /* Header */
        .header {
            margin-left: 240px;
            padding: 15px 25px;
            background: #16a085;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header .profile {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .header .profile img {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #fff;
        }

        /* Content */
        .content {
            margin-left: 240px;
            padding: 25px;
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h3>PRAMUKA <br>RAMA SINTA</h3>
        <a href="dashboard.php" class="<?= basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : '' ?>"><i
                class="bi bi-speedometer2"></i> Dashboard</a>
        <a href="admin.php" class="<?= basename($_SERVER['PHP_SELF']) == 'admin.php' ? 'active' : '' ?>"><i
                class="bi bi-person-badge"></i> Admin</a>
        <a href="kandidat.php" class="<?= basename($_SERVER['PHP_SELF']) == 'kandidat.php' ? 'active' : '' ?>"><i
                class="bi bi-person-lines-fill"></i> Kandidat</a>
        <a href="siswa.php" class="<?= basename($_SERVER['PHP_SELF']) == 'siswa.php' ? 'active' : '' ?>"><i
                class="bi bi-person"></i> Siswa</a>
        <a href="statistik.php" class="<?= basename($_SERVER['PHP_SELF']) == 'statistik.php' ? 'active' : '' ?>"><i
                class="bi bi-people"></i> Statistik</a>
        <a href="laporan.php" class="<?= basename($_SERVER['PHP_SELF']) == 'laporan.php' ? 'active' : '' ?>"><i
                class="bi bi-file-earmark-text"></i> Laporan</a>
        <a href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>

    <!-- Header -->
    <div class="header">
        <h4>Dashboard Admin</h4>
        <div class="profile">
            <img src="<?= $foto ?>" alt="Foto Admin">
            <span><?= $dataAdmin['username'] ?></span>
        </div>
    </div>