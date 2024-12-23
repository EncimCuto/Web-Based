<?php

require_once '../../function/koneksi_login.php';

if (!isset($_SESSION['token']) || $_SESSION['token'] !== $_GET['token']) {
    header('Location: ../../index.php');
    exit;
}

$Nama = $_SESSION['Nama'];
$bagian = $_SESSION['bagian'];
$mesin = $_SESSION['mesin'];

if ($mesin !== 'glucose' && $bagian !== 'Master' && $bagian !== 'Produksi') {
    header('Location: ../../pages/dashboard.php?token=' . urlencode($_SESSION['token']) . '&error=not_allowed');
    exit;
}
?>

<title>Glucose</title>
<link rel="shortcut icon" href="../../src/img/wings.png" type="image/x-icon">
<link rel="stylesheet" href="../../src/css/glucose/chart.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<style>
    @media (max-width: 750px) {
        .slide img {
            width: 80%;
            margin-left: 20px;
            border-radius: 100%;
        }

        ul li {
            list-style: none;
            border-radius: 100px;
            padding: 10px 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: 20%;
        }

        ul li a {
            font-size: 0;
            display: flex;
            justify-content: center;
            /* Mengatur posisi horizontal ke tengah */
            align-items: center;
            /* Mengatur posisi vertikal ke tengah */
            height: 100%;
            /* Pastikan elemen <a> menyesuaikan tinggi container */
        }

        ul li a i {
            font-size: 20px;
            /* Menjaga ukuran ikon */
        }

    }

    @media (min-width: 751px) and (max-width: 1130px) {
        .slide img {
            width: 80%;
            margin-left: 15px;
            border-radius: 100%;
        }

        ul li {
            list-style: none;
            border-radius: 100px;
            padding: 10px 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: 20%;
        }

        ul li a {
            font-size: 10px;
            display: flex;
            justify-content: center;
            /* Mengatur posisi horizontal ke tengah */
            align-items: center;
            /* Mengatur posisi vertikal ke tengah */
            height: 100%;
            /* Pastikan elemen <a> menyesuaikan tinggi container */
        }

        ul li a i {
            font-size: 18px;
            /* Menjaga ukuran ikon */
        }

    }
</style>

<div class="info">
    <div class="dropdown">
        <button class="dropbtn">Select an Option</button>
        <div class="dropdown-content">
            <a href="./GST1.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">GST 1</a>
            <a href="./GST2.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">GST 2</a>
            <a href="./GST3.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">GST 3</a>
            <a href="./GST4.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">GST 4</a>
            <a href="./GST5.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">GST 5</a>
        </div>
    </div>

    <form id="dateForm">
        <label for="tanggal-awal">Pilih Tanggal Awal:</label>
        <input type="date" name="tanggal-awal" id="tanggal-awal" required>

        <label for="tanggal-akhir">Pilih Tanggal Akhir:</label>
        <input type="date" name="tanggal-akhir" id="tanggal-akhir" required>

        <input type="submit" id="jam" value="Jam">
        <input type="submit" id="menit" value="Menit">
        <input type="submit" id="detik" value="Detik">
        <input type="button" id="exportExcel" value="Export-Excel">
        <!-- <button id="download-pdf">
            <i class="fa-solid fa-print"></i> Export-PDF
        </button> -->
    </form>

    <div class="stats">
        <p id="avgLevel"></p>
        <p id="maxLevel"></p>
        <p id="minLevel"></p>
    </div>

    <div class="checkbox-wrapper">
        <input type="checkbox" id="data1" name="data" value="GST1">
        <label for="data1">GST 1</label>

        <input type="checkbox" id="data2" name="data" value="GST2">
        <label for="data2">GST 2</label>

        <input type="checkbox" id="data3" name="data" value="GST3">
        <label for="data3">GST 3</label>

        <input type="checkbox" id="data4" name="data" value="GST4">
        <label for="data4">GST 4</label>

        <input type="checkbox" id="data5" name="data" value="GST5">
        <label for="data5">GST 5</label>
    </div>

    <div class="chart">
        <canvas id="myChart" width="100%" height="30%"></canvas>
    </div>
</div>

</div>

<script>
    // document.getElementById('download-pdf').addEventListener('click', function(e) {
    //     e.preventDefault();
    //     exportpdf();
    // });

    // function exportpdf() {
    //     // Ambil data input dari tanggal awal dan tanggal akhir
    //     const tanggalAwal = document.getElementById('tanggal-awal').value;
    //     const tanggalAkhir = document.getElementById('tanggal-akhir').value;

    //     // Ambil data checkbox yang dipilih
    //     const selectedData = Array.from(document.querySelectorAll('input[name="data"]:checked'))
    //         .map(checkbox => checkbox.value)
    //         .join(',');

    //     // Menggunakan html2canvas untuk menangkap konten elemen chart
    //     html2canvas(document.getElementById('myChart')).then(function(canvas) {
    //         const dataURL = canvas.toDataURL('image/png'); // Mengubah canvas menjadi data URL

    //         // Pastikan jsPDF diinisialisasi dengan benar
    //         const {
    //             jsPDF
    //         } = window.jspdf; // Mengambil jsPDF dari objek global

    //         // Membuat instance jsPDF dengan ukuran A4 landscape
    //         const pdf = new jsPDF('landscape', 'mm', 'a4'); // Orientasi landscape, unit mm, ukuran A4

    //         // Menambahkan gambar canvas ke PDF
    //         pdf.addImage(dataURL, 'PNG', 5, 40, 285, 130); // Posisi dan ukuran gambar di PDF
    //         let fileName = `chart_${tanggalAwal}_hingga_${tanggalAkhir}.pdf`;

    //         // Simpan PDF dengan nama yang baru
    //         pdf.save(fileName);
    //     });
    // }

    document.getElementById('exportExcel').addEventListener('click', function(e) {
        e.preventDefault();
        exportData('');
    });

    document.getElementById('exportJam').addEventListener('click', function(e) {
        e.preventDefault();
        exportData('jam');
    });

    function exportData(interval) {
        const tanggalAwal = document.getElementById('tanggal-awal').value;
        const tanggalAkhir = document.getElementById('tanggal-akhir').value;

        // Ambil data checkbox yang dipilih
        const selectedData = Array.from(document.querySelectorAll('input[name="data"]:checked'))
            .map(checkbox => checkbox.value)
            .join(',');

        // Arahkan pengguna ke URL PHP untuk mengunduh file Excel
        let url = `../../function/glucose/export_data.php?tanggal-awal=${encodeURIComponent(tanggalAwal)}&tanggal-akhir=${encodeURIComponent(tanggalAkhir)}&data=${selectedData}&token=${encodeURIComponent('<?php echo $_SESSION['token']; ?>')}`;

        // Tambahkan parameter interval jika ada
        if (interval) {
            url += `&interval=${interval}`;
        }

        window.location.href = url;
    }
</script>