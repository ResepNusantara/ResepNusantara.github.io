<?php
include 'db.php';

$sql = "SELECT id, judul, gambar FROM resep ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Resep Makanan Nusantara</title>
<style>
  .resep-list {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
  }
  .resep-item {
    width: 150px;
    text-align: center;
  }
  .resep-item img {
    width: 150px;
    height: 100px;
    object-fit: cover;
    border-radius: 8px;
  }
  .resep-item p {
    margin-top: 8px;
    font-weight: bold;
  }
</style>
</head>
<body>
<h2>Resep Masakan Nusantara</h2>
<div class="resep-list" id="resepList">
  <?php if ($result->num_rows > 0): ?>
    <?php while ($row = $result->fetch_assoc()): ?>
      <div class="resep-item">
        <a href="resepdetail.php?id=<?= $row['id'] ?>">
          <img src="uploads/<?= htmlspecialchars($row['gambar']) ?>" alt="<?= htmlspecialchars($row['judul']) ?>" />
          <p><?= htmlspecialchars($row['judul']) ?></p>
        </a>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <p>Tidak ada resep ditemukan.</p>
  <?php endif; ?>
</div>
</body>
</html>
