// ✅ Tampilkan resep di halaman (pakai data dari PHP)
function tampilkanResep(data) {
  const list = document.getElementById("resep-list");
  if (!list) return;
  list.innerHTML = "";

  if (data.length === 0) {
    list.innerHTML = "<p>Tidak ada resep ditemukan.</p>";
    return;
  }

  data.forEach((item) => {
    const div = document.createElement("div");
    div.className = "resep-item";
    div.innerHTML = `
      <img src="${item.gambar}" alt="${item.nama_resep}" style="width:100%; max-width:300px; border-radius:10px;"/>
      <h3>${item.nama_resep}</h3>
      <p>${item.deskripsi.substring(0, 100)}...</p>
      <a href="resep_detail.php?id=${item.id}">Lihat Selengkapnya</a>
    `;
    list.appendChild(div);
  });
}

// ✅ Fungsi pencarian resep
function searchResep() {
  const input = document.getElementById("searchInput");
  if (!input) return;

  const keyword = input.value.toLowerCase();
  const hasilFilter = resepData.filter((item) =>
    item.nama_resep.toLowerCase().includes(keyword)
  );
  tampilkanResep(hasilFilter);
}

// ✅ Inisialisasi setelah halaman selesai dimuat
document.addEventListener("DOMContentLoaded", () => {
  tampilkanResep(resepData); // tampilkan semua data saat awal

  // Pasang event listener untuk pencarian
  const input = document.getElementById("searchInput");
  if (input) {
    input.addEventListener("keyup", searchResep);
  }
});
