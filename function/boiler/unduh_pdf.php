<?php
include_once './koneksi.php'; // Pastikan koneksi sudah benar

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Siapkan statement untuk mengambil data PDF
    $sql = "SELECT pdf_file, file_name FROM form_boiler WHERE id = ?";
    $stmt = $koneksi->prepare($sql);
    if (!$stmt) {
        die("Prepare statement error: " . $koneksi->error);
    }

    // Bind parameter ID
    if (!$stmt->bind_param("i", $id)) {
        die("Bind param error: " . $stmt->error);
    }

    // Execute statement
    if (!$stmt->execute()) {
        die("Execute error: " . $stmt->error);
    }

    // Bind result untuk mendapatkan file PDF dan nama file
    if (!$stmt->bind_result($pdfFile, $fileName)) {
        die("Bind result error: " . $stmt->error);
    }

    // Fetch hasil
    if (!$stmt->fetch()) {
        die("Fetch error: Tidak ada data atau error saat mengambil data.");
    }

    // Set header untuk mendownload PDF
    header("Content-type: application/pdf");
    header("Content-Disposition: attachment; filename=\"" . $fileName . "\"");
    echo $pdfFile;
    exit;
} else {
    echo "ID tidak ditemukan.";
}
?>
