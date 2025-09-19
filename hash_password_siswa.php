<?php
include 'config.php';

// Ambil semua siswa
$q = mysqli_query($conn, "SELECT nis, password FROM siswa");

while ($r = mysqli_fetch_assoc($q)) {
    // Kalau password masih plain text (hash umumnya panjang > 50)
    if (strlen($r['password']) < 50) {
        $hash = password_hash($r['password'], PASSWORD_DEFAULT);
        mysqli_query($conn, "UPDATE siswa SET password='$hash' WHERE nis='{$r['nis']}'");
        echo "✅ Password untuk siswa NIS {$r['nis']} berhasil di-hash.<br>";
    }
}

echo "<hr>✔️ Proses hashing selesai. Silakan hapus/rename file ini demi keamanan.";
