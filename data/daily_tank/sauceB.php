<?php
// Include file koneksi.php untuk menghubungkan ke database
include "../../function/daily_tank/koneksi.php";

// Ubah format tanggal yang sesuai dengan MySQL (YYYY-MM-DD)
$tanggal = '2024-07-26';

// Query untuk mengambil data terbaru (misalnya, level feed water)
$query = "SELECT DT_SoySauceB FROM `readsensors` WHERE DATE(waktu) >= '$tanggal' ORDER BY id DESC LIMIT 1";
$result = mysqli_query($koneksi, $query);

$data = array();
// Ambil nilai level feed water dari hasil query
if ($row = mysqli_fetch_assoc($result)) {
    $data['sauceB'] = $row['DT_SoySauceB']; // Data level feed water
} else {
    $data['sauceB'] = 0; // Jika tidak ada data, set default ke 0
}

header('Content-Type: application/json');
echo json_encode($data);
?>