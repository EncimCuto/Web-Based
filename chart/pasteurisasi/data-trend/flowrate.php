<?php

session_start();
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

<link rel="shortcut icon" href="../../../src/img/wings.png" type="image/x-icon">

<div class="slide">
    <img src="../../../src/img/kecap.png" alt="logo">
    <p>PT Bumi Alam Segar</p>
    <ul>
        <li><a href="../../../pages/pasteurisasi/pasteurisasi.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>"><i class="fas fa-tv"></i>Pasteurisasi</a></li>
        <li><a href="../../../pages/pasteurisasi/vaccum.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>"><i class="fa-solid fa-temperature-full"></i>Vaccum</a></li>
        <li><a href="../../../pages/pasteurisasi/mixing.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>"><i class="fa-solid fa-fan"></i>Mixing</a></li>
        <li><a href="../../../pages/pasteurisasi/data-trend.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>"><i class="fa-solid fa-chart-line"></i>Data Trend</a></li>
        <li><a href="../../../function/logout.php"><i class="fa-solid fa-right-from-bracket"></i>Logout</a></li>
    </ul>
    <h6>By <span id="date"></span></h6>
</div>
<div class="container">
    <div class="header">
        <h2>Flowrate</h2>
        <div class="user">
            <div class="akun">
                <p><?php echo htmlspecialchars($Nama); ?></p>
                <p><?php echo htmlspecialchars($bagian); ?></p>
            </div>
            <img src="../src/img/user.png" alt="user-logo">
        </div>
    </div>
    <?php include "template-pasteurizer.php" ?>
</div>

