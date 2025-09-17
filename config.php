<?php

$host = "localhost";
$user = "root"; // ganti sesuai server
$pass = "";
$db = "evoting_pramuka";

$conn = mysqli_connect($host, $user, $pass, $db);


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$conn = mysqli_connect("localhost", "root", "", "evoting_pramuka") 
    or die("Koneksi gagal: " . mysqli_connect_error());
?>

