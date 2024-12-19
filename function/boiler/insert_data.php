<?php
header('Content-Type: application/json');

// Koneksi ke database
include './koneksi.php';

$response = ['success' => false, 'message' => '', 'data' => []];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $batubara = isset($_POST['batubara']) ? floatval(str_replace(',', '.', $_POST['batubara'])) : 0.0;
    $steam = isset($_POST['steam']) ? floatval(str_replace(',', '.', $_POST['steam'])) : 0.0;

    // Validasi data (harus lebih dari 0)
    if ($batubara > 0.0 && $steam > 0.0) {
        // Persiapan query
        $stmt = $koneksi->prepare("INSERT INTO readsensors (Batubara_FK, Steam_FK) VALUES (?, ?)");
        if ($stmt === false) {
            $response['message'] = "Prepare failed: " . $koneksi->error;
        } else {
            // Bind parameter menggunakan 'dd' untuk dua float
            $stmt->bind_param("dd", $batubara, $steam);
            if ($stmt->execute()) {
                $response['success'] = true;
                $response['message'] = "Data successfully inserted";
                $response['data'] = ['batubara' => $batubara, 'steam' => $steam];
            } else {
                $response['message'] = "Error: " . $stmt->error;
            }
            $stmt->close();
        }
    } else {
        $response['message'] = "Batubara and Steam must be greater than 0 and numeric";
    }
} else {
    $response['message'] = "Invalid request method";
}

// Tutup koneksi dan kirim respons
$koneksi->close();
echo json_encode($response);  // Pastikan hanya JSON yang dikirim sebagai output
?>
