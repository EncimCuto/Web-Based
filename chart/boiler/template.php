<?php

// session_start();
require_once '../../function/koneksi_login.php';

if (!isset($_SESSION['token']) || $_SESSION['token'] !== $_GET['token']) {
    header('Location: ../../index.php');
    exit;
}

$Nama = $_SESSION['Nama'];
$bagian = $_SESSION['bagian'];
$mesin = $_SESSION['mesin'];

if ($mesin !== 'boiler' && $bagian !== 'Master') {
    header('Location: ../page/dashboard.php?token=' . urlencode($_SESSION['token']) . '&error=not_allowed');
    exit;
}

?>

<title>Boiler</title>
<link rel="shortcut icon" href="../../src/img/wings.png" type="image/x-icon">
<link rel="stylesheet" href="../../src/css/boiler/chart.css">
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
            <a href="./level-feed-water.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">Level Feed Water</a>
            <a href="./pv-steam.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">PV Steam</a>
            <a href="./feed-pressure.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">Feed Pressure</a>
            <a href="./lhguil.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">LH Guiloutine</a>
            <a href="./rhguil.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">RH Guiloutine</a>
            <a href="./lh-temp.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">LH Temp</a>
            <a href="./rh-temp.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">RH Temp</a>
            <a href="./idfan.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">IDFan</a>
            <a href="./lhfd.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">LHFDFan</a>
            <a href="./rhfd.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">RHFDFan</a>
            <a href="./lhs.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">LH Stoker</a>
            <a href="./rhs.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">RH Stoker</a>
            <a href="./waterpump1.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">Water Pump 1</a>
            <a href="./waterpump2.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">Water Pump 2</a>
            <a href="./inletwater.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">Inlet Water Flow</a>
            <a href="./outletsteam.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">Outlet Steam Flow</a>
            <a href="./suhufeed.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">Suhu Feed Tank</a>
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
        <button id="download-pdf">
            <i class="fa-solid fa-print"></i> Export-PDF
        </button>
    </form>

    <div class="stats">
        <p id="avgLevel"></p>
        <p id="maxLevel"></p>
        <p id="minLevel"></p>
    </div>

    <div class="checkbox-wrapper">
        <input type="checkbox" id="pvsteam" name="data" value="PVSteam">
        <label for="pvsteam">PV Steam</label>

        <input type="checkbox" id="feedPressure" name="data" value="FeedPressure">
        <label for="feedPressure">Feed Pressure</label>

        <input type="checkbox" id="feedWater" name="data" value="LevelFeedWater">
        <label for="feedWater">Level Feed Water</label>

        <input type="checkbox" id="idfan" name="data" value="IDFan">
        <label for="idfan">ID Fan</label>

        <input type="checkbox" id="lhg" name="data" value="LHGuiloutine">
        <label for="lhg">LH Guiloutine</label>

        <input type="checkbox" id="rhg" name="data" value="RHGuiloutine">
        <label for="rhg">RH Guiloutine</label>

        <input type="checkbox" id="lh" name="data" value="LHTemp">
        <label for="lh">LH Temp</label>

        <input type="checkbox" id="data4" name="data" value="RHTemp">
        <label for="data4">RH Temp</label>

        <input type="checkbox" id="data5" name="data" value="LHFDFan">
        <label for="data5">LHFDFan</label>

        <input type="checkbox" id="data6" name="data" value="RHFDFan">
        <label for="data6">RHFDFan</label>

        <input type="checkbox" id="data7" name="data" value="LHStoker">
        <label for="data7">LH Stoker</label>

        <input type="checkbox" id="data8" name="data" value="RHStoker">
        <label for="data8">RH Stoker</label>

        <input type="checkbox" id="data9" name="data" value="WaterPump1">
        <label for="data9">Water Pump 1</label>

        <input type="checkbox" id="data10" name="data" value="WaterPump2">
        <label for="data10">Water Pump 2</label>

        <input type="checkbox" id="data11" name="data" value="InletWaterFlow">
        <label for="data11">Inlet Water Flow</label>

        <input type="checkbox" id="data12" name="data" value="OutletSteamFlow">
        <label for="data12">Outlet Steam Flow</label>

        <input type="checkbox" id="data13" name="data" value="SuhuFeedTank">
        <label for="data13">Suhu Feed Tank</label>
    </div>

    <div class="chart">
        <canvas id="myChart" width="100%" height="30%"></canvas>
    </div>
</div>

</div>

<script>
    document.getElementById('download-pdf').addEventListener('click', function(e) {
        e.preventDefault();
        exportpdf();
    });

    function exportpdf() {
        // Ambil data input dari tanggal awal dan tanggal akhir
        const tanggalAwal = document.getElementById('tanggal-awal').value;
        const tanggalAkhir = document.getElementById('tanggal-akhir').value;

        // Fungsi untuk memformat tanggal menjadi dd-mm-yyyy
        function formatTanggal(tanggal) {
            const [year, month, day] = tanggal.split('-');
            return `${day}-${month}-${year}`;
        }

        // Format ulang tanggal ke dd-mm-yyyy
        const formattedTanggalAwal = formatTanggal(tanggalAwal);
        const formattedTanggalAkhir = formatTanggal(tanggalAkhir);

        // Ambil data checkbox yang dipilih
        const selectedData = Array.from(document.querySelectorAll('input[name="data"]:checked'))
            .map(checkbox => checkbox.value)
            .join(',');

        // Menggunakan html2canvas untuk menangkap konten elemen chart
        html2canvas(document.getElementById('myChart')).then(function(canvas) {
            const dataURL = canvas.toDataURL('image/png'); // Mengubah canvas menjadi data URL

            // Pastikan jsPDF diinisialisasi dengan benar
            const {
                jsPDF
            } = window.jspdf; // Mengambil jsPDF dari objek global

            // Membuat instance jsPDF dengan ukuran A4 landscape
            const pdf = new jsPDF('landscape', 'mm', 'a4'); // Orientasi landscape, unit mm, ukuran A4

            // Menambahkan gambar canvas ke PDF
            pdf.addImage(dataURL, 'PNG', 5, 40, 285, 130); // Posisi dan ukuran gambar di PDF

            // Format nama file
            let fileName = `Data Boiler ${formattedTanggalAwal} hingga ${formattedTanggalAkhir}.pdf`;

            // Simpan PDF dengan nama yang baru
            pdf.save(fileName);
        });
    }

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
        let url = `../../function/boiler/export_data.php?tanggal-awal=${encodeURIComponent(tanggalAwal)}&tanggal-akhir=${encodeURIComponent(tanggalAkhir)}&data=${selectedData}&token=${encodeURIComponent('<?php echo $_SESSION['token']; ?>')}`;

        // Tambahkan parameter interval jika ada
        if (interval) {
            url += `&interval=${interval}`;
        }

        window.location.href = url;
    }
</script>