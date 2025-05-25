<?php
$servername = "localhost";
$username = "root";          // sesuaikan
$password = "";              // sesuaikan
$dbname = "resep_db";       // sesuaikan

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
