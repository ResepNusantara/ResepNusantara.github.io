<?php
// Koneksi ke database
$host = "localhost";
$user = "root";
$pass = "";
$db = "masakan_nusantara"; // Ganti dengan nama database Anda
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
  die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil ID dari URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Ambil data resep
$sql = "SELECT * FROM resep WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $resep = $result->fetch_assoc();
} else {
  echo "Resep tidak ditemukan.";
  exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?php echo htmlspecialchars($resep['nama_resep']); ?></title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <nav>
    <div class="brand">Masakan Nusantara</div>
    <ul class="nav-links">
      <li><a href="index.html">Beranda</a></li>
      <li><a href="Resep.html">Resep</a></li>
      <li><a href="Kategori.html">Kategori</a></li>
      <li><a href="Tentang.html">Tentang</a></li>
    </ul>
  </nav>

  <main class="detail-resep">
    <h1><?php echo htmlspecialchars($resep['nama_resep']); ?></h1>
    <img src="uploads/<?php echo htmlspecialchars($resep['gambar']); ?>" alt="<?php echo htmlspecialchars($resep['nama_resep']); ?>" style="max-width: 400px; height: auto; border-radius: 10px; margin-bottom: 20px;">
    
    <h2>Deskripsi</h2>
    <p><?php echo nl2br(htmlspecialchars($resep['deskripsi'])); ?></p>

    <h2>Bahan</h2>
    <p><?php echo nl2br(htmlspecialchars($resep['bahan'])); ?></p>

    <h2>Langkah-langkah</h2>
    <p><?php echo nl2br(htmlspecialchars($resep['langkah'])); ?></p>
  </main>

  <footer class="footer">
    <p>&copy; 2025 Resep Masakan Nusantara. Semua Hak Dilindungi.</p>
  </footer>
</body>
</html>
