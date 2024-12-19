<?php
// Koneksi ke database
include '../pasteurisasi/koneksi.php'; // Pastikan file koneksi ini sudah benar

// Periksa apakah request menggunakan metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $mode = isset($_POST['mode']) ? $_POST['mode'] : '';
    $varian = isset($_POST['varian']) ? $_POST['varian'] : '';
    $batch = isset($_POST['batch']) ? $_POST['batch'] : '';
    $storage = isset($_POST['storage']) ? $_POST['storage'] : '';

    // Validasi data
    if (!empty($mode) && !empty($varian) && !empty($batch) && !empty($storage)) {
        // Query untuk memasukkan data ke database
        $stmt = $koneksi->prepare("INSERT INTO readsensors (Mode, Varian, Batch, Storage) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $mode, $varian, $batch, $storage); // ssss menunjukkan 4 string parameter

        // Eksekusi query dan periksa apakah berhasil
        if ($stmt->execute()) {
            echo "Data processed successfully";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Tutup statement
        $stmt->close();
    } else {
        echo "All fields are required";
    }
} else {
    echo "Invalid request method";
}

// Tutup koneksi database
$koneksi->close();
?>
