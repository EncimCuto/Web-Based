<?php

require_once '../../../function/koneksi_login.php';

if (!isset($_SESSION['token']) || $_SESSION['token'] !== $_GET['token']) {
    header('Location: ../index.php');
    exit;
}

$Nama = $_SESSION['Nama'];
$bagian = $_SESSION['bagian'];
$mesin = $_SESSION['mesin'];

if ($mesin !== 'pasteurisasi' && $bagian !== 'Master' && $bagian !== 'Produksi') {
    header('Location: ../../../pages/dashboard.php?token=' . urlencode($_SESSION['token']) . '&error=not_allowed');
    exit;
}
?>

<title>Pasteurisasi</title>
<link rel="shortcut icon" href="../../../src/img/wings.png" type="image/x-icon">
<link rel="stylesheet" href="../../../src/css/pasteurisasi/trend.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
            <a href="./pumpBT1.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">Speed Pump BT 1</a>
            <a href="./levelBT1.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">Level BT 1</a>
            <a href="./BT1AM.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">BT 1 AM</a>
            <a href="./pumpVD.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">Speed Pump VD</a>
            <a href="./levelVD.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">Level VD</a>
            <a href="./VDAM.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">VD AM</a>
            <a href="./VDHH.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">Press VDHH</a>
            <a href="./VDLL.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">Press VDLL</a>
            <a href="./press-to-pasteur.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">Press To Pasteur</a>
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
    </form>

    <div class="stats">
        <p id="avgLevel"></p>
        <p id="maxLevel"></p>
        <p id="minLevel"></p>
    </div>

    <div class="checkbox-wrapper">
        <input type="checkbox" id="data1" name="data" value="SpeedPompaMixing">
        <label for="data1">Speed Pompa Mixing</label>
        
        <input type="checkbox" id="data2" name="data" value="PressureMixing">
        <label for="data2">Pressure Mixing</label>

        <input type="checkbox" id="data3" name="data" value="SuhuPreheating">
        <label for="data3">Suhu Preheating</label>

        <input type="checkbox" id="data4" name="data" value="LevelBT1">
        <label for="data4">Level BT 1</label>

        <input type="checkbox" id="data5" name="data" value="SpeedPumpBT1">
        <label for="data5">Speed Pump BT 1</label>

        <input type="checkbox" id="data6" name="data" value="LevelVD">
        <label for="data6">Level VD</label>

        <input type="checkbox" id="data7" name="data" value="SpeedPumpVD">
        <label for="data7">Speed Pump VD</label>

        <input type="checkbox" id="data8" name="data" value="Flowrate">
        <label for="data8">Flowrate</label>

        <input type="checkbox" id="data9" name="data" value="SuhuHeating">
        <label for="data9">Suhu Heating</label>

        <input type="checkbox" id="data10" name="data" value="SuhuHolding">
        <label for="data10">Suhu Holding</label>

        <input type="checkbox" id="data11" name="data" value="SuhuPrecooling">
        <label for="data11">Suhu Precooling</label>

        <input type="checkbox" id="data12" name="data" value="LevelBT2">
        <label for="data12">Level BT 2</label>

        <input type="checkbox" id="data13" name="data" value="SpeedPumpBT2">
        <label for="data13">Speed Pump BT 2</label>

        <input type="checkbox" id="data14" name="data" value="PressureBT2">
        <label for="data14">Pressure BT 2</label>

        <input type="checkbox" id="data15" name="data" value="SuhuCooling">
        <label for="data15">Suhu Cooling</label>

        <input type="checkbox" id="data16" name="data" value="PressToPasteur">
        <label for="data16">Press To Pasteur</label>

        <input type="checkbox" id="data17" name="data" value="PressVDHH">
        <label for="data17">VDHH</label>

        <input type="checkbox" id="data18" name="data" value="PressVDLL">
        <label for="data18">VDLL</label>

        <input type="checkbox" id="data19" name="data" value="MixingAM">
        <label for="data19">MixingAM</label>

        <input type="checkbox" id="data20" name="data" value="BT1AM">
        <label for="data20">BT1AM</label>

        <input type="checkbox" id="data21" name="data" value="VDAM">
        <label for="data21">VDAM</label>

        <input type="checkbox" id="data22" name="data" value="PCV1">
        <label for="data22">PCV1</label>

        <input type="checkbox" id="data23" name="data" value="TimeDivert">
        <label for="data23">Time Divert</label>
    </div>

    <div class="chart">
        <canvas id="myChart" width="100%" height="30%"></canvas>
    </div>
</div>
<script>
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
        let url = `../../../function/pasteurisasi/export_data.php?tanggal-awal=${encodeURIComponent(tanggalAwal)}&tanggal-akhir=${encodeURIComponent(tanggalAkhir)}&data=${selectedData}&token=${encodeURIComponent('<?php echo $_SESSION['token']; ?>')}`;

        // Tambahkan parameter interval jika ada
        if (interval) {
            url += `&interval=${interval}`;
        }

        window.location.href = url;
    }
</script>