<?php
include_once './koneksi.php'; // Pastikan koneksi ke database

// Periksa apakah ID disediakan di URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Siapkan dan jalankan query untuk mengambil file PDF berdasarkan ID
    $sql = "SELECT pdf_file, file_name FROM form_boiler WHERE id = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($pdfFile, $fileName);
    $stmt->fetch();
    
    // Pastikan file PDF berhasil diambil
    if ($pdfFile) {
        // Atur header untuk menampilkan PDF di browser
        header("Content-type: application/pdf");
        header("Content-Disposition: inline; filename=\"" . $fileName . "\"");
        echo $pdfFile;
    } else {
        echo "File PDF tidak ditemukan.";
    }

    $stmt->close();
    exit;
} else {
    echo "ID tidak valid.";
}
?>
