<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Register Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('assets/img/batik.png') repeat;
            background-size: cover;
            font-family: 'Merriweather', serif;
        }

        .card-register {
            background: linear-gradient(145deg, #ffffff, #f5f5f5);
            border-radius: 20px;
            box-shadow: 10px 10px 25px rgba(0, 0, 0, 0.3),
                -8px -8px 20px rgba(255, 255, 255, 0.6);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-register:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 12px 12px 30px rgba(0, 0, 0, 0.4),
                -12px -12px 25px rgba(255, 255, 255, 0.7);
        }

        .btn-custom {
            background: linear-gradient(145deg, #5D4037, #8D6E63);
            color: white;
            font-weight: bold;
            border-radius: 50px;
            transition: all 0.3s ease;
        }

        .btn-custom:hover {
            background: linear-gradient(145deg, #FFD700, #A1887F);
            color: black;
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.4);
        }
    </style>
</head>

<body class="d-flex justify-content-center align-items-center vh-100">
    <div class="card card-register p-4 shadow-lg" style="width: 500px;">
        <h3 class="text-center mb-4">Registrasi Siswa</h3>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nis = $_POST['nis'];
            $nama = $_POST['nama'];
            $kelas = $_POST['kelas'];
            $password = $_POST['password'];

            $cek = mysqli_query($conn, "SELECT nis FROM siswa WHERE nis='$nis'");
            if (mysqli_num_rows($cek) > 0) {
                echo "<div class='alert alert-warning'>⚠️ NIS sudah terdaftar!</div>";
            } else {
                mysqli_query($conn, "INSERT INTO siswa (nis,nama,kelas,password) VALUES ('$nis','$nama','$kelas','$password')");
                echo "<div class='alert alert-success'>✅ Registrasi berhasil, silakan login.</div>";
            }
        }
        ?>
        <form method="post">
            <div class="mb-3">
                <label>NIS</label>
                <input type="text" name="nis" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Kelas</label>
                <input type="text" name="kelas" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button class="btn btn-custom w-100">Daftar</button>
        </form>
        <div class="text-center mt-3">
            <a href="index.php" class="text-muted">⬅ Kembali ke Login</a>
        </div>
    </div>
</body>

</html>