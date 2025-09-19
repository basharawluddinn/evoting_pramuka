<?php
include '../config.php';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login Admin - E-Voting Pramuka</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: url('../assets/img/bg.png') repeat;
            background-size: cover;
            font-family: 'Merriweather', serif;
        }

        .card-login {
            background: linear-gradient(145deg, #fdfdfd, #f1f1f1);
            border-radius: 15px;
            border-color: white;
            box-shadow: 6px 6px 15px rgba(0, 0, 0, 0.3),
                -6px -6px 15px rgba(255, 255, 255, 0.5);
            padding: 20px;
            width: 100%;
            max-width: 350px;
            background: transparent;
            color: white;
            /* biar pas di hp */
        }

        .card-login:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 12px 12px 28px rgba(0, 0, 0, 0.5),
                -12px -12px 28px rgba(255, 255, 255, 0.7);
        }

        .btn-custom {
            background: linear-gradient(145deg, #5D4037, #8D6E63);
            color: white;
            border-radius: 50px;
            font-weight: bold;
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
    <div class="card card-login p-4 shadow-lg" style="width:400px;">
        <h3 class="text-center mb-3">Login Admin</h3>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $u = mysqli_real_escape_string($conn, $_POST['username']);
            $p = $_POST['password'];

            $q = mysqli_query($conn, "SELECT * FROM admin WHERE username='$u' LIMIT 1");
            $data = mysqli_fetch_assoc($q);

            if ($data && password_verify($p, $data['password'])) {
                $_SESSION['admin'] = $data;
                header("Location: dashboard.php");
                exit;
            } else {
                echo "<div class='alert alert-danger'>❌ Username / Password salah!</div>";
            }
        }
        ?>
        <form method="post">
            <div class="mb-3">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <div class="input-group">
                    <input type="password" name="password" id="password" class="form-control" required>
                    <span class="input-group-text bg-white">
                        <i class="bi bi-eye" id="togglePassword" style="cursor: pointer;"></i>
                    </span>
                </div>
            </div>

            <button class="btn btn-custom w-100">Login</button>
        </form>
        <div class="text-center mt-3">
            <a href="../index.php" class="text-light">⬅ Kembali ke Login Siswa</a>
        </div>
    </div>

    <script>
        const togglePassword = document.getElementById("togglePassword");
        const passwordInput = document.getElementById("password");

        togglePassword.addEventListener("click", function () {
            const type = passwordInput.type === "password" ? "text" : "password";
            passwordInput.type = type;

            this.classList.toggle("bi-eye");
            this.classList.toggle("bi-eye-slash");
        });
    </script>
</body>

</html>