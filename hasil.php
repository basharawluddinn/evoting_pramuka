<?php include 'config.php';
if (!isset($_SESSION['siswa'])) {
    header("Location: index.php");
    exit;
}
$siswa = $_SESSION['siswa'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !$siswa['sudah_memilih']) {
    $putra = $_POST['pilih_Putra'];
    $putri = $_POST['pilih_Putri'];

    mysqli_query($conn, "INSERT INTO vote (nis, kandidat_id) VALUES ('$siswa[nis]', '$putra')");
    mysqli_query($conn, "INSERT INTO vote (nis, kandidat_id) VALUES ('$siswa[nis]', '$putri')");
    mysqli_query($conn, "UPDATE siswa SET sudah_memilih=1 WHERE nis='$siswa[nis]'");

    $_SESSION['siswa']['sudah_memilih'] = 1;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Hasil - E-Voting Pramuka</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-batik">
    <div class="container mt-5">
        <div class="alert alert-success text-center">
            Terima kasih, suara Anda sudah disimpan!
        </div>
        <div class="text-center">
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>
</body>

</html>