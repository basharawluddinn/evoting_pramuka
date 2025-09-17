<?php
include '../config.php';
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
$admin = $_SESSION['admin'];
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - E-Voting</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
    
        /* Content */
        .content {
            margin-left: 240px;
            padding: 80px 20px 20px;
        }

        .card-box {
            border-radius: 10px;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .bg-siswa {
            background: #3498db;
        }

        .bg-kandidat {
            background: #e67e22;
        }

        .bg-admin {
            background: #27ae60;
        }

        .bg-kelas {
            background: #c0392b;
        }
    </style>
</head>

<body>

   <?php
   include 'sidebar_header.php';
   ?>

    <!-- Content -->
    <div class="content">
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card-box bg-siswa shadow">
                    <h3>
                        <?php
                        $siswa = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as jml FROM siswa"));
                        echo $siswa['jml'];
                        ?>
                    </h3>
                    <p>SISWA</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card-box bg-kandidat shadow">
                    <h3>
                        <?php
                        $kandidat = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as jml FROM kandidat"));
                        echo $kandidat['jml'];
                        ?>
                    </h3>
                    <p>KANDIDAT</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card-box bg-admin shadow">
                    <h3>
                        <?php
                        $adm = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as jml FROM admin"));
                        echo $adm['jml'];
                        ?>
                    </h3>
                    <p>ADMIN</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card-box bg-kelas shadow">
                    <h3>
                        <?php
                        $kelas = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(DISTINCT kelas) as jml FROM siswa"));
                        echo $kelas['jml'];
                        ?>
                    </h3>
                    <p>KELAS</p>
                </div>
            </div>
        </div>

        <!-- Statistik -->
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card shadow p-3">
                    <h5 class="text-center">Perolehan Suara Kandidat</h5>
                    <canvas id="chartVote"></canvas>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card shadow p-3">
                    <h5 class="text-center">Jumlah Pemilih per Kelas</h5>
                    <canvas id="chartKelas"></canvas>
                </div>
            </div>
        </div>
    </div>

    <?php
    // Statistik jumlah vote per kandidat
    $q1 = mysqli_query($conn, "SELECT k.nama, COUNT(v.id) as total FROM kandidat k 
                           LEFT JOIN vote v ON k.id=v.kandidat_id GROUP BY k.id");
    $labels1 = [];
    $data1 = [];
    while ($r = mysqli_fetch_assoc($q1)) {
        $labels1[] = $r['nama'];
        $data1[] = $r['total'];
    }

    // Statistik jumlah siswa memilih per kelas
    $q2 = mysqli_query($conn, "SELECT kelas, COUNT(*) as total FROM siswa WHERE sudah_memilih=1 GROUP BY kelas");
    $labels2 = [];
    $data2 = [];
    while ($r = mysqli_fetch_assoc($q2)) {
        $labels2[] = $r['kelas'];
        $data2[] = $r['total'];
    }
    ?>

    <script>
        new Chart(document.getElementById('chartVote'), {
            type: 'bar',
            data: {
                labels: <?= json_encode($labels1) ?>,
                datasets: [{
                    label: 'Jumlah Suara',
                    data: <?= json_encode($data1) ?>,
                    backgroundColor: '#3498db'
                }]
            }
        });

        new Chart(document.getElementById('chartKelas'), {
            type: 'pie',
            data: {
                labels: <?= json_encode($labels2) ?>,
                datasets: [{
                    label: 'Jumlah Pemilih per Kelas',
                    data: <?= json_encode($data2) ?>,
                    backgroundColor: ['#3498db', '#e67e22', '#27ae60', '#c0392b']
                }]
            }
        });
    </script>
</body>

</html>