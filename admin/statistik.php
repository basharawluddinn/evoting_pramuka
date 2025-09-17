<?php
include '../config.php';
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Statistik Pemilih</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }

        .main-content {
            margin-left: 260px;
            /* lebar sidebar */
            padding: 20px;
        }

        .card h3 {
            font-weight: bold;
        }

        .card {
    border-radius: 12px;
    min-height: 150px; /* biar rata tingginya */
}

    </style>
</head>

<body>
    <?php include 'sidebar_header.php'; ?>

    <div class="main-content">
        <div class="container-fluid">
            <h2 class="mb-4 text-center">📊 Statistik Pemilih</h2>

            <?php
            // Hitung total siswa, sudah memilih, dan belum memilih
            $total = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as jml FROM siswa"))['jml'];
            $sudah = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as jml FROM siswa WHERE sudah_memilih=1"))['jml'];
            $belum = $total - $sudah;
            $persentase = $total > 0 ? round(($sudah / $total) * 100, 2) : 0;
            ?>

            <!-- Ringkasan -->
<div class="row mb-4 text-center g-3">
    <div class="col-md-3">
        <div class="card shadow-sm border-success h-100">
            <div class="card-body d-flex flex-column justify-content-center">
                <h5 class="text-success">Total Siswa</h5>
                <h3><?= $total ?></h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm border-primary h-100">
                        <div class="card-body d-flex flex-column justify-content-center">
                            <h5 class="text-primary">Sudah Memilih</h5>
                            <h3><?= $sudah ?></h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm border-danger h-100">
                        <div class="card-body d-flex flex-column justify-content-center">
                            <h5 class="text-danger">Belum Memilih</h5>
                            <h3><?= $belum ?></h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm border-warning h-100">
                        <div class="card-body d-flex flex-column justify-content-center">
                            <h5 class="text-warning">Partisipasi</h5>
                            <h3><?= $persentase ?>%</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel Statistik -->
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">Daftar Siswa & Status Memilih</div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-dark text-center">
                            <tr>
                                <th>No</th>
                                <th>NIS</th>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $q = mysqli_query($conn, "SELECT * FROM siswa ORDER BY kelas,nama");
                            while ($r = mysqli_fetch_assoc($q)) {
                                $status = $r['sudah_memilih']
                                    ? "<span class='badge bg-success'>Sudah Memilih</span>"
                                    : "<span class='badge bg-danger'>Belum Memilih</span>";
                                echo "<tr>
                                        <td class='text-center'>{$no}</td>
                                        <td>{$r['nis']}</td>
                                        <td>{$r['nama']}</td>
                                        <td>{$r['kelas']}</td>
                                        <td class='text-center'>{$status}</td>
                                      </tr>";
                                $no++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</body>

</html>