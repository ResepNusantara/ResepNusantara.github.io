<?php
$koneksi = mysqli_connect("localhost", "root", "", "masakan_nusantara"); // ganti 'nama_database' sesuai database kamu

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
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
          <a href="login.php" class="login-btn">Login</a>
        </li>
      </ul>
    </nav>
    <!-- Navbar-end -->
    <!-- hero -->
    <div class="hero">
      <h2>Resep Masakan Nusantara</h2>

        <div class="resep-list" id="resep-list">
  <?php
  $query = "SELECT * FROM resep ORDER BY id DESC";
  $result = mysqli_query($koneksi, $query);

  if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
      echo '<div class="resep-item">';
      echo '<img src="uploads/' . htmlspecialchars($row["gambar"]) . '" alt="' . htmlspecialchars($row["nama_resep"]) . '" width="200">';
      echo '<h3>' . htmlspecialchars($row["nama_resep"]) . '</h3>';
      echo '<p>' . nl2br(htmlspecialchars(substr($row["deskripsi"], 0, 100))) . '...</p>';
      echo '<a href="resep_detail.php?id=' . $row["id"] . '">Lihat Resep</a>';
      echo '</div>';
    }
  } else {
    echo "<p>Tidak ada resep yang ditemukan.</p>";
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
     <script>
  const resepData = <?php
    $res = mysqli_query($koneksi, "SELECT * FROM resep ORDER BY id DESC");
    $data = [];
    while ($row = mysqli_fetch_assoc($res)) {
        $row['gambar'] = 'uploads/' . $row['gambar'];
        $data[] = $row;
    }
    echo json_encode($data);
  ?>;
</script>
<script src="myscript.js"></script>


  </body>
</html>
