<?php
// Include file koneksi.php untuk menghubungkan ke database
include "../../function/pasteurisasi_line_2/koneksi.php";

// Ubah format tanggal yang sesuai dengan MySQL (YYYY-MM-DD)
$tanggal = '2024-12-23';

// Query untuk mengambil data terbaru (misalnya, level feed water)
$query = "SELECT SuhuCooling FROM `readsensors` WHERE DATE(waktu) >= '$tanggal' ORDER BY id DESC LIMIT 1";
$result = mysqli_query($koneksi, $query);

$data = array();
// Ambil nilai level feed water dari hasil query
if ($row = mysqli_fetch_assoc($result)) {
    $data['SuhuCooling'] = $row['SuhuCooling']; // Data level feed water
} else {
    $data['SuhuCooling'] = 0; // Jika tidak ada data, set default ke 0
}

header('Content-Type: application/json');
echo json_encode($data);
?>