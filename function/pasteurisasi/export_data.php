<?php
session_start();
set_time_limit(300);
require_once './koneksi.php';
require_once __DIR__ . '../../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

if (!isset($_SESSION['token']) || $_SESSION['token'] !== $_GET['token']) {
    header('Location: ../index.php');
    exit;
}

$tanggal_awal = $_GET['tanggal-awal'] ?? '';
$tanggal_akhir = $_GET['tanggal-akhir'] ?? $tanggal_awal;
$data_types = isset($_GET['data']) ? explode(',', $_GET['data']) : [];
$interval = $_GET['interval'] ?? '';
$data_raw = $_GET['data'] ?? '';
$data_array = explode(',', $data_raw);
$deskripsi = implode(' , ', $data_array); // Gabungkan data menjadi deskripsi

if (empty($tanggal_awal) || empty($data_types)) {
    die("Parameter tanggal-awal atau data tidak ada.");
}

// Membuat nama file berdasarkan tanggal_awal dan tanggal_akhir
$tanggal_awal_formatted = DateTime::createFromFormat('Y-m-d', $tanggal_awal)->format('d-m-Y');
$tanggal_akhir_formatted = DateTime::createFromFormat('Y-m-d', $tanggal_akhir)->format('d-m-Y');
$nama_file = 'Data Pasteurisasi ' . $tanggal_awal_formatted . ' to ' . $tanggal_akhir_formatted . '.xlsx';

try {
    // Koneksi ke database
    $pdo = new PDO('mysql:host=localhost;dbname=pasteur1db', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Persiapkan query untuk mengambil data
    if ($interval === 'jam') {
        // Query 1: Data per jam tanpa rata-rata
        $query = "SELECT 
        DATE_FORMAT(waktu, '%Y-%m-%d %H:00:00') AS waktu,
        Mode, Varian, Batch, Storage
        FROM readsensors 
        WHERE waktu BETWEEN :tanggal_awal AND :tanggal_akhir 
        GROUP BY DATE_FORMAT(waktu, '%Y-%m-%d %H:00:00')";
    } else {
        // Query default tanpa pengelompokan per jam
        $query = "SELECT waktu";
        foreach ($data_types as $type) {
            $query .= ", " . $type;
        }
        $query .= ", Mode, Varian, Batch, Storage"; // Menambahkan kolom baru
        $query .= " FROM readsensors WHERE waktu BETWEEN :tanggal_awal AND :tanggal_akhir";
    }

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':tanggal_awal', $tanggal_awal);
    $stmt->bindParam(':tanggal_akhir', $tanggal_akhir);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Membuat spreadsheet baru
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Menambahkan header
    $sheet->setCellValue('A1', 'Waktu');
    foreach ($data_types as $index => $type) {
        $sheet->setCellValue(chr(66 + $index) . '1', ucfirst(str_replace('_', ' ', $type)));
    }

    // Menambahkan header baru untuk Mode, Varian, Batch, dan Storage
    $startColumn = 66 + count($data_types); // Kolom setelah data yang dipilih
    $sheet->setCellValue(chr($startColumn) . '1', 'Mode');
    $sheet->setCellValue(chr($startColumn + 1) . '1', 'Varian');
    $sheet->setCellValue(chr($startColumn + 2) . '1', 'Batch');
    $sheet->setCellValue(chr($startColumn + 3) . '1', 'Storage');

    // Menambahkan data
    $row = 2;
    foreach ($results as $result) {
        $sheet->setCellValue('A' . $row, $result['waktu']);

        // Menambahkan data dari data_types
        foreach ($data_types as $index => $type) {
            $sheet->setCellValue(chr(66 + $index) . $row, isset($result[$type]) ? round($result[$type], 2) : '');
        }

        // Tambahkan data untuk Mode, Varian, Batch, dan Storage di sebelah kanan data yang dipilih
        $sheet->setCellValue(chr($startColumn) . $row, $result['Mode']);
        $sheet->setCellValue(chr($startColumn + 1) . $row, $result['Varian']);
        $sheet->setCellValue(chr($startColumn + 2) . $row, $result['Batch']);
        $sheet->setCellValue(chr($startColumn + 3) . $row, $result['Storage']);

        $row++;
    }

    // Mengatur lebar kolom secara otomatis
    foreach (range('A', chr($startColumn + 3)) as $columnID) {
        $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }

    // Mengatur header dan data menjadi center
    $sheet->getStyle('A1:' . chr($startColumn + 3) . '1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('A2:' . chr($startColumn + 3) . ($row - 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    // Menambahkan border ke seluruh tabel
    $sheet->getStyle('A1:' . chr($startColumn + 3) . ($row - 1))
        ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

    // Simpan file ke output buffer
    $writer = new Xlsx($spreadsheet);
    ob_start(); // Mulai output buffer
    $writer->save('php://output'); // Simpan file ke output buffer
    $fileData = ob_get_contents(); // Ambil konten dari buffer
    ob_end_clean(); // Bersihkan buffer

    // Menyimpan file ke database
    $stmt = $pdo->prepare("INSERT INTO db_excel (Nama_File, Deskripsi, Excel) VALUES (:nama_file, :deskripsi, :file_data)");
    $stmt->bindParam(':nama_file', $nama_file);
    $stmt->bindParam(':deskripsi', $deskripsi);
    $stmt->bindParam(':file_data', $fileData, PDO::PARAM_LOB);
    $stmt->execute();

    // Berhasil disimpan ke database
    echo "<script>
        alert('File berhasil disimpan ke database!');
        window.location.href = '{$_SERVER['HTTP_REFERER']}'; // Kembali ke halaman sebelumnya
      </script>";
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
