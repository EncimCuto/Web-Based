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
$interval = $_GET['interval'] ?? ''; // Menangani parameter interval

// Validasi input tanggal
function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}

if (!validateDate($tanggal_awal) || (!empty($tanggal_akhir) && !validateDate($tanggal_akhir))) {
    die("Format tanggal tidak valid.");
}

if (empty($tanggal_awal) || empty($data_types)) {
    die("Parameter tanggal-awal atau data tidak ada.");
}

try {
    // Koneksi ke database
    $pdo = new PDO('mysql:host=localhost;dbname=olahsaridb', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Persiapkan query
    if ($interval === 'jam') {
        // Query 1: Data per jam tanpa rata-rata
        $query = "SELECT 
                      DATE_FORMAT(waktu, '%Y-%m-%d %H:00:00') AS waktu,
                      SUBSTRING_INDEX(GROUP_CONCAT(FeedPressure ORDER BY waktu), ',', 1) AS FeedPressure,
                      SUBSTRING_INDEX(GROUP_CONCAT(LevelFeedWater ORDER BY waktu), ',', 1) AS LevelFeedWater,
                      SUBSTRING_INDEX(GROUP_CONCAT(RHGuiloutine ORDER BY waktu), ',', 1) AS RHGuiloutine,
                  FROM readsensors 
                  WHERE waktu BETWEEN :tanggal_awal AND :tanggal_akhir 
                  GROUP BY DATE_FORMAT(waktu, '%Y-%m-%d %H:00:00')";
    } else {
        // Query default tanpa pengelompokan per jam
        $query = "SELECT waktu";
        foreach ($data_types as $type) {
            $query .= ", " . $type;
        }
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

    // Menambahkan data
    $row = 2;
    foreach ($results as $result) {
        $sheet->setCellValue('A' . $row, $result['waktu']);
        foreach ($data_types as $index => $type) {
            $sheet->setCellValue(chr(66 + $index) . $row, isset($result[$type]) ? round($result[$type], 2) : '');
        }
        $row++;
    }

    // Mengatur lebar kolom secara otomatis
    foreach (range('A', chr(65 + count($data_types))) as $columnID) {
        $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }

    // Mengatur header dan data menjadi center
    $sheet->getStyle('A1:' . chr(65 + count($data_types)) . '1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('A2:' . chr(65 + count($data_types)) . ($row - 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    // Menambahkan border ke seluruh tabel
    $sheet->getStyle('A1:' . chr(65 + count($data_types)) . ($row - 1))
        ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

    // Menyimpan file Excel
    $writer = new Xlsx($spreadsheet);
    $tanggal_awal_formatted = DateTime::createFromFormat('Y-m-d', $tanggal_awal)->format('d-m-Y');
    $tanggal_akhir_formatted = DateTime::createFromFormat('Y-m-d', $tanggal_akhir)->format('d-m-Y');
    $fileName = 'Data Olahsari ' . $tanggal_awal_formatted . ' hingga ' . $tanggal_akhir_formatted . '.xlsx';
    // Mengunduh file
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $fileName . '"');
    header('Cache-Control: max-age=0');
    $writer->save('php://output');
    exit;
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
