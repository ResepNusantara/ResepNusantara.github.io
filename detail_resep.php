<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: auth/login.php");
  exit;
}

require 'config.php';

$id = $_GET['id'] ?? 0;

// Ambil data masakan
$stmt = $conn->prepare("SELECT masakan.*, daerah.nama_daerah FROM masakan 
                        JOIN daerah ON masakan.id_daerah = daerah.id 
                        WHERE masakan.id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$masakan = $stmt->get_result()->fetch_assoc();

if (!$masakan) {
  echo "Resep tidak ditemukan.";
  exit;
}

// Ambil komentar
$komentar_stmt = $conn->prepare("SELECT komentar.*, users.username 
                                 FROM komentar 
                                 JOIN users ON komentar.id_user = users.id 
                                 WHERE komentar.id_masakan = ? 
                                 ORDER BY komentar.tanggal DESC");
$komentar_stmt->bind_param("i", $id);
$komentar_stmt->execute();
$komentar_result = $komentar_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title><?= $masakan['nama_masakan'] ?></title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <nav class="navbar">
    <a href="dashboard.php" class="btn">← Kembali</a>
    <a href="logout.php" class="btn">Logout</a>
  </nav>

  <div class="resep-container">
    <h2><?= $masakan['nama_masakan'] ?> <small>(<?= $masakan['nama_daerah'] ?>)</small></h2>
    <img src="assets/images/<?= $masakan['gambar'] ?>" alt="<?= $masakan['nama_masakan'] ?>" class="resep-img">
    <p><?= nl2br($masakan['deskripsi']) ?></p>

    <hr>

    <h3>Komentar</h3>
    <form action="komentar.php" method="POST" class="komentar-form">
      <input type="hidden" name="id_masakan" value="<?= $id ?>">
      <textarea name="isi" rows="3" placeholder="Tulis komentar..." required></textarea>
      <button type="submit">Kirim</button>
    </form>

    <div class="komentar-list">
      <?php while ($k = $komentar_result->fetch_assoc()): ?>
        <div class="komentar-item">
          <strong><?= htmlspecialchars($k['username']) ?>:</strong><br>
          <small><?= $k['tanggal'] ?></small>
          <p><?= nl2br(htmlspecialchars($k['isi'])) ?></p>
        </div>
      <?php endwhile; ?>
    </div>
  </div>
</body>
</html>
