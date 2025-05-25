<?php
include 'db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = $_POST['judul'];

    // cek upload file gambar
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $filename = basename($_FILES['gambar']['name']);
        $target_dir = "uploads/";
        $target_file = $target_dir . $filename;

        // cek ekstensi gambar
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($imageFileType, $allowed_types)) {
            // pindahkan file ke folder uploads
            if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
                // simpan ke database
                $stmt = $conn->prepare("INSERT INTO resep (judul, gambar) VALUES (?, ?)");
                $stmt->bind_param("ss", $judul, $filename);
                if ($stmt->execute()) {
                    $message = "Resep berhasil disimpan.";
                } else {
                    $message = "Gagal menyimpan resep ke database.";
                }
                $stmt->close();
            } else {
                $message = "Gagal meng-upload gambar.";
            }
        } else {
            $message = "Format gambar tidak didukung. Gunakan JPG, PNG, atau GIF.";
        }
    } else {
        $message = "Mohon pilih gambar resep.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Admin Input Resep</title>
<style>
  body { font-family: Arial, sans-serif; margin: 20px; }
  form { max-width: 400px; }
  label { display: block; margin-top: 10px; }
  input[type=text], input[type=file] { width: 100%; padding: 8px; margin-top: 5px; }
  button { margin-top: 15px; padding: 10px 15px; }
  .message { margin-top: 15px; color: green; }
</style>
</head>
<body>
<h1>Input Resep Baru</h1>

<?php if ($message): ?>
  <div class="message"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<form method="post" enctype="multipart/form-data">
  <label for="judul">Judul Resep:</label>
  <input type="text" id="judul" name="judul" required />

  <label for="gambar">Gambar Resep:</label>
  <input type="file" id="gambar" name="gambar" accept="image/*" required />

  <button type="submit">Simpan Resep</button>
</form>
</body>
</html>
