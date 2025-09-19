<?php
include 'config.php';
if (!isset($_SESSION['siswa'])) {
    header("Location: index.php");
    exit;
}
$siswa = $_SESSION['siswa'];

// Cek kalau siswa sudah memilih
if ($siswa['sudah_memilih']) {
    header("Location: hasil.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Pilih Kandidat Putra & Putri - E-Voting Pramuka</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
    body {
        font-family: 'Merriweather', serif;
        background: url('assets/img/batik.png') repeat;
        background-size: cover;
    }

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

    .container {
        margin-top: 130px;
    }

    /* Judul Utama */
    .judul-utama {
        background-color: #626F78;
        padding: 20px;
        border-radius: 15px;
        text-align: center;
        margin-bottom: 40px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .judul-utama h2 {
        font-weight: bold;
        color: #fff;
        line-height: 1.6;
    }

    /* Card Kandidat */
    .card-kandidat {
        border-radius: 12px;
        overflow: hidden;
        transition: 0.3s;
        background: #fff;
    }

    .card-kandidat:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
    }

    .foto-kandidat {
        width: 100%;
        height: auto;
        border-bottom: 1px solid #eee;
    }

    .card-body {
        text-align: center;
    }

    .radio-container {
        text-align: center;
        margin: 10px 0 15px;
    }

    /* Heading Kandidat dengan BG */
    .judul-section {
        text-align: center;
        font-weight: bold;
        color: #fff;
        text-transform: uppercase;
        margin: 50px 0 30px;
        background: #626F78;
        padding: 12px;
        border-radius: 10px;
    }

    /* Footer */
    footer {
        text-align: center;
        padding: 20px;
        margin-top: 40px;
        background: #FFD700;
        color: black;
        font-size: 14px;
        border-radius: 10px 10px 0 0;
    }

    .btn-vote {
        border-radius: 50px;
        padding: 10px 30px;
        font-weight: bold;
    }

    .btn-back {
        border-radius: 50px;
        padding: 10px 30px;
        font-weight: bold;
    }

    .dropdown button {
        color: black;
        background-color: aliceblue;
        border-color: black;
    }

    .dropdown button:hover {
        border-color: #FFD700;
    }

    /* Tambah jarak tombol submit */
    .action-buttons {
        margin-top: 50px;
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

    <!-- Konten -->
    <div class="container">

        <!-- Judul Utama -->
        <div class="judul-utama">
            <h2>
                KANDIDAT PUTRA & PUTRI <br>
                CALON PRADANA MASA BHAKTI 2025/2026 <br>
                AMBALAN SRI RAMA WIJAYA - RAKYAN WARA SINTA <br>
                GUGUS DEPAN 15.247 - 15.248
            </h2>
        </div>

        <form method="post" action="hasil.php" id="voteForm">
            <!-- Kandidat Putra -->
            <h4 class="judul-section">KANDIDAT PUTRA</h4>
            <div class="row">
                <?php
                $putra = mysqli_query($conn, "SELECT * FROM kandidat WHERE jenis_kelamin='Putra'");
                while ($row = mysqli_fetch_assoc($putra)) { ?>
                    <div class="col-12 col-md-6 col-lg-3 mb-4">
                        <div class="card card-kandidat shadow-sm h-100">
                            <img src="assets/img/<?= $row['foto'] ?>" class="foto-kandidat" alt="Foto <?= $row['nama'] ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= $row['nama'] ?> <br><small>(<?= $row['kelas'] ?>)</small></h5>
                                <p><b>Visi:</b> <?= $row['visi'] ?></p>
                                <p><b>Misi:</b> <?= $row['misi'] ?></p>
                            </div>
                            <div class="radio-container">
                                <input type="radio" name="pilih_putra" value="<?= $row['id'] ?>" required>
                                <label>Pilih</label>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <!-- Kandidat Putri -->
            <h4 class="judul-section">KANDIDAT PUTRI</h4>
            <div class="row">
                <?php
                $putri = mysqli_query($conn, "SELECT * FROM kandidat WHERE jenis_kelamin='Putri'");
                while ($row = mysqli_fetch_assoc($putri)) { ?>
                    <div class="col-12 col-md-6 col-lg-3 mb-4">
                        <div class="card card-kandidat shadow-sm h-100">
                            <img src="assets/img/<?= $row['foto'] ?>" class="foto-kandidat" alt="Foto <?= $row['nama'] ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= $row['nama'] ?> <br><small>(<?= $row['kelas'] ?>)</small></h5>
                                <p><b>Visi:</b> <?= $row['visi'] ?></p>
                                <p><b>Misi:</b> <?= $row['misi'] ?></p>
                            </div>
                            <div class="radio-container">
                                <input type="radio" name="pilih_putri" value="<?= $row['id'] ?>" required>
                                <label>Pilih</label>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <!-- Tombol Submit & Kembali -->
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-success btn-vote me-2">Kirim Pilihan</button>
                <a href="landing.php" class="btn btn-secondary btn-back">Kembali</a>
            </div>
        </form>
    </div>

    <!-- Footer -->
    <footer>
        &copy; <?= date('Y') ?> SMA Islam Terpadu Auladi Islami - E-Voting Rama Sinta <br> &copy; author : Bashar Awaluddin Nafsah
    </footer>

    <!-- Konfirmasi sebelum submit -->
    <script>
        document.getElementById("voteForm").addEventListener("submit", function (event) {
            let konfirmasi = confirm("Apakah Anda yakin dengan pilihan ini?\nSetelah dikirim, pilihan tidak bisa diubah lagi.");
            if (!konfirmasi) {
                event.preventDefault();
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>