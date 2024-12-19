<?php
// Memanggil fpdf.php
require('../../libraries/fpdf.php'); // Sesuaikan dengan path jika diperlukan

class PDF extends FPDF
{
    // Page header
    function Header()
    {
        // Membuat sel untuk gambar
        $this->Cell(75, 15, '', 'RTL', 0, 'L'); // Ruang untuk gambar
        $this->Image('../../src/img/boiler/logo.png', 15, 5.5, 50); // X, Y, Width

        // Mengatur font untuk judul
        $this->SetFont('Times', 'B', 14);

        // Judul di tengah
        $this->Cell(160, 7.5, 'ENGINEERING UTILITY', 'BTL', 0, 'C'); // Judul

        // Mengatur font untuk tanggal
        $this->SetFont('Times', '', 10);

        // Sel untuk label "Date"
        $this->Cell(54, 5, 'Date:', 'T', 0, 'L'); // Hanya garis di sisi kanan

        // Mengambil tanggal saat ini
        $this->SetFont('Times', 'B', 14);
        $currentDate = date('d/m/Y'); // Format: DD/MM/YYYY
        $this->Cell(-54, 15, $currentDate, 'RL', 0, 'C'); // Tampilkan tanggal di tengah

        // Pindah ke baris berikutnya
        $this->Ln(); // Pindah ke baris berikutnya untuk subjudul

        // Mengatur font untuk subjudul
        $this->SetFont('Times', 'B', 12);
        $this->Cell(75); // Memberikan jarak dari gambar
        // Subjudul di tengah
        $this->Cell(160, -7, 'LAPORAN OPERASIONAL BOILER', '', 0, 'C'); // Subjudul

        // Garis pemisah setelah header
        $this->Ln(0.1);
        $this->Cell(289, 4, '', 1, 0, '');

        $this->Ln();

        $this->SetFont('Times', 'B', 7);
        $this->Cell(15, 10, 'JAM', 1, 0, 'C');
        $this->Cell(15, 5, 'Steam', 1, 0, 'C');
        $this->Cell(75, 5, 'SPEED ( rpm )', 1, 0, 'C');
        $this->Cell(20, 5, 'WATER FLOW', 1, 0, 'C');
        $this->Cell(45, 5, 'WATER HMI', 1, 0, 'C');
        $this->Cell(45, 5, 'GAS LEVEL', 1, 0, 'C');
        $this->Cell(27, 5, 'Guillotine Height', 1, 0, 'C');
        $this->Cell(27, 5, 'Bura Back Temp', 1, 0, 'C');
        $this->Cell(20, 20, 'Suhu Feed Tank', 1, 0, 'C');

        $this->Ln(5);

        $this->Cell(15, 5, '', 0, 0, 'C');
        $this->Cell(15, 5, 'Press', 1, 0, 'C');
        $this->Cell(45, 5, 'FAN', 1, 0, 'C');
        $this->Cell(30, 5, 'STOCKER', 1, 0, 'C');
        $this->Cell(20, 5, 'Total Count', 1, 0, 'C');
        $this->Cell(15, 5, 'Level', 1, 0, 'C');
        $this->Cell(15, 5, 'Flow Rate', 1, 0, 'C');
        $this->Cell(15, 5, 'Total Count', 1, 0, 'C');
        $this->Cell(15, 5, 'O2', 1, 0, 'C');
        $this->Cell(15, 5, 'CO2', 1, 0, 'C');
        $this->Cell(15, 5, 'Flue Gass', 1, 0, 'C');
        $this->Cell(13.5, 5, 'LH', 1, 0, 'C');
        $this->Cell(13.5, 5, 'RH', 1, 0, 'C');
        $this->Cell(13.5, 5, 'LH', 1, 0, 'C');
        $this->Cell(13.5, 5, 'RH', 1, 0, 'C');


        $this->Ln();
        $this->Cell(15, 10, 'STD', 1, 0, 'C');
        $this->Cell(15, 10, '(Bar)', 1, 0, 'C');
        $this->Cell(15, 5, 'ID', 1, 0, 'C');
        $this->Cell(15, 5, 'LH FD', 1, 0, 'C');
        $this->Cell(15, 5, 'RH FN', 1, 0, 'C');
        $this->Cell(15, 5, 'LH', 1, 0, 'C');
        $this->Cell(15, 5, 'RH', 1, 0, 'C');
        $this->Cell(20, 10, '( m3/h )', 1, 0, 'C');
        $this->Cell(15, 5, '( % )', 1, 0, 'C');
        $this->Cell(15, 10, '( m3 )', 1, 0, 'C');
        $this->Cell(15, 10, '( m3/h )', 1, 0, 'C');
        $this->Cell(15, 10, '( % )', 1, 0, 'C');
        $this->Cell(15, 10, '( % )', 1, 0, 'C');
        $this->Cell(15, 10, 'Temp', 1, 0, 'C');
        $this->Cell(13.5, 5, '( mm )', 1, 0, 'C');
        $this->Cell(13.5, 5, '( mm )', 1, 0, 'C');
        $this->Cell(13.5, 5, '( 0C )', 1, 0, 'C');
        $this->Cell(13.5, 5, '( 0C )', 1, 0, 'C');

        $this->Ln();
        $this->Cell(30, 5, '', 0, 0, 'C');
        $this->Cell(15, 5, 'Max 22', 1, 0, 'C');
        $this->Cell(15, 5, 'Max 20', 1, 0, 'C');
        $this->Cell(15, 5, 'Max 20', 1, 0, 'C');
        $this->Cell(15, 5, 'Max 27', 1, 0, 'C');
        $this->Cell(15, 5, 'Max 27', 1, 0, 'C');
        $this->Cell(20, 5, '', 0, 0, 'C');
        $this->Cell(15, 5, '50 - 60%', 1, 0, 'C');
        $this->Cell(15, 5, '', 0, 0, 'C');
        $this->Cell(15, 5, '', 0, 0, 'C');
        $this->Cell(15, 5, '', 0, 0, 'C');
        $this->Cell(15, 5, '', 0, 0, 'C');
        $this->Cell(15, 5, '', 0, 0, 'C');
        $this->Cell(27, 5, 'Max 140', 1, 0, 'C');
        $this->Cell(27, 5, '150 - 200', 1, 0, 'C');
        $this->Cell(20, 5, '', 0, 0, 'C');
        $this->Ln();
    }
    // Content Table
    function ContentTable($data)
    {
        $this->SetFont('Times', '', 9);

        // Looping data tiap jam dari array $data
        foreach ($data as $time => $row) {
            $this->Cell(15, 5, $time, 1, 0, 'R'); // Kolom waktu (jam)
            $this->Cell(15, 5, $row['PVSteam'] ?? '', 1, 0, 'C');
            $this->Cell(15, 5, $row['IDFan'] ?? '', 1, 0, 'C');
            $this->Cell(15, 5, $row['LHFDFan'] ?? '', 1, 0, 'C');
            $this->Cell(15, 5, $row['RHFDFan'] ?? '', 1, 0, 'C');
            $this->Cell(15, 5, $row['LHStoker'] ?? '', 1, 0, 'C');
            $this->Cell(15, 5, $row['RHStoker'] ?? '', 1, 0, 'C');
            $this->Cell(20, 5, $row['Water_Flow'] ?? '', 1, 0, 'C');
            $this->Cell(15, 5, $row['LevelFeedWater'] ?? '', 1, 0, 'C');
            $this->Cell(15, 5, $row['InletWaterFlow'] ?? '', 1, 0, 'C');
            $this->Cell(15, 5, $row['Flow_Rate'] ?? '', 1, 0, 'C');
            $this->Cell(15, 5, $row['O2'] ?? '', 1, 0, 'C');
            $this->Cell(15, 5, $row['CO2'] ?? '', 1, 0, 'C');
            $this->Cell(15, 5, $row['Flue_Gas'] ?? '', 1, 0, 'C');
            $this->Cell(13.5, 5, $row['LHGuiloutine'] ?? '', 1, 0, 'C');
            $this->Cell(13.5, 5, $row['RHGuiloutine'] ?? '', 1, 0, 'C');
            $this->Cell(13.5, 5, $row['LHTemp'] ?? '', 1, 0, 'C');
            $this->Cell(13.5, 5, $row['RHTemp'] ?? '', 1, 0, 'C');
            $this->Cell(20, 5, $row['SuhuFeedTank'] ?? '', 1, 0, 'C');
            $this->Ln();
        }
    }
    function Footer()
    {
        $this->SetFont('Times', 'B', 9);
        $this->Cell(289, 5, 'NOTE:', '', 0, 'L');
        $this->Cell(-289, 13, '', 1, 0, 'L');

        $this->Ln();
        $this->Cell(96.33, 4, 'Dibuat Oleh', 'RBL', 0, 'C');
        $this->Cell(96.33, 4, 'Diperiksa Oleh', 'RBL', 0, 'C');
        $this->Cell(96.33, 4, 'Disetujui Oleh', 'RBL', 0, 'C');

        $this->Ln();
        $this->Cell(96.33, 20, '', 'RBL', 0, 'C');
        $this->Cell(96.33, 20, '', 'RBL', 0, 'C');
        $this->Cell(96.33, 20, '', 'RBL', 0, 'C');

        $this->Ln();
        $this->Cell(96.33, 4, 'Operator Utility', 'RBL', 0, 'C');
        $this->Cell(96.33, 4, 'Staff Engineering Utility', 'RBL', 0, 'C');
        $this->Cell(96.33, 4, 'SPV Engineering Utility', 'RBL', 0, 'C');

        $this->Ln(5);
        $this->Cell(289.5, 4, 'FRM/EUT/01/001/002-05', 0, 0, 'R');
    }
}

// Menginisialisasi PDF
$pdf = new PDF('L');
$pdf->SetMargins(4, 4, 3);
$pdf->AliasNbPages();
$pdf->AddPage();

// Mengambil data dari database
include_once './koneksi.php'; // Pastikan koneksi sudah benar

$today = date("Y-m-d");
$data = [];

// Mengambil data dari jam 00:00 hingga 23:00
for ($i = 0; $i < 24; $i++) {  // Loop dari jam 0 pagi sampai jam 23 malam
    $hour = $i;  // Tidak perlu modulus karena kita hanya ingin 0-23
    $timeString = str_pad($hour, 2, "0", STR_PAD_LEFT) . ":00";
    $date = $today;

    $sql = "SELECT * FROM readsensors WHERE waktu = '$date $timeString' LIMIT 1";
    $result = $koneksi->query($sql);

    if ($result && $result->num_rows > 0) {
        $data[$timeString] = $result->fetch_assoc();
    } else {
        $data[$timeString] = [
            'PVSteam' => '',
            'IDFan' => '',
            'LHFDFan' => '',
            'RHFDFan' => '',
            'LHStoker' => '',
            'RHStoker' => '',
            'Water_Flow' => '',
            'LevelFeedWater' => '',
            'InletWaterFlow' => '',
            'Flow_Rate' => '',
            'O2' => '',
            'CO2' => '',
            'Flue_Gas' => '',
            'LHGuiloutine' => '',
            'RHGuiloutine' => '',
            'LHTemp' => '',
            'RHTemp' => '',
            'SuhuFeedTank' => ''
        ];
    }
}

