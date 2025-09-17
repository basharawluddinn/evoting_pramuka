<?php
include 'config.php';
if (!isset($_SESSION['siswa'])) {
    header("Location: index.php");
    exit;
}

$pesan = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nis = $_SESSION['siswa']['nis'];
    $password_lama = $_POST['password_lama'];
    $password_baru = $_POST['password_baru'];
    $konfirmasi = $_POST['konfirmasi'];

    // cek password lama
    $cek = mysqli_query($conn, "SELECT * FROM siswa WHERE nis='$nis' AND password='$password_lama'");
    if (mysqli_num_rows($cek) == 0) {
        $pesan = "<div class='alert alert-danger'>Password lama salah!</div>";
    } elseif ($password_baru != $konfirmasi) {
        $pesan = "<div class='alert alert-warning'>Password baru dan konfirmasi tidak sama!</div>";
    } else {
        mysqli_query($conn, "UPDATE siswa SET password='$password_baru' WHERE nis='$nis'");
        $pesan = "<div class='alert alert-success'>Password berhasil diubah!</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Ubah Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <div class="card p-4 shadow-lg" style="width: 400px;">
        <h4 class="mb-3 text-center">Ubah Password</h4>
        <?= $pesan ?>
        <form method="post">
            <div class="mb-3">
                <label>Password Lama</label>
                <input type="password" name="password_lama" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Password Baru</label>
                <input type="password" name="password_baru" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Konfirmasi Password Baru</label>
                <input type="password" name="konfirmasi" class="form-control" required>
            </div>
            <button class="btn btn-primary w-100">Simpan Perubahan</button>
        </form>
        <div class="text-center mt-3">
            <a href="landing.php">Kembali</a>
        </div>
    </div>
</body>

</html>