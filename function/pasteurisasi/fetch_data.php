<?php
// Koneksi ke database
include '../pasteurisasi/koneksi.php'; // Pastikan file koneksi ini sudah benar

// Query untuk mengambil data terbaru
$query = "SELECT Mode, Varian, Batch, Storage FROM readsensors ORDER BY id DESC LIMIT 1";
$result = $koneksi->query($query);

// Cek apakah ada hasil
if ($result->num_rows > 0) {
    // Looping melalui hasil dan membangun baris tabel HTML
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['Mode']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Varian']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Batch']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Storage']) . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='4'>No data available</td></tr>"; // Pesan jika tidak ada data
}

// Tutup koneksi database
$koneksi->close();
?>
