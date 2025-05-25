<?php
$koneksi = mysqli_connect("localhost", "root", "", "masakan_nusantara");
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Ambil semua kategori unik dari tabel resep
$query = "SELECT DISTINCT kategori FROM resep ORDER BY kategori ASC";
$result = mysqli_query($koneksi, $query);

$kategoriList = [];
while ($row = mysqli_fetch_assoc($result)) {
    $kategoriList[] = $row['kategori'];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Kategori Resep Nusantara</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <!-- Navbar -->
  <nav>
    <div class="brand">Masakan Nusantara</div>
    <ul class="nav-links" id="nav-links">
      <li><a href="index.html">Beranda</a></li>
      <li><a href="resep.php">Resep</a></li>
      <li><a href="Kategori.php">Kategori</a></li>
      <li><a href="Tentang.html">Tentang</a></li>
      <input type="text" id="searchInput" placeholder="Cari resep..." onkeyup="searchResep()" />
      <li><a href="login.php" class="login-btn">Login</a></li>
    </ul>
  </nav>
  <!-- Navbar end -->

  <!-- hero -->
  <div class="hero-kategori">
    <h2>KATEGORI</h2>
    <div class="kategori">
      <?php foreach ($kategoriList as $kategori): ?>
        <a href="resep_kategori.php?kategori=<?php echo urlencode($kategori); ?>">
          <?php echo htmlspecialchars($kategori); ?>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
  <!-- hero end -->

  <!-- Footer -->
  <footer class="footer">
    <p>&copy; 2025 Resep Masakan Nusantara. Semua Hak Dilindungi. CP26.KelA</p>
  </footer>
  <!-- Footer end -->
</body>
</html>
