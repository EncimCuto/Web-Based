<?php
// Membuat koneksi dengan MySQL menggunakan mysqli
$koneksi = mysqli_connect("localhost", "root", "", "pasteur1db"); // Sesuaikan dengan detail koneksi Anda

// Cek koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Query untuk mendapatkan data Flowrate dari hari ini
$sql = "SELECT waktu, Flowrate, SuhuPreheating, SuhuCooling, SuhuHeating,
               SuhuHolding, SuhuPrecooling, SpeedPumpBT2, LevelBT2, PressureBT2,
               PCV1, TimeDivert, SpeedPumpBT1, LevelBT1, BT1AM, SpeedPumpVD,
               LevelVD, VDAM, PressVDHH, PressVDLL, PressToPasteur,
               SpeedPompaMixing, PressureMixing, MixingAM
               FROM readsensors 
               WHERE waktu >= NOW() - INTERVAL 1 HOUR ORDER BY waktu DESC";
$result = mysqli_query($koneksi, $sql);

// Cek apakah ada data yang ditemukan
if (mysqli_num_rows($result) > 0) {
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC); // Ambil semua data dalam format array asosiasi
    // Kembalikan data dalam format JSON
    echo json_encode($data);
} else {
    // Kembalikan pesan dalam format JSON jika tidak ada data
    echo json_encode(["message" => "Tidak ada data ditemukan."]);
}

// Tutup koneksi
mysqli_close($koneksi);
?>