<script>
    document.getElementById('jam').addEventListener('click', function(e) {
        e.preventDefault();
        kirimRequest('jam.php');
    });

    // Fungsi untuk submit "Menit"
    document.getElementById('menit').addEventListener('click', function(e) {
        e.preventDefault();
        kirimRequest('menit.php');
    });

    // Fungsi untuk submit "Detik"
    document.getElementById('detik').addEventListener('click', function(e) {
        e.preventDefault();
        kirimRequest('detik.php');
    });

    // Fungsi untuk mengirim request ke file PHP
    function kirimRequest(phpFile) {
        const tanggalAwal = document.getElementById('tanggal-awal').value;
        const tanggalAkhir = document.getElementById('tanggal-akhir').value;

        // Ambil data checkbox yang dipilih
        const selectedData = Array.from(document.querySelectorAll('input[name="data"]:checked'))
            .map(checkbox => checkbox.value)
            .join(',');

        fetch(`../API/${phpFile}?tanggal-awal=${encodeURIComponent(tanggalAwal)}&tanggal-akhir=${encodeURIComponent(tanggalAkhir)}&data=${selectedData}`)
            .then(response => response.json())
            .then(data => { // Ganti $data dengan data
                console.log(data); // Log data received from the server

                if (!data || Object.keys(data).length === 0) { // Ganti $data dengan data
                    alert('Tidak ada data untuk ditampilkan.');
                    return;
                }

                // Siapkan label dan dataset berdasarkan data yang diterima
                const labels = (data.Flowrate || []).map(item => item.waktu);
                const SpeedPompaMixingValues = (data.SpeedPompaMixing || []).map(item => item.pumpmixing);
                const PressureMixingValues = (data.PressureMixing || []).map(item => item.pressuremix);
                const SuhuPreheatingValues = (data.SuhuPreheating || []).map(item => item.preheating);
                const LevelBT1Values = (data.LevelBT1 || []).map(item => item.levelBT1);
                const SpeedPumpBT1Values = (data.SpeedPumpBT1 || []).map(item => item.pumpBT1);
                const LevelVDValues = (data.LevelVD || []).map(item => item.levelVD);
                const SpeedPumpVDValues = (data.SpeedPumpVD || []).map(item => item.pumpVD);
                const FlowrateValues = (data.Flowrate || []).map(item => item.flowrate);
                const SuhuHeatingValues = (data.SuhuHeating || []).map(item => item.heating);
                const SuhuHoldingValues = (data.SuhuHolding || []).map(item => item.holding);
                const SuhuPrecoolingValues = (data.SuhuPrecooling || []).map(item => item.precooling);
                const LevelBT2Values = (data.LevelBT2 || []).map(item => item.levelBT2);
                const SpeedPumpBT2Values = (data.SpeedPumpBT2 || []).map(item => item.pumpBT2);
                const PressureBT2Values = (data.PressureBT2 || []).map(item => item.pressureBT2);
                const SuhuCoolingValues = (data.SuhuCooling || []).map(item => item.cooling);
                const PressToPasteurValues = (data.PressToPasteur || []).map(item => item.pasteur);
                const PressVDHHValues = (data.PressVDHH || []).map(item => item.VDHH);
                const PressVDLLValues = (data.PressVDLL || []).map(item => item.VDLL);
                const MixingAMValues = (data.MixingAM || []).map(item => item.mixing);
                const BT1AMValues = (data.BT1AM || []).map(item => item.bt1am);
                const VDAMValues = (data.VDAM || []).map(item => item.vdam);
                const PCV1Values = (data.PCV1 || []).map(item => item.pcv1);
                const TimeDivertValues = (data.TimeDivert || []).map(item => item.divert);

                // Update chart dengan data baru
                updateChart(labels, SpeedPompaMixingValues, PressureMixingValues, SuhuPreheatingValues, LevelBT1Values,
                    SpeedPumpBT1Values, LevelVDValues, SpeedPumpVDValues, FlowrateValues, SuhuHeatingValues, SuhuHoldingValues,
                    SuhuPrecoolingValues, LevelBT2Values, SpeedPumpBT2Values, PressureBT2Values, SuhuCoolingValues, PressToPasteurValues,
                    PressVDHHValues, PressVDLLValues, MixingAMValues, BT1AMValues, VDAMValues, PCV1Values, TimeDivertValues);
            })
            .catch(error => console.error('Error:', error));
    };

    function updateChart(labels, SpeedPompaMixingData, PressureMixingData, SuhuPreheatingData, LevelBT1Data,
        SpeedPumpBT1Data, LevelVDData, SpeedPumpVDData, FlowrateData, SuhuHeatingData, SuhuHoldingData,
        SuhuPrecoolingData, LevelBT2Data, SpeedPumpBT2Data, PressureBT2Data, SuhuCoolingData, PressToPasteurData,
        PressVDHHData, PressVDLLData, MixingAMData, BT1AMData, VDAMData, PCV1Data, TimeDivertData) {
        const ctx = document.getElementById('myChart').getContext('2d');

        if (window.myChart && window.myChart instanceof Chart) {
            window.myChart.destroy();
        }

        window.myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels.map(formatDate),
                datasets: [{
                        label: 'Speed Pompa Mixing',
                        data: SpeedPompaMixingData,
                        borderColor: 'rgba(75, 192, 192, 1)', // Cyan
                        backgroundColor: 'rgba(75, 192, 192, 0.1)',
                        borderWidth: 1,
                        fill: true,
                        hidden: !document.getElementById('data1').checked
                    },
                    {
                        label: 'Pressure Mixing',
                        data: PressureMixingData,
                        borderColor: 'rgba(54, 162, 235, 1)', // Blue
                        backgroundColor: 'rgba(54, 162, 235, 0.1)',
                        borderWidth: 1,
                        fill: true,
                        hidden: !document.getElementById('data2').checked
                    },
                    {
                        label: 'Suhu Preheating',
                        data: SuhuPreheatingData,
                        borderColor: 'rgba(255, 99, 132, 1)', // Red
                        backgroundColor: 'rgba(255, 99, 132, 0.1)',
                        borderWidth: 1,
                        fill: true,
                        hidden: !document.getElementById('data3').checked
                    },
                    {
                        label: 'Level BT 1',
                        data: LevelBT1Data,
                        borderColor: 'rgba(255, 206, 86, 1)', // Yellow
                        backgroundColor: 'rgba(255, 206, 86, 0.1)',
                        borderWidth: 1,
                        fill: true,
                        hidden: !document.getElementById('data4').checked
                    },
                    {
                        label: 'Speed Pump BT 1',
                        data: SpeedPumpBT1Data,
                        borderColor: 'rgba(165, 42, 42, 1)', // Coklat tua
                        backgroundColor: 'rgba(165, 42, 42, 0.1)', // Coklat tua
                        borderWidth: 1,
                        fill: true,
                        hidden: !document.getElementById('data5').checked
                    },
                    {
                        label: 'Level VD',
                        data: LevelVDData,
                        borderColor: 'rgba(255, 159, 64, 1)', // Orange
                        backgroundColor: 'rgba(255, 159, 64, 0.1)',
                        borderWidth: 1,
                        fill: true,
                        hidden: !document.getElementById('data6').checked
                    },
                    {
                        label: 'Speed Pump VD',
                        data: SpeedPumpVDData,
                        borderColor: 'rgba(30, 30, 30, 1)', // Hitam pekat
                        backgroundColor: 'rgba(30, 30, 30, 0.1)', // Hitam pekat
                        borderWidth: 1,
                        fill: true,
                        hidden: !document.getElementById('data7').checked
                    },
                    {
                        label: 'Flowrate',
                        data: FlowrateData,
                        borderColor: 'rgba(100, 149, 237, 1)', // Biru tua
                        backgroundColor: 'rgba(100, 149, 237, 0.1)', // Biru tua
                        borderWidth: 1,
                        fill: true,
                        hidden: !document.getElementById('data8').checked
                    },
                    {
                        label: 'Suhu Heating',
                        data: SuhuHeatingData,
                        borderColor: 'rgba(255, 127, 80, 1)', // Oranye terang
                        backgroundColor: 'rgba(255, 127, 80, 0.1)', // Oranye terang
                        borderWidth: 1,
                        fill: true,
                        hidden: !document.getElementById('data9').checked
                    },
                    {
                        label: 'Suhu Holding',
                        data: SuhuHoldingData,
                        borderColor: 'rgba(128, 0, 128, 1)', // Ungu tua
                        backgroundColor: 'rgba(128, 0, 128, 0.1)', // Ungu tua
                        borderWidth: 1,
                        fill: true,
                        hidden: !document.getElementById('data10').checked
                    },
                    {
                        label: 'Suhu Precooling',
                        data: SuhuPrecoolingData,
                        borderColor: 'rgba(0, 128, 0, 1)', // Hijau
                        backgroundColor: 'rgba(0, 128, 0, 0.1)', // Hijau
                        borderWidth: 1,
                        fill: true,
                        hidden: !document.getElementById('data11').checked
                    },
                    {
                        label: 'Level BT 2',
                        data: LevelBT2Data,
                        borderColor: 'rgba(153, 102, 255, 1)', // Light Purple
                        backgroundColor: 'rgba(153, 102, 255, 0.1)',
                        borderWidth: 1,
                        fill: true,
                        hidden: !document.getElementById('data12').checked
                    },
                    {
                        label: 'Speed Pump BT 2',
                        data: SpeedPumpBT2Data,
                        borderColor: 'rgba(255, 0, 0, 1)', // Merah
                        backgroundColor: 'rgba(255, 0, 0, 0.1)', // Merah
                        borderWidth: 1,
                        fill: true,
                        hidden: !document.getElementById('data13').checked
                    },
                    {
                        label: 'Pressure BT 2',
                        data: PressureBT2Data,
                        borderColor: 'rgba(0, 255, 0, 1)', // Hijau terang
                        backgroundColor: 'rgba(0, 255, 0, 0.2)', // Hijau terang
                        borderWidth: 1,
                        fill: true,
                        hidden: !document.getElementById('data14').checked
                    },
                    {
                        label: 'Suhu Cooling',
                        data: SuhuCoolingData,
                        borderColor: 'rgba(0, 0, 255, 1)', // Biru
                        backgroundColor: 'rgba(0, 0, 255, 0.1)', // Biru
                        borderWidth: 1,
                        fill: true,
                        hidden: !document.getElementById('data15').checked
                    },
                    {
                        label: 'Press To Pasteur',
                        data: PressToPasteurData,
                        borderColor: 'rgba(30, 144, 255, 1)', // Biru malam
                        backgroundColor: 'rgba(30, 144, 255, 0.5)', // Biru malam
                        borderWidth: 1,
                        fill: true,
                        hidden: !document.getElementById('data16').checked
                    },
                    {
                        label: 'VDHH',
                        data: PressVDHHData,
                        borderColor: 'rgba(46, 139, 87, 1)', // Hijau tua gelap
                        backgroundColor: 'rgba(46, 139, 87, 0.1)', // Hijau tua gelap
                        borderWidth: 1,
                        fill: true,
                        hidden: !document.getElementById('data17').checked
                    },
                    {
                        label: 'VDLL',
                        data: PressVDLLData,
                        borderColor: 'rgba(75, 192, 192, 1)', // Cyan
                        backgroundColor: 'rgba(75, 192, 192, 0.1)',
                        borderWidth: 1,
                        fill: true,
                        hidden: !document.getElementById('data18').checked
                    },
                    {
                        label: 'MixingAM',
                        data: MixingAMData,
                        borderColor: 'rgba(54, 162, 235, 1)', // Blue
                        backgroundColor: 'rgba(54, 162, 235, 0.1)',
                        borderWidth: 1,
                        fill: true,
                        hidden: !document.getElementById('data19').checked
                    },
                    {
                        label: 'BT1AM',
                        data: BT1AMData,
                        borderColor: 'rgba(255, 99, 132, 1)', // Red
                        backgroundColor: 'rgba(255, 99, 132, 0.1)',
                        borderWidth: 1,
                        fill: true,
                        hidden: !document.getElementById('data20').checked
                    },
                    {
                        label: 'VDAM',
                        data: VDAMData,
                        borderColor: 'rgba(255, 206, 86, 1)', // Yellow
                        backgroundColor: 'rgba(255, 206, 86, 0.1)',
                        borderWidth: 1,
                        fill: true,
                        hidden: !document.getElementById('data21').checked
                    },
                    {
                        label: 'PCV1',
                        data: PCV1Data,
                        borderColor: 'rgba(165, 42, 42, 1)', // Coklat tua
                        backgroundColor: 'rgba(165, 42, 42, 0.1)', // Coklat tua
                        borderWidth: 1,
                        fill: true,
                        hidden: !document.getElementById('data22').checked
                    },
                    {
                        label: 'Time Divert',
                        data: TimeDivertData,
                        borderColor: 'rgba(255, 159, 64, 1)', // Orange
                        backgroundColor: 'rgba(255, 159, 64, 0.1)',
                        borderWidth: 1,
                        fill: true,
                        hidden: !document.getElementById('data23').checked
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Waktu'
                        },
                        ticks: {
                            autoSkip: true,
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Nilai'
                        },
                        beginAtZero: false,
                    }
                }
            }
        });

    }

    function formatDate(dateTime) {
        const date = new Date(dateTime);
        const options = {
            year: 'numeric',
            month: 'short',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: false
        };
        return date.toLocaleString('id-ID', options);
    }

    document.addEventListener('DOMContentLoaded', function() {
        const data8Checkbox = document.getElementById('data8');
        if (data8Checkbox) {
            data8Checkbox.checked = true;
        }
    });

    document.getElementById("date").textContent = new Date().getFullYear();
</script>