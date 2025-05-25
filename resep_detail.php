<?php
$koneksi = mysqli_connect("localhost", "root", "", "masakan_nusantara");

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "SELECT * FROM resep WHERE id = $id";
    $result = mysqli_query($koneksi, $query);

    if ($row = mysqli_fetch_assoc($result)) {
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($row['nama_resep']); ?></title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #fef6e4;
            margin: 0;
            padding: 40px 20px;
            text-align: center;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        h1 {
            font-size: 2.5em;
            color: #c44536;
            margin-bottom: 20px;
        }

        .image-container {
            margin: 20px 0;
        }

        .image-container img {
            max-width: 50%;
            height: auto;
            border-radius: 10px;
        }

        .section {
            margin-top: 30px;
            text-align: center;
        }

        .section h3 {
            color: #198754;
            font-size: 1.5em;
            margin-bottom: 15px;
        }

        .section ul {
            list-style: none;
            padding: 0;
            max-width: 500px;
            margin: 0 auto;
            text-align: center;
        }

        .section ul li {
            margin-bottom: 8px;
            line-height: 1.6;
        }

        .back-btn {
            display: inline-block;
            margin-top: 30px;
            padding: 12px 24px;
            background-color: #c44536;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .back-btn:hover {
            background-color: #a33227;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><?php echo htmlspecialchars($row['nama_resep']); ?></h1>

        <div class="image-container">
            <img src="uploads/<?php echo htmlspecialchars($row['gambar']); ?>" alt="Gambar Resep">
        </div>

        <div class="section">
            <h3>Deskripsi</h3>
            <p><?php echo nl2br(htmlspecialchars($row['deskripsi'])); ?></p>
        </div>

        <div class="section">
            <h3>Bahan-bahan 🥥</h3>
            <ul>
                <?php
                $bahan_list = explode("\n", $row['bahan']);
                foreach ($bahan_list as $bahan) {
                    echo '<li>' . htmlspecialchars($bahan) . '</li>';
                }
                ?>
            </ul>
        </div>

        <div class="section">
            <h3>Langkah-langkah 👩‍🍳</h3>
            <ul>
                <?php
                $langkah_list = explode("\n", $row['langkah']);
                foreach ($langkah_list as $langkah) {
                    echo '<li>' . htmlspecialchars($langkah) . '</li>';
                }
                ?>
            </ul>
        </div>

        <a href="resep.php" class="back-btn">← Kembali ke Daftar Resep</a>
    </div>
</body>
</html>
<?php
    } else {
        echo "Resep tidak ditemukan.";
    }
} else {
    echo "ID tidak ditemukan di URL.";
}
?>
