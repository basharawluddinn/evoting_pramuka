<?php
session_start();
include '../config.php';
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=laporan_evoting.xls");

$total_pemilih = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as jml FROM siswa WHERE sudah_memilih=1"))['jml'];
$total_siswa = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as jml FROM siswa"))['jml'];

echo "<h2>Laporan Hasil E-Voting</h2>";
echo "<p><b>Total Pemilih:</b> $total_pemilih dari $total_siswa siswa (" . ($total_siswa > 0 ? round(($total_pemilih / $total_siswa) * 100, 2) : 0) . "%)</p>";

echo "<table border='1'>
<tr>
  <th>No</th>
  <th>Nama</th>
  <th>Kelas</th>
  <th>Jenis Kelamin</th>
  <th>Jumlah Suara</th>
  <th>Persentase</th>
</tr>";

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
    echo "<tr>
        <td>" . $no++ . "</td>
        <td>" . $r['nama'] . "</td>
        <td>" . $r['kelas'] . "</td>
        <td>" . $r['jenis_kelamin'] . "</td>
        <td>" . $r['total_suara'] . "</td>
        <td>" . $persen . "%</td>
    </tr>";
}
echo "</table>";
exit;
