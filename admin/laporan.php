<?php
include '../config.php';
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

// Hitung total pemilih
$total_pemilih = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as jml FROM siswa WHERE sudah_memilih=1"))['jml'];
$total_siswa = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as jml FROM siswa"))['jml'];
?>

<?php include 'sidebar_header.php'; ?>

<div class="content">
    <h4 class="mb-3">Laporan Hasil E-Voting</h4>

    <div class="mb-3">
        <p><b>Total Pemilih:</b> <?= $total_pemilih ?> dari <?= $total_siswa ?> siswa
            (<?= $total_siswa > 0 ? round(($total_pemilih / $total_siswa) * 100, 2) : 0 ?>%)</p>
    </div>

    <div class="mb-3">
        <a href="export_pdf.php" class="btn btn-danger"><i class="bi bi-file-earmark-pdf"></i> Export PDF</a>
        <a href="export_excel.php" class="btn btn-success"><i class="bi bi-file-earmark-excel"></i> Export Excel</a>
    </div>

    <div class="card">
        <div class="card-header bg-dark text-white">Perolehan Suara Kandidat</div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Jenis Kelamin</th>
                        <th>Jumlah Suara</th>
                        <th>Persentase</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $q = mysqli_query($conn, "
                        SELECT k.*, COUNT(v.id) as total_suara
                        FROM kandidat k
                        LEFT JOIN vote v ON k.id = v.kandidat_id
                        GROUP BY k.id
                        ORDER BY total_suara DESC
                    ");
                    while ($r = mysqli_fetch_assoc($q)) {
                        $persen = $total_pemilih > 0 ? round(($r['total_suara'] / $total_pemilih) * 100, 2) : 0;
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><img src="../assets/img/<?= $r['foto'] ?>" width="60"></td>
                            <td><?= $r['nama'] ?></td>
                            <td><?= $r['kelas'] ?></td>
                            <td><?= $r['jenis_kelamin'] ?></td>
                            <td><?= $r['total_suara'] ?></td>
                            <td><?= $persen ?>%</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>