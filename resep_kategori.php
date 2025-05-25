<?php
$koneksi = mysqli_connect("localhost", "root", "", "masakan_nusantara");
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';
$kategori = mysqli_real_escape_string($koneksi, $kategori);

$query = "SELECT * FROM resep WHERE kategori = '$kategori'";
$result = mysqli_query($koneksi, $query);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Resep Makanan Nusantara</title>
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
        <input
          type="text"
          id="searchInput"
          placeholder="Cari resep..."
          onkeyup="searchResep()"
        />

        <li>
          <button class="login-btn" id="login-btn">Login</button>
        </li>
      </ul>
    </nav>
    <!-- Navbar-end -->
    <!-- hero -->
    <div class="hero">
      </div>

    <section class="resep-section">
        <div class="resep-list">
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="resep-item">';
                    echo '<img src="uploads/' . htmlspecialchars($row['gambar']) . '" alt="' . htmlspecialchars($row['nama_resep']) . '" width="200">';
                    echo '<h3>' . htmlspecialchars($row['nama_resep']) . '</h3>';
                    echo '<a href="resep_detail.php?id=' . $row['id'] . '">Lihat Resep</a>';
                    echo '</div>';
                }
            } else {
                echo "<p>Tidak ada resep dalam kategori ini.</p>";
            }
            ?>
        </div>
    </div>
    <!-- hero end -->
    <!-- Footer -->
    <footer class="footer">
      <p>
        &copy; 2025 Resep Masakan Nusantara. Semua Hak Dilindungi. CP26.KelA
      </p>
    </footer>
    <!-- Footer end -->
  </body>
</html>
