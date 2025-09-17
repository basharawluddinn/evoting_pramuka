<?php
include 'config.php';

// ⚠️ bagian hash password sebaiknya dipisah ke file terpisah (hash_password_siswa.php)
// jangan ditaruh di login, supaya tidak jalan setiap kali login
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login Siswa - E-Voting Pramuka</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            background: url('assets/img/batik.png') repeat;
            background-size: cover;
            font-family: 'Merriweather', serif;
        }

        .card-login {
            background: linear-gradient(145deg, #fdfdfd, #f1f1f1);
            border-radius: 20px;
            border: none;
            box-shadow: 8px 8px 20px rgba(0, 0, 0, 0.3),
                -8px -8px 20px rgba(255, 255, 255, 0.5);
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        .card-login:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 12px 12px 25px rgba(0, 0, 0, 0.4),
                -10px -10px 25px rgba(255, 255, 255, 0.7);
        }

        .btn-custom {
            background-color: #5D4037;
            color: white;
            font-weight: bold;
            border-radius: 50px;
            transition: all 0.3s ease;
        }

        .btn-custom:hover {
            background-color: #FFD700;
            color: black;
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .btn-admin {
            background: linear-gradient(145deg, #8D6E63, #5D4037);
            color: white;
            border-radius: 50px;
            margin-top: 10px;
            transition: all 0.3s ease;
        }

        .btn-admin:hover {
            background: linear-gradient(145deg, #FFD700, #A1887F);
            color: black;
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.4);
        }
    </style>
</head>

<body class="d-flex justify-content-center align-items-center vh-100">
    <div class="card card-login p-4 shadow-lg" style="width: 400px;">
        <h3 class="text-center text-dark mb-3">Login Siswa</h3>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $u = mysqli_real_escape_string($conn, $_POST['nis']);
            $p = $_POST['password'];

            $q = mysqli_query($conn, "SELECT * FROM siswa WHERE nis='$u' LIMIT 1");
            $data = mysqli_fetch_assoc($q);

            if ($data && password_verify($p, $data['password'])) {
                $_SESSION['siswa'] = $data;
                header("Location: landing.php");
                exit;
            } else {
                echo "<div class='alert alert-danger'>NIS / Password salah!</div>";
            }
        }
        ?>
        <form method="post">
            <div class="mb-3">
                <label for="nis" class="form-label">NIS</label>
                <input type="text" class="form-control" name="nis" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" name="password" id="password" required>
                    <span class="input-group-text bg-white">
                        <i class="bi bi-eye" id="togglePassword" style="cursor: pointer;"></i>
                    </span>
                </div>
            </div>
            <button type="submit" class="btn btn-custom w-100">Login</button>
        </form>
        <div class="text-center mt-3">
            <a href="register.php" class="text-primary">Register Siswa</a> |
            <a href="lupa_password.php" class="text-danger">Lupa Password?</a>
        </div>
        <div class="text-center mt-3">
            <a href="admin/login.php" class="btn btn-admin w-100">Login Admin</a>
        </div>
    </div>

    <script>
        const togglePassword = document.getElementById("togglePassword");
        const passwordInput = document.getElementById("password");

        togglePassword.addEventListener("click", function () {
            const type = passwordInput.type === "password" ? "text" : "password";
            passwordInput.type = type;

            // ganti ikon mata
            this.classList.toggle("bi-eye");
            this.classList.toggle("bi-eye-slash");
        });
    </script>
</body>

</html>