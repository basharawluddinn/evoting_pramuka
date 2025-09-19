<?php
include '../config.php'; // karena file ini ada di folder admin

// Ambil semua admin
$q = mysqli_query($conn, "SELECT id, username, password FROM admin");

while ($r = mysqli_fetch_assoc($q)) {
    // Kalau password belum hash (biasanya panjang < 50 karakter)
    if (strlen($r['password']) < 50) {
        $hash = password_hash($r['password'], PASSWORD_DEFAULT);
        mysqli_query($conn, "UPDATE admin SET password='$hash' WHERE id='{$r['id']}'");
        echo "✅ Password untuk admin <b>{$r['username']}</b> berhasil di-hash.<br>";
    }
}

echo "<br>🚀 Proses selesai. Hapus file <b>hash_password_admin.php</b> setelah dijalankan!";