include_once './koneksi.php';
date_default_timezone_set('Asia/Jakarta');

// Mengambil jam dan tanggal saat ini
$currentHour = date('H');
$currentDate = date('Y-m-d');

// Menampilkan data pada tabel PDF
$pdf->ContentTable($data);

// Generate PDF output
$pdfOutput = $pdf->Output('S');
$pdfFilename = "Operasional Boiler " . date('Y-m-d') . ".pdf";

// Cek ukuran PDF
if (strlen($pdfOutput) > 0) {
    error_log("PDF generated successfully, size: " . strlen($pdfOutput) . " bytes.");
} else {
    error_log("PDF generation failed.");
    exit;
}

error_log("Current hour: $currentHour, Data count: " . count($data));
if ($currentHour == 5 || count($data) === 24) {
    $checkSql = "SELECT * FROM form_boiler WHERE DATE(created_at) = ?";
    $stmt = $koneksi->prepare($checkSql);
    $stmt->bind_param('s', $currentDate);
    $stmt->execute();
    $checkResult = $stmt->get_result();

    if ($checkResult->num_rows === 0) {
        $sql = "INSERT INTO form_boiler (pdf_file, file_name, created_at) VALUES (?, ?, ?)";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param('bss', $pdfOutput, $pdfFilename, $currentTimestamp);
    } else {
        $sql = "UPDATE form_boiler SET pdf_file = ?, file_name = ?, created_at = ? WHERE DATE(created_at) = ?";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param('bsss', $pdfOutput, $pdfFilename, $currentTimestamp, $currentDate);
    }

    if (!$stmt) {
        error_log("Error preparing statement: " . $koneksi->error);
        exit;
    }

    $stmt->send_long_data(0, $pdfOutput);

    if ($stmt->execute()) {
        error_log("PDF saved to database successfully.");
    } else {
        error_log("Error saving PDF to database: " . $stmt->error);
    }
} else {
    error_log("Condition not met for saving PDF.");
}

// Output the PDF to the browser
$pdf->Output();
