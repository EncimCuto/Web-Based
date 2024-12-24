<?php
// Include file koneksi.php untuk menghubungkan ke database
include "../../function/stk400/koneksi.php";

// Ubah format tanggal yang sesuai dengan MySQL (YYYY-MM-DD)
$tanggal = '2024-12-24';

// Query untuk mengambil data terbaru (misalnya, level feed water)
$query = "SELECT Flowrate FROM `readsensors` WHERE DATE(waktu) >= '$tanggal' ORDER BY id DESC LIMIT 1";
$result = mysqli_query($koneksi, $query);

$data = array();
// Ambil nilai level feed water dari hasil query
if ($row = mysqli_fetch_assoc($result)) {
    $data['flowrate'] = $row['Flowrate']; // Data flowrate
} else {
    $data['flowrate'] = 0; // Jika tidak ada data, set default ke 0
}

header('Content-Type: application/json');
echo json_encode($data);
?>