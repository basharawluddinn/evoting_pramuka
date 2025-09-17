<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Lupa Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="d-flex justify-content-center align-items-center vh-100 bg-batik">
    <div class="card p-4 shadow-lg" style="width: 500px;">
        <h3 class="text-center">Lupa Password</h3>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nis = $_POST['nis'];
            $pass = $_POST['password'];
            $cek = mysqli_query($conn, "SELECT * FROM siswa WHERE nis='$nis'");
            if (mysqli_num_rows($cek) > 0) {
                mysqli_query($conn, "UPDATE siswa SET password='$pass' WHERE nis='$nis'");
                echo "<div class='alert alert-success'>Password berhasil direset, silakan login kembali.</div>";
            } else {
                echo "<div class='alert alert-danger'>NIS tidak ditemukan!</div>";
            }
        }
        ?>
        <form method="post">
            <div class="mb-3">
                <label>NIS</label>
                <input type="text" name="nis" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Password Baru</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button class="btn btn-custom w-100">Reset Password</button>
        </form>
        <div class="text-center mt-3">
            <a href="index.php">Kembali ke Login</a>
        </div>
    </div>
</body>

</html>