<?php
include 'config.php';
if (!isset($_SESSION['siswa'])) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Landing Page - E-Voting Pramuka</title>
    <link rel="icon" href="assets/img/rama sinta.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Merriweather', serif;
            background: url('assets/img/batik.png') repeat;
            background-size: cover;
            scroll-behavior: smooth;
        }

        /* Header */
        header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: #FFD700;
            color: black;
            padding: 10px 20px;
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        header img.logo {
            height: 50px;
        }

        .profile {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: bold;
        }

        .profile i {
            font-size: 1.3rem;
        }

        .profile a {
            text-decoration: none;
        }

        .logout-btn {
            background: #dc3545;
            color: white;
            border: none;
            padding: 6px 15px;
            border-radius: 50px;
            font-size: 0.9rem;
            transition: 0.3s;
        }

        .logout-btn:hover {
            background: #39FF14;
        }

        /* Konten */
        .content {
            margin-top: 100px;
        }

        /* Card dengan background */
        .card-custom {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.9);
            /* putih transparan */
            backdrop-filter: blur(5px);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-custom:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }

        /* Footer */
        footer {
            background: #FFD700;
            color: black;
            padding: 40px 20px 20px;
            margin-top: 50px;
        }

        footer ul li a:hover {
            color: red;
        }

        footer ul li a {
            text-decoration: none;
            color: white;
        }

        footer h5 {
            font-weight: bold;
            margin-bottom: 15px;
        }

        .footer-bottom {
            border-top: 1px solid #333;
            margin-top: 20px;
            padding-top: 10px;
            text-align: center;
            font-size: 14px;
        }

        .social-icons a {
            font-size: 1.5rem;
            margin-right: 15px;
            color: black;
            transition: color 0.3s ease;
        }

        .social-icons a:hover {
            color: #5D4037;
        }

        .btn-custom {
            background: #5D4037;
            color: white;
            border-radius: 50px;
            padding: 10px 25px;
        }

        .btn-custom:hover {
            background: #FFD700;
            color: black;
        }

        .dropdown-menu {
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .dropdown i {
            color: black;
        }

        .dropdown button {
            color: black;
            background-color: aliceblue;
            border-color: black;
        }
        .dropdown button:hover {
            border-color: #FFD700;
        }

        .dropdown-item:hover {
            background-color: #FFD700;
        }

        .text-center h2 {
            color: #5D4037;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
        }

        .text-center h5 {
            color: #444;
            margin-top: 10px;
            margin-bottom: 5px;
        }

        .text-center p {
            color: #333;
            font-style: italic;
        }

        /* Section Sambutan */
        .sambutan-section {
            margin-top: 120px;
            /* biar gak ketabrak header */
            background: url('assets/img/cover.jpg') no-repeat center center/cover;
            border-radius: 15px;
            padding: 40px 20px;
        }

        .sambutan-card {
            background: #f5f5f5;
            /* coklat transparan */
            color: white;
            border-radius: 15px;
            backdrop-filter: blur(5px);
        }
    </style>
</head>

<body>

    <!-- Header -->
    <header>

        <div class="d-flex align-items-center">
            <img src="assets/img/rama sinta.png" alt="Logo SMA" class="logo">
            <span class="ms-2 fw-bold">SMA ISLAM TERPADU AULADI ISLAMI</span>
        </div>
        <div class="dropdown">
            <button class="btn btn-outline-light dropdown-toggle d-flex align-items-center" type="button"
                id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person-circle me-2"></i>
                <?= $_SESSION['siswa']['nama'] ?>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                <li><a class="dropdown-item" href="ubah_password.php">Ubah Password</a></li>
                <li><a class="dropdown-item text-danger" href="logout.php">Logout</a></li>
            </ul>
        </div>
    </header>


    <!-- Section Sambutan -->
    <div class="sambutan-section container mt-5">
        <div class="card sambutan-card shadow-lg text-center p-4">
            <h2 class="fw-bold">SELAMAT DATANG DI WEBSITE E-VOTING RAMA-SINTA</h2>
            <h5>PEMILIHAN CALON PRADANA DAN PENGURUS AMBALAN MASA BAKTI 2025/2026</h5>
            <p class="mb-0">AMBALAN SRI RAMA WIJAYA & RAKYAN WARA SINTA</p>
            <p>GUGUS DEPAN 15.247 - 15.248</p>
        </div>
    </div>


    <!-- Konten -->
    <div class="container content">
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <div class="card card-custom shadow-sm">
                    <img src="assets/img/pemilu1.jpg" class="card-img-top" alt="Pemilu">
                    <div class="card-body">
                        <h5 class="card-title">Proses Demokratis</h5>
                        <p class="card-text">Pemilihan dilakukan secara jujur, adil, dan transparan dengan sistem
                            e-voting modern.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card card-custom shadow-sm">
                    <img src="assets/img/pemilu2.jpg" class="card-img-top" alt="Kandidat">
                    <div class="card-body">
                        <h5 class="card-title">Kandidat Terbaik</h5>
                        <p class="card-text">Kandidat berasal dari siswa pilihan dengan visi dan misi membangun pramuka
                            yang lebih baik.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card card-custom shadow-sm">
                    <img src="assets/img/pemilu3.jpg" class="card-img-top" alt="Partisipasi">
                    <div class="card-body">
                        <h5 class="card-title">Partisipasi Siswa</h5>
                        <p class="card-text">Setiap siswa berhak memilih 1 putra dan 1 putri sebagai bentuk kontribusi
                            nyata.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Button Lanjut Memilih -->
        <div class="text-center mt-4">
            <a href="vote.php" class="btn btn-custom">Lanjut Memilih</a>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="row">
            <div class="col-md-4 mb-3">
                <img src="assets/img/logo auladi.png" alt="Logo" style="height: 60px;">
                <p class="mt-2">
                    SMA ISLAM TERPADU AULADI ISLAMI<br>
                    Jl. Balaraja, Sukamanah, Kec. Rajeg, Kabupaten Tangerang, Banten 15540
                </p>
            </div>
            <div class="col-md-4 mb-3">
                <h5>Hubungi Kami</h5>
                <p><i class="bi bi-whatsapp"></i> 0838 9159 5075 (Pembina Putra)</p>
                <p><i class="bi bi-whatsapp"></i> 0857 7648 6817 (Pembina Putri)</p>
                <div class="social-icons">
                    <a href="https://instagram.com" target="_blank"><i class="bi bi-instagram"></i></a>
                    <a href="https://tiktok.com" target="_blank"><i class="bi bi-tiktok"></i></a>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <h5>Tautan</h5>
                <ul class="list-unstyled">
                    <li><a href="https://auladiislami.sch." target="_blank">Website Resmi Auladi</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            SMA ISLAM TERPADU AULADI ISLAMI <br>
            AMBALAN SRI RAMA WIJAYA - RAKYAN WARA SINTA <br> 15.247 - 15.248 <br><br>Copyright &copy; <?= date('Y') ?>
            BASHAR AWALUDDIN NAFSAH
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>