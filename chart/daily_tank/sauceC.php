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

if ($mesin !== 'dissolver' && $bagian !== 'Master' && $bagian !== 'Produksi') {
    header('Location: ../../pages/dashboard.php?token=' . urlencode($_SESSION['token']) . '&error=not_allowed');
    exit;
}
?>

<link rel="shortcut icon" href="../../src/img/wings.png" type="image/x-icon">

<label>
    <div class="slide">
        <img src="../../src/img/kecap.png" alt="logo">
        <p>PT Bumi Alam Segar</p>
        <ul>
            <li><a href="../../pages/daily_tank/daily_tank.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>"><i class="fas fa-tv"></i>Dashboard</a></li>
            <li><a href="../../pages/daily_tank/data-trend.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>"><i class="fa-solid fa-chart-line"></i>Data Trend</a></li>
            <li><a href="../../function/logout.php"><i class="fa-solid fa-right-from-bracket"></i>Logout</a></li>
        </ul>
        <h6>By <span id="date"></span></h6>
    </div>
</label>
<div class="container">
    <div class="header">
        <h2>Soy Sauce C</h2>
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
                const labels = (data.DT_SoySauceC || []).map(item => item.waktu);
                const DT_ROValues = (data.DT_RO || []).map(item => item.RO);
                const DT_SaltValues = (data.DT_Salt || []).map(item => item.salt);
                const DT_SoySauceAValues = (data.DT_SoySauceA || []).map(item => item.sauceA);
                const DT_SoySauceBValues = (data.DT_SoySauceB || []).map(item => item.sauceB);
                const DT_SoySauceCValues = (data.DT_SoySauceC || []).map(item => item.sauceC);

                // Update chart dengan data baru
                updateChart(labels, DT_ROValues, DT_SaltValues, DT_SoySauceAValues, DT_SoySauceBValues, DT_SoySauceCValues);
            })
            .catch(error => console.error('Error:', error));
    };

    function updateChart(labels, DT_ROData, DT_SaltData, DT_SoySauceAData, DT_SoySauceBData, DT_SoySauceCData) {
        const ctx = document.getElementById('myChart').getContext('2d');

        if (window.myChart && window.myChart instanceof Chart) {
            window.myChart.destroy();
        }

        window.myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels.map(formatDate),
                datasets: [{
                        label: 'RO Water',
                        data: DT_ROData,
                        borderColor: 'rgba(75, 192, 192, 1)', // Cyan
                        backgroundColor: 'rgba(75, 192, 192, 0.1)',
                        borderWidth: 1,
                        fill: true,
                        hidden: !document.getElementById('data1').checked
                    },
                    {
                        label: 'Salt Water',
                        data: DT_SaltData,
                        borderColor: 'rgba(255, 99, 132, 1)', // Red
                        backgroundColor: 'rgba(255, 99, 132, 0.1)',
                        borderWidth: 1,
                        fill: true,
                        hidden: !document.getElementById('data2').checked
                    },
                    {
                        label: 'Soy Sauce A',
                        data: DT_SoySauceAData,
                        borderColor: 'rgba(54, 162, 235, 1)', // Blue
                        backgroundColor: 'rgba(54, 162, 235, 0.1)',
                        borderWidth: 1,
                        fill: true,
                        hidden: !document.getElementById('data3').checked
                    },
                    {
                        label: 'Soy Sauce B',
                        data: DT_SoySauceBData,
                        borderColor: 'rgba(255, 206, 86, 1)', // Yellow
                        backgroundColor: 'rgba(255, 206, 86, 0.1)',
                        borderWidth: 1,
                        fill: true,
                        hidden: !document.getElementById('data4').checked
                    },
                    {
                        label: 'Soy Sauce C',
                        data: DT_SoySauceCData,
                        borderColor: 'rgba(153, 102, 255, 1)', // Purple
                        backgroundColor: 'rgba(153, 102, 255, 0.1)',
                        borderWidth: 1,
                        fill: true,
                        hidden: !document.getElementById('data5').checked
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
        const data5Checkbox = document.getElementById('data5');
        if (data5Checkbox) {
            data5Checkbox.checked = true;
        }
    });

    document.getElementById("date").textContent = new Date().getFullYear();
</script>