<?php
$koneksi = new mysqli("localhost", "root", "", "masakan_nusantara");
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

$sql = "SELECT id, nama_resep, deskripsi FROM resep";
$result = $koneksi->query($sql);

$resep = array();

while ($row = $result->fetch_assoc()) {
    $resep[] = $row;
}

header('Content-Type: application/json');
echo json_encode($resep);
?>
