<?php
// Include file koneksi.php untuk menghubungkan ke database
include "../../function/boiler/koneksi.php";

// Ubah format tanggal yang sesuai dengan MySQL (YYYY-MM-DD)
$tanggal = '2024-07-26';

// Query untuk mengambil data terbaru (misalnya, batubara)
$query = "SELECT bb_steam, AvgBatubara, AvgSteam FROM `bb_steam` WHERE DATE(waktu) >= '$tanggal' ORDER BY id DESC LIMIT 1";
$result = mysqli_query($koneksi, $query);

$data = array();
// Ambil nilai batubara dari hasil query
if ($row = mysqli_fetch_assoc($result)) {
    $data['bbsteam'] = $row['bb_steam']; // Data bbsteam
    $data['batubara'] = $row['AvgBatubara']; // Data average batubara
    $data['steam'] = $row['AvgSteam']; // Data average steam
} else {
    $data['batubara'] = 0; // Jika tidak ada data, set default ke 0
}

header('Content-Type: application/json');
echo json_encode($data);
?>