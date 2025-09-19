<?php
include 'config.php';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- penting untuk mobile -->
    <title>Login Siswa - E-Voting Pramuka</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: url('assets/img/bg.png') repeat;
            background-size: cover;
            font-family: 'Merriweather', serif;
        }

        a {
        text-decoration: none;
        }

        a:hover {
        background-color: white;
        border-radius: 5px;
        padding: 10px;
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
        
        .btn-custom {
            background: linear-gradient(145deg, #8D6E63, #5D4037);
            color: white;
            border-radius: 30px;
            margin-top: 8px;
            transition: all 0.3s ease;
            font-size: 0.9rem;
            padding: 8px;
        }

        .btn-custom:hover {
            background: linear-gradient(145deg, #FFD700, #A1887F);
            color: black;
            transform: scale(1.05);
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.3);
        }

        .btn-admin {
            background: linear-gradient(145deg, #8D6E63, #5D4037);
            color: white;
            border-radius: 30px;
            margin-top: 8px;
            transition: all 0.3s ease;
            font-size: 0.9rem;
            padding: 8px;
        }

        .btn-admin:hover {
            background: linear-gradient(145deg, #FFD700, #A1887F);
            color: black;
            transform: scale(1.05);
        }

        .input-group-text {
            background: #fff;
            border-left: none;
        }

        .input-group .form-control {
            border-right: none;
        }

        /* Responsive text size */
        @media (max-width: 576px) {
            h3 {
                font-size: 1.3rem;
            }

            .form-label {
                font-size: 0.9rem;
            }

            .btn-custom,
            .btn-admin {
                font-size: 0.9rem;
            }
        }
    </style>
</head>

<body class="d-flex justify-content-center align-items-center vh-100">
    <div class="card card-login shadow-lg">
        <h3 class="text-center text-light mb-3">Login Siswa</h3>
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
                echo "<div class='alert alert-danger py-2'>NIS / Password salah!</div>";
            }
        }
        ?>
        <form method="post">
            <div class="mb-2">
                <label for="nis" class="form-label">NIS</label>
                <input type="text" class="form-control" name="nis" required>
            </div>
            <div class="mb-2">
                <label>Password</label>
                <div class="input-group">
                    <input type="password" name="password" id="password" class="form-control" required>
                    <span class="input-group-text">
                        <i class="bi bi-eye" id="togglePassword" style="cursor: pointer;"></i>
                    </span>
                </div>
            </div>
            <button type="submit" class="btn btn-custom w-100 mt-2">Login</button>
        </form>

        <div class="text-center mt-3 small">
            <a href="register.php" class="text-primary">Register</a> |
            <a href="lupa_password.php" class="text-danger">Lupa Password?</a>
        </div>

        <div class="text-center mt-2">
            <a href="admin/login.php" class="btn btn-admin w-100">Login Admin</a>
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