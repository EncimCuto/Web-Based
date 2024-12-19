<?php

session_start();
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

<link rel="shortcut icon" href="../../src/img/wings.png" type="image/x-icon">

<label>
    <div class="slide">
        <img src="../../src/img/kecap.png" alt="logo">
        <p>Boiler PT Bumi Alam Segar</p>
        <ul>
            <li><a href="../../pages/boiler/boiler.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>"><i class="fas fa-tv"></i>Dashboard</a></li>
            <li><a href="../../pages/boiler/data-trend.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>"><i class="fa-solid fa-chart-line"></i>Data Trend</a></li>
            <li><a href="../proses/logout.php"><i class="fa-solid fa-right-from-bracket"></i>Logout</a></li>
        </ul>
        <h6>By <span id="date"></span></h6>
    </div>
</label>
<div class="container">
    <div class="header">
        <h2>IDFAN</h2>
        <div class="user">
            <div class="akun">
            <p><?php echo htmlspecialchars($Nama); ?></p>
            <p><?php echo htmlspecialchars($bagian); ?></p>
            </div>
            <img src="../../src/img/user.png" alt="user-logo">
        </div>
    </div>
    <?php include "template.php" ?>
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

        fetch(`./API/${phpFile}?tanggal-awal=${encodeURIComponent(tanggalAwal)}&tanggal-akhir=${encodeURIComponent(tanggalAkhir)}&data=${selectedData}`)
            .then(response => response.json())
            .then(data => {
                console.log(data); // Log data received from the server

                if (!data || Object.keys(data).length === 0) {
                    alert('Tidak ada data untuk ditampilkan.');
                    return;
                }

                // Siapkan label dan dataset berdasarkan data yang diterima
                const labels = (data.IDFan || []).map(item => item.waktu);
                const feedPressureValues = (data.FeedPressure || []).map(item => item.pressure);
                const feedWaterValues = (data.LevelFeedWater || []).map(item => item.level);
                const pvSteamValues = (data.PVSteam || []).map(item => item.value);
                const idFanValues = (data.IDFan || []).map(item => item.idfan);

                // Additional Data Sets
                const lhgValues = (data.LHGuiloutine || []).map(item => item.lhg);
                const rhgValues = (data.RHGuiloutine || []).map(item => item.rhg);
                const data3Values = (data.LHTemp || []).map(item => item.lh);
                const data4Values = (data.RHTemp || []).map(item => item.rh);
                const data5Values = (data.LHFDFan || []).map(item => item.lhf);
                const data6Values = (data.RHFDFan || []).map(item => item.rhf);
                const data7Values = (data.LHStoker || []).map(item => item.lhs);
                const data8Values = (data.RHStoker || []).map(item => item.rhs);
                const data9Values = (data.WaterPump1 || []).map(item => item.pump1);
                const data10Values = (data.WaterPump2 || []).map(item => item.pump2);
                const data11Values = (data.InletWaterFlow || []).map(item => item.inwater);
                const data12Values = (data.OutletSteamFlow || []).map(item => item.outlet);
                const data13Values = (data.SuhuFeedTank || []).map(item => item.suhu);

                // Update chart dengan data baru
                updateChart(labels, feedPressureValues, feedWaterValues, pvSteamValues, idFanValues,
                    lhgValues, rhgValues, data3Values, data4Values, data5Values, data6Values, data7Values, data8Values,
                    data9Values, data10Values, data11Values, data12Values, data13Values);
            })
            .catch(error => console.error('Error:', error));
    };

    function updateChart(labels, feedPressureData, feedWaterData, pvSteamData, idFanData,
        lhgData, rhgData, data3, data4, data5, data6, data7, data8, data9, data10, data11, data12, data13) {
        const ctx = document.getElementById('myChart').getContext('2d');

        if (window.myChart && window.myChart instanceof Chart) {
            window.myChart.destroy();
        }

        window.myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels.map(formatDate),
                datasets: [{
                        label: 'Feed Pressure',
                        data: feedPressureData,
                        borderColor: 'rgba(75, 192, 192, 1)', // Cyan
                        backgroundColor: 'rgba(75, 192, 192, 0.1)',
                        borderWidth: 1,
                        fill: true,
                        hidden: !document.getElementById('feedPressure').checked
                    },
                    {
                        label: 'Level Feed Water',
                        data: feedWaterData,
                        borderColor: 'rgba(255, 99, 132, 1)', // Red
                        backgroundColor: 'rgba(255, 99, 132, 0.1)',
                        borderWidth: 1,
                        fill: true,
                        hidden: !document.getElementById('feedWater').checked
                    },
                    {
                        label: 'PV Steam',
                        data: pvSteamData,
                        borderColor: 'rgba(54, 162, 235, 1)', // Blue
                        backgroundColor: 'rgba(54, 162, 235, 0.1)',
                        borderWidth: 1,
                        fill: true,
                        hidden: !document.getElementById('pvsteam').checked
                    },
                    {
                        label: 'ID Fan',
                        data: idFanData,
                        borderColor: 'rgba(255, 206, 86, 1)', // Yellow
                        backgroundColor: 'rgba(255, 206, 86, 0.1)',
                        borderWidth: 1,
                        fill: true,
                        hidden: !document.getElementById('idfan').checked
                    },
                    {
                        label: 'LH Guiloutine',
                        data: lhgData,
                        borderColor: 'rgba(153, 102, 255, 1)', // Purple
                        backgroundColor: 'rgba(153, 102, 255, 0.1)',
                        borderWidth: 1,
                        fill: true,
                        hidden: !document.getElementById('lhg').checked
                    },
                    {
                        label: 'RH Guiloutine',
                        data: rhgData,
                        borderColor: 'rgba(255, 159, 64, 1)', // Orange
                        backgroundColor: 'rgba(255, 159, 64, 0.1)',
                        borderWidth: 1,
                        fill: true,
                        hidden: !document.getElementById('rhg').checked
                    },
                    {
                        label: 'LH Temp',
                        data: data3,
                        borderColor: 'rgba(201, 203, 207, 1)', // Grey
                        backgroundColor: 'rgba(201, 203, 207, 0.1)',
                        borderWidth: 1,
                        fill: true,
                        hidden: !document.getElementById('lh').checked
                    },
                    {
                        label: 'RH Temp',
                        data: data4,
                        borderColor: 'rgba(255, 99, 132, 1)', // Pink
                        backgroundColor: 'rgba(255, 99, 132, 0.1)',
                        borderWidth: 1,
                        fill: true,
                        hidden: !document.getElementById('data4').checked
                    },
                    {
                        label: 'LHFDFan',
                        data: data5,
                        borderColor: 'rgba(75, 192, 192, 1)', // Light Blue
                        backgroundColor: 'rgba(75, 192, 192, 0.1)',
                        borderWidth: 1,
                        fill: true,
                        hidden: !document.getElementById('data5').checked
                    },
                    {
                        label: 'RHFDFan',
                        data: data6,
                        borderColor: 'rgba(54, 162, 235, 1)', // Dark Blue
                        backgroundColor: 'rgba(54, 162, 235, 0.1)',
                        borderWidth: 1,
                        fill: true,
                        hidden: !document.getElementById('data6').checked
                    },
                    {
                        label: 'LH Stoker',
                        data: data7,
                        borderColor: 'rgba(255, 206, 86, 1)', // Light Yellow
                        backgroundColor: 'rgba(255, 206, 86, 0.1)',
                        borderWidth: 1,
                        fill: true,
                        hidden: !document.getElementById('data7').checked
                    },
                    {
                        label: 'RH Stoker',
                        data: data8,
                        borderColor: 'rgba(153, 102, 255, 1)', // Light Purple
                        backgroundColor: 'rgba(153, 102, 255, 0.1)',
                        borderWidth: 1,
                        fill: true,
                        hidden: !document.getElementById('data8').checked
                    },
                    {
                        label: 'Water Pump 1',
                        data: data9,
                        borderColor: 'rgba(255, 159, 64, 1)', // Light Orange
                        backgroundColor: 'rgba(255, 159, 64, 0.1)',
                        borderWidth: 1,
                        fill: true,
                        hidden: !document.getElementById('data9').checked
                    },
                    {
                        label: 'Water Pump 2',
                        data: data10,
                        borderColor: 'rgba(54, 162, 235, 1)', // Light Blue
                        backgroundColor: 'rgba(54, 162, 235, 0.1)',
                        borderWidth: 1,
                        fill: true,
                        hidden: !document.getElementById('data10').checked
                    },
                    {
                        label: 'Inlet Water Flow',
                        data: data11,
                        borderColor: 'rgba(75, 192, 192, 1)', // Light Cyan
                        backgroundColor: 'rgba(75, 192, 192, 0.1)',
                        borderWidth: 1,
                        fill: true,
                        hidden: !document.getElementById('data11').checked
                    },
                    {
                        label: 'Outlet Steam Flow',
                        data: data12,
                        borderColor: 'rgba(255, 206, 86, 1)', // Light Yellow
                        backgroundColor: 'rgba(255, 206, 86, 0.1)',
                        borderWidth: 1,
                        fill: true,
                        hidden: !document.getElementById('data12').checked
                    },
                    {
                        label: 'Suhu Feed Tank',
                        data: data13,
                        borderColor: 'rgba(54, 162, 235, 1)', // Light Blue
                        backgroundColor: 'rgba(54, 162, 235, 0.1)',
                        borderWidth: 1,
                        fill: true,
                        hidden: !document.getElementById('data13').checked
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
        const idfanCheckbox = document.getElementById('idfan');
        if (idfanCheckbox) {
            idfanCheckbox.checked = true;
        }
    });

    document.getElementById("date").textContent = new Date().getFullYear();
</script>