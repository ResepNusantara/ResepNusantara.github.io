<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "masakan_nusantara"; // Ganti dengan nama database kamu

$conn = new mysqli($host, $user, $pass, $db);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
