<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: auth/login.php");
  exit;
}
require 'config.php';

// Ambil data daerah
$daerah_result = $conn->query("SELECT * FROM daerah");

// Handle filter & search
$search = $_GET['search'] ?? '';
$filter = $_GET['daerah'] ?? '';

$query = "SELECT masakan.*, daerah.nama_daerah 
          FROM masakan 
          JOIN daerah ON masakan.id_daerah = daerah.id 
          WHERE masakan.nama_masakan LIKE ?";

$params = ["%$search%"];
if ($filter !== '') {
  $query .= " AND daerah.id = ?";
  $params[] = $filter;
}

$stmt = $conn->prepare($query);
if (count($params) === 2) {
  $stmt->bind_param("si", $params[0], $params[1]);
} else {
  $stmt->bind_param("s", $params[0]);
}
$stmt->execute();
$masakan = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <nav class="navbar">
    <span>Selamat datang, <?= $_SESSION['username'] ?>!</span>
    <a href="logout.php" class="btn">Logout</a>
  </nav>

  <div class="dashboard">
    <form method="GET" class="filter-form">
      <input type="text" name="search" placeholder="Cari masakan..." value="<?= htmlspecialchars($search) ?>">
      <select name="daerah">
        <option value="">Semua Daerah</option>
        <?php while ($d = $daerah_result->fetch_assoc()): ?>
          <option value="<?= $d['id'] ?>" <?= $filter == $d['id'] ? 'selected' : '' ?>>
            <?= $d['nama_daerah'] ?>
          </option>
        <?php endwhile; ?>
      </select>
      <button type="submit">Filter</button>
    </form>

    <div class="masakan-list">
      <?php while ($m = $masakan->fetch_assoc()): ?>
        <div class="masakan-card">
          <img src="assets/images/<?= $m['gambar'] ?>" alt="<?= $m['nama_masakan'] ?>">
          <h3><?= $m['nama_masakan'] ?></h3>
          <p><strong><?= $m['nama_daerah'] ?></strong></p>
          <a href="detail_resep.php?id=<?= $m['id'] ?>" class="btn">Lihat Resep</a>
        </div>
      <?php endwhile; ?>
    </div>
  </div>
</body>
</html>
