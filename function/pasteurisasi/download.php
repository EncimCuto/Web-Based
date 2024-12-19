<?php
require_once './koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Mengambil file berdasarkan ID dengan mysqli
    $query = $koneksi->prepare("SELECT Nama_File, Excel FROM db_excel WHERE id = ?");
    $query->bind_param("i", $id); // "i" stands for integer
    $query->execute();
    
    $result = $query->get_result();
    $file = $result->fetch_assoc();

    if ($file) {
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $file['Nama_File'] . '.xlsx"');
        echo $file['Excel'];
        exit;
    } else {
        echo "File tidak ditemukan.";
    }
} else {
    echo "ID tidak valid.";
}
?>
