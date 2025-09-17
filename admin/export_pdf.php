<?php
session_start();
include '../config.php';
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

// Load Dompdf manual (pastikan folder dompdf/ ada di project root)
require '../dompdf/autoload.inc.php';
use Dompdf\Dompdf;

$total_pemilih = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as jml FROM siswa WHERE sudah_memilih=1"))['jml'];
$total_siswa = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as jml FROM siswa"))['jml'];

$html = '
<h2 style="text-align:center;">Laporan Hasil E-Voting</h2>
<p><b>Total Pemilih:</b> ' . $total_pemilih . ' dari ' . $total_siswa . ' siswa (' . ($total_siswa > 0 ? round(($total_pemilih / $total_siswa) * 100, 2) : 0) . '%)</p>
<table border="1" cellspacing="0" cellpadding="6" width="100%">
<thead>
<tr>
  <th>No</th>
  <th>Nama</th>
  <th>Kelas</th>
  <th>Jenis Kelamin</th>
  <th>Jumlah Suara</th>
  <th>Persentase</th>
</tr>
</thead>
<tbody>';

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
    $html .= '
    <tr>
        <td>' . $no++ . '</td>
        <td>' . $r['nama'] . '</td>
        <td>' . $r['kelas'] . '</td>
        <td>' . $r['jenis_kelamin'] . '</td>
        <td>' . $r['total_suara'] . '</td>
        <td>' . $persen . '%</td>
    </tr>';
}
$html .= '</tbody></table>';

/// Tambahan tanda tangan
$html .= '
<br><br><br>
<table width="100%" style="text-align:center; border:0;">
  <tr>
    <td colspan="4"><b>Mengetahui</b></td>
  </tr>
  <tr>
    <td>Pembina Putra</td>
    <td>Pembina Putri</td>
    <td>Ka Gudep Putra</td>
    <td>Ka Gudep Putri</td>
  </tr>
  <tr><td colspan="4" height="70px"></td></tr>
  <tr>
    <td>Muhammad Mufthi Fadhli, S.Pd.</td>
    <td>Vena Juwita, S.Pd.</td>
    <td>Biyan Muda Intan, S.Sos.</td>
    <td>Dessy Fitriani, S.Pd.</td>
  </tr>
</table>

<br><br>
<table width="100%" style="text-align:center; border:0;">
  <tr>
    <td><b>Menyetujui</b></td>
  </tr>
  <tr>
    <td><b>Ka Mabigus</b></td>
  </tr>
  <tr><td height="70px"></td></tr>
  <tr>
    <td>Ahmad Suaepi, M.Pd.</td>
  </tr>
</table>
';


// Generate PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("laporan_evoting.pdf", ["Attachment" => true]);
exit;
