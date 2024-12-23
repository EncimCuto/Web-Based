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

if ($mesin !== 'glucose' && $bagian !== 'Master' && $bagian !== 'Produksi') {
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
            <li><a href="../../pages/glucose/glucose.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>"><i class="fas fa-tv"></i>Dashboard</a></li>
            <li><a href="../../pages/glucose/data-trend.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>"><i class="fa-solid fa-chart-line"></i>Data Trend</a></li>
            <li><a href="../../function/logout.php"><i class="fa-solid fa-right-from-bracket"></i>Logout</a></li>
        </ul>
        <h6>By <span id="date"></span></h6>
    </div>
</label>
<div class="container">
    <div class="header">
        <h2>GST 2</h2>
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
                const labels = (data.GST2 || []).map(item => item.waktu);
                const GST1Values = (data.GST1 || []).map(item => item.gst1);
                const GST2Values = (data.GST2 || []).map(item => item.gst2);
                const GST3Values = (data.GST3 || []).map(item => item.gst3);
                const GST4Values = (data.GST4 || []).map(item => item.gst4);
                const GST5Values = (data.GST5 || []).map(item => item.gst5);

                // Update chart dengan data baru
                updateChart(labels, GST1Values, GST2Values, GST3Values, GST4Values, GST5Values);
            })
            .catch(error => console.error('Error:', error));
    };

    function updateChart(labels, GST1Data, GST2Data, GST3Data, GST4Data, GST5Data) {
        const ctx = document.getElementById('myChart').getContext('2d');

        if (window.myChart && window.myChart instanceof Chart) {
            window.myChart.destroy();
        }

        window.myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels.map(formatDate),
                datasets: [{
                        label: 'GST 1',
                        data: GST1Data,
                        borderColor: 'rgba(75, 192, 192, 1)', // Cyan
                        backgroundColor: 'rgba(75, 192, 192, 0.1)',
                        borderWidth: 1,
                        fill: true,
                        hidden: !document.getElementById('data1').checked
                    },
                    {
                        label: 'GST 2',
                        data: GST2Data,
                        borderColor: 'rgba(255, 99, 132, 1)', // Red
                        backgroundColor: 'rgba(255, 99, 132, 0.1)',
                        borderWidth: 1,
                        fill: true,
                        hidden: !document.getElementById('data2').checked
                    },
                    {
                        label: 'GST 3',
                        data: GST3Data,
                        borderColor: 'rgba(54, 162, 235, 1)', // Blue
                        backgroundColor: 'rgba(54, 162, 235, 0.1)',
                        borderWidth: 1,
                        fill: true,
                        hidden: !document.getElementById('data3').checked
                    },
                    {
                        label: 'GST 4',
                        data: GST4Data,
                        borderColor: 'rgba(153, 102, 255, 1)', // Yellow
                        backgroundColor: 'rgba(153, 102, 255, 0.1)',
                        borderWidth: 1,
                        fill: true,
                        hidden: !document.getElementById('data4').checked
                    },
                    {
                        label: 'GST 5',
                        data: GST5Data,
                        borderColor: 'rgba(0, 128, 0, 1)', // Hijau
                        backgroundColor: 'rgba(0, 128, 0, 0.1)', // Hijau
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
        const data2Checkbox = document.getElementById('data2');
        if (data2Checkbox) {
            data2Checkbox.checked = true;
        }
    });

    document.getElementById("date").textContent = new Date().getFullYear();
</script>