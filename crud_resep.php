<?php
include 'koneksi.php'; // pastikan koneksi sudah dibuat di file ini
if (isset($_POST['create'])) {
    $nama = $conn->real_escape_string($_POST['nama']);
    $deskripsi = $conn->real_escape_string($_POST['deskripsi']);
    $bahan = $conn->real_escape_string($_POST['bahan']);
    $langkah = $conn->real_escape_string($_POST['langkah']);
    $kategori = $conn->real_escape_string($_POST['kategori']);
    
    $gambar = null;
    if ($_FILES['gambar']['name']) {
        $gambar = time() . '_' . basename($_FILES['gambar']['name']);
        move_uploaded_file($_FILES['gambar']['tmp_name'], 'uploads/' . $gambar);
    }

    $sql = "INSERT INTO resep (nama_resep, deskripsi, bahan, langkah, kategori, gambar) VALUES ('$nama', '$deskripsi', '$bahan', '$langkah', '$kategori', " . ($gambar ? "'$gambar'" : "NULL") . ")";

    if (!$conn->query($sql)) {
        die("Gagal menyimpan resep baru: " . $conn->error);
    }

    header("Location: crud_resep.php?status=created");
    exit;
}


// === UPDATE ===
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $bahan = $_POST['bahan'];
    $langkah = $_POST['langkah'];
    $kategori = $_POST['kategori'];

    // Handle upload gambar jika ada
    if ($_FILES['gambar']['name']) {
        $gambar = time() . '_' . $_FILES['gambar']['name'];
        move_uploaded_file($_FILES['gambar']['tmp_name'], 'uploads/' . $gambar);
        // Update termasuk gambar
        $conn->query("UPDATE resep SET nama_resep='$nama', deskripsi='$deskripsi', bahan='$bahan', langkah='$langkah', kategori='$kategori', gambar='$gambar' WHERE id=$id");
    } else {
        // Update tanpa mengganti gambar
        $conn->query("UPDATE resep SET nama_resep='$nama', deskripsi='$deskripsi', bahan='$bahan', langkah='$langkah', kategori='$kategori' WHERE id=$id");
    }

    // Redirect agar form tidak resubmit dan update langsung terlihat
    header("Location: crud_resep.php?status=updated");
    exit;
}

// === HAPUS (jika ada fitur hapus) ===
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $conn->query("DELETE FROM resep WHERE id=$id");
    header("Location: crud_resep.php?status=deleted");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin - CRUD Resep</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        :root {
            --primary: #10b981;
            --danger: #ef4444;
            --bg: #f9fafb;
            --text: #374151;
            --card: #ffffff;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: var(--bg);
            color: var(--text);
            margin: 0;
            padding: 20px;
        }

        h2 {
            color: var(--primary);
            margin-top: 40px;
            border-left: 5px solid var(--primary);
            padding-left: 10px;
        }

        .container {
            max-width: 1100px;
            margin: auto;
        }

        a.logout {
            display: inline-block;
            margin-bottom: 20px;
            font-weight: bold;
            color: var(--danger);
            text-decoration: none;
        }

        form {
            background-color: var(--card);
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.06);
            margin-bottom: 30px;
        }

        input[type="text"], textarea, select {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 0.95em;
        }

        input[type="file"] {
            margin-bottom: 20px;
        }

        button {
            background-color: var(--primary);
            color: white;
            padding: 10px 16px;
            font-size: 1em;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background-color: #059669;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .card {
            background: var(--card);
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.06);
            padding: 15px;
        }

        .card img {
            width: 100%;
            height: 160px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .card h3 {
            margin: 5px 0 10px 0;
            font-size: 1.2em;
        }

        .card small {
            display: inline-block;
            font-weight: bold;
            color: #555;
            margin-bottom: 8px;
        }

        .card textarea,
        .card input[type="text"],
        .card select {
            font-size: 0.9em;
        }

        .hapus-link {
            display: inline-block;
            color: var(--danger);
            margin-top: 10px;
            text-decoration: none;
            font-weight: bold;
        }

        .hapus-link:hover {
            text-decoration: underline;
        }

        @media (max-width: 600px) {
            input, textarea, select, button {
                font-size: 1em;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <?php if (isset($_GET['status'])): ?>
    <div style="padding:10px; background-color: #d1fae5; color: #065f46; margin-bottom:20px; border-radius:8px;">
        <?= $_GET['status'] == 'updated' ? '✅ Resep berhasil diupdate!' : ($_GET['status'] == 'deleted' ? '🗑️ Resep berhasil dihapus!' : '') ?>
    </div>
<?php endif; ?>

    <a class="logout" href="logout.php">🚪 Logout</a>

    <h2>➕ Tambah Resep</h2>
    <form method="post" enctype="multipart/form-data">
        <input type="text" name="nama" placeholder="Nama Resep" required>
        <textarea name="deskripsi" placeholder="Deskripsi" required></textarea>
        <textarea name="bahan" placeholder="Bahan-bahan" required></textarea>
        <textarea name="langkah" placeholder="Langkah-langkah" required></textarea>
        <select name="kategori" required>
            <option value="">-- Pilih Kategori --</option>
            <option value="Umum">Umum</option>
            <option value="Sumatera">Sumatera</option>
            <option value="Jawa">Jawa</option>
            <option value="Bali">Bali</option>
            <option value="Kalimantan">Kalimantan</option>
            <option value="Sulawesi">Sulawesi</option>
            <option value="Nusa Tenggara">Nusa Tenggara</option>
            <option value="Maluku">Maluku</option>
            <option value="Papua">Papua</option>
        </select>
        <input type="file" name="gambar" accept="image/*">
        <button type="submit" name="create">➕ Simpan Resep</button>
    </form>

    <h2>📋 Daftar Resep</h2>
    <div class="grid">
        <?php
        $res = $conn->query("SELECT * FROM resep");
        while ($row = $res->fetch_assoc()) {
            echo "<div class='card'>";
            if ($row['gambar']) {
                echo "<img src='uploads/" . htmlspecialchars($row['gambar']) . "' alt='Gambar Resep'>";
            } else {
                echo "<div style='height:160px; background:#eee; border-radius:8px; display:flex; align-items:center; justify-content:center;'>Tidak ada gambar</div>";
            }
            echo "<h3>" . htmlspecialchars($row['nama_resep']) . "</h3>";
            echo "<small>Kategori: " . htmlspecialchars($row['kategori']) . "</small>";
            echo "<p><strong>Deskripsi:</strong><br>" . nl2br(htmlspecialchars($row['deskripsi'])) . "</p>";
            echo "<p><strong>Bahan:</strong><br>" . nl2br(htmlspecialchars($row['bahan'])) . "</p>";
            echo "<p><strong>Langkah:</strong><br>" . nl2br(htmlspecialchars($row['langkah'])) . "</p>";

            echo "<form method='post' enctype='multipart/form-data'>
                    <input type='hidden' name='id' value='{$row['id']}'>
                    <input type='text' name='nama' value='".htmlspecialchars($row['nama_resep'])."' required>
                    <textarea name='deskripsi'>".htmlspecialchars($row['deskripsi'])."</textarea>
                    <textarea name='bahan'>".htmlspecialchars($row['bahan'])."</textarea>
                    <textarea name='langkah'>".htmlspecialchars($row['langkah'])."</textarea>
                    <select name='kategori' required>
                        <option value='Umum' ".($row['kategori']=='Umum' ? 'selected' : '').">Umum</option>
                        <option value='Sumatera' ".($row['kategori']=='Sumatera' ? 'selected' : '').">Sumatera</option>
                        <option value='Jawa' ".($row['kategori']=='Jawa' ? 'selected' : '').">Jawa</option>
                        <option value='Bali' ".($row['kategori']=='Bali' ? 'selected' : '').">Bali</option>
                        <option value='Kalimantan' ".($row['kategori']=='Kalimantan' ? 'selected' : '').">Kalimantan</option>
                        <option value='Sulawesi' ".($row['kategori']=='Sulawesi' ? 'selected' : '').">Sulawesi</option>
                        <option value='Nusa Tenggara' ".($row['kategori']=='Nusa Tenggara' ? 'selected' : '').">Nusa Tenggara</option>
                        <option value='Maluku' ".($row['kategori']=='Maluku' ? 'selected' : '').">Maluku</option>
                        <option value='Papua' ".($row['kategori']=='Papua' ? 'selected' : '').">Papua</option>
                    </select>
                    <input type='file' name='gambar' accept='image/*'>
                    <button type='submit' name='update'>💾 Update</button>
                  </form>";
            echo "<a class='hapus-link' href='?hapus={$row['id']}' onclick='return confirm(\"Yakin ingin menghapus resep ini?\")'>🗑️ Hapus</a>";
            echo "</div>";
        }
        ?>
    </div>
</div>
</body>
</html>
