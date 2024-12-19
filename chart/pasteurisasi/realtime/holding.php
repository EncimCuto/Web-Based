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

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../../src/img/wings.png" type="image/x-icon">
    <title>Realtime Suhu Holding</title>

    <!-- Tambahkan jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- Tambahkan Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../../../src/js/pasteurisasi/date.js"></script>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="header">
        <a href="../../../pages/pasteurisasi/realtime.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>"><button id="backBtn" class="back">Back</button></a>
        <div class="date">
            <span id="weekday"></span>, <span id="day"></span> <span id="month"></span>, <span id="year"></span>
            <span id="hour"></span>:<span id="minute"></span>:<span id="second"></span>
        </div>
    </div>

    <div class="chart-container">
        <!-- Canvas untuk Chart -->
        <canvas id="myChart" width="100%" height="30%"></canvas>
    </div>

    <script>
        // Buat variabel chart di luar agar bisa diakses secara global
        let myChart;
        let labels = [];
        let dataPoints = [];

        // Fungsi untuk memuat data dari server
        function loadData() {
            $.ajax({
                url: 'koneksi.php', // Panggil file PHP untuk mendapatkan data terbaru
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    console.log(data); // Debug: lihat data yang diterima

                    if (data.length > 0) {
                        let newestDataTime = new Date(data[data.length - 1].waktu);
                        let oneHoursAgo = new Date(newestDataTime.getTime() - 1 * 60 * 60 * 1000); // 1 jam yang lalu

                        labels = [];
                        dataPoints = [];

                        data.forEach(row => {
                            let rowTime = new Date(row.waktu);

                            if (rowTime >= oneHoursAgo) {
                                labels.push(row.waktu);
                                dataPoints.push(row.SuhuHolding);
                            }
                        });

                        labels.reverse();
                        dataPoints.reverse();

                        myChart.data.labels = labels;
                        myChart.data.datasets[0].data = dataPoints;
                        myChart.update();
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error loading data:", error);
                }
            });
        }

        // Inisialisasi chart pertama kali
        function initChart() {
            const ctx = document.getElementById('myChart').getContext('2d');
            myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Suhu Holding',
                        data: dataPoints,
                        borderColor: 'rgba(128, 0, 128, 1)', // Ungu tua
                        backgroundColor: 'rgba(128, 0, 128, 0.1)', // Ungu tua
                        borderWidth: 1,
                        fill: true
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                        },
                        x: {
                            reverse: true
                        }
                    }
                }
            });
        }

        // Panggil fungsi initChart saat halaman pertama kali dimuat
        $(document).ready(function() {
            initChart();
            loadData(); // Load data pertama kali
            setInterval(loadData, 1000); // Panggil fungsi loadData setiap detik untuk memperbarui data
        });
    </script>

</body>

</html>