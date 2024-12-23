<?php

session_start();
require_once '../../function/koneksi_login.php';

if (!isset($_SESSION['token']) || $_SESSION['token'] !== $_GET['token']) {
    header('Location: ../../../index.php');
    exit;
}

$Nama = $_SESSION['Nama'];
$bagian = $_SESSION['bagian'];
$mesin = $_SESSION['mesin'];

if ($mesin !== 'pasteurisasi' && $bagian !== 'Master' && $bagian !== 'Produksi') {
    header('Location: ../dashboard.php?token=' . urlencode($_SESSION['token']) . '&error=not_allowed');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pasteurisasi</title>
    <link rel="stylesheet" href="../../src/css/pasteurisasi/data-trend.css">
    <link rel="shortcut icon" href="../../src/img/wings.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<style>
    @media (max-width: 750px) {
        .slide img {
            width: 80%;
            margin-left: 5px;
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

<body>
    <label>
        <div class="slide">
            <img src="../../src/img/kecap.png" alt="logo">
            <p>PT Bumi Alam Segar</p>
            <ul>
                <li><a href="./pasteurisasi.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>"><i class="fas fa-tv"></i>Pasteurisasi</a></li>
                <li><a href="./vaccum.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>"><i class="fa-solid fa-temperature-full"></i>Vaccum</a></li>
                <li><a href="./mixing.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>"><i class="fa-solid fa-fan"></i>Mixing</a></li>
                <li><a href="./realtime.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>"><i class="fa-solid fa-bolt"></i>Realtime</a></li>
                <li><a href="./data-trend.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>"><i class="fa-solid fa-chart-line"></i>Data Trend</a></li>
                <li><a href="./excel.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>"><i class="fa-solid fa-file"></i>Excel</a></li>
                <li><a href="../../function/logout.php"><i class="fa-solid fa-right-from-bracket"></i>Logout</a></li>
            </ul>
            <h6>By <span id="date"></span></h6>
        </div>
    </label>
    <div class="container">
        <div class="header">
            <h2>Data Trend Realtime</h2>
            <div class="user">
                <div class="akun">
                    <p><?php echo htmlspecialchars($Nama); ?></p>
                    <p><?php echo htmlspecialchars($bagian); ?></p>
                </div>
                <img src="../../src/img/user.png" alt="user-logo">
            </div>
        </div>
        <div class="info">
            <div class="dropdown">
                <button class="dropbtn">PASTEURIZER</button>
                <div class="dropdown-content">
                    <a href="../../chart/pasteurisasi/realtime/flowrate.php ?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">Flowrate</a>
                    <a href="../../chart/pasteurisasi/realtime/preheating.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">Suhu Preheating</a>
                    <a href="../../chart/pasteurisasi/realtime/cooling.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">Suhu Cooling</a>
                    <a href="../../chart/pasteurisasi/realtime/heating.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">Suhu Heating</a>
                    <a href="../../chart/pasteurisasi/realtime/holding.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">Suhu Holding</a>
                    <a href="../../chart/pasteurisasi/realtime/precooling.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">Suhu Precooling</a>
                    <a href="../../chart/pasteurisasi/realtime/pumpBT2.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">Speed Pump BT 2</a>
                    <a href="../../chart/pasteurisasi/realtime/levelBT2.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">Level BT 2</a>
                    <a href="../../chart/pasteurisasi/realtime/pressureBT2.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">Pressure BT 2</a>
                    <a href="../../chart/pasteurisasi/realtime/pcv1.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">PCV 1</a>
                    <a href="../../chart/pasteurisasi/realtime/divert.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">Time Divert</a>
                </div>
            </div>

            <div class="dropdown">
                <button class="dropbtn">VACCUM DEAERATOR</button>
                <div class="dropdown-content">
                    <a href="../../chart/pasteurisasi/realtime/pumpBT1.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">Speed Pump BT 1</a>
                    <a href="../../chart/pasteurisasi/realtime/levelBT1.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">Level BT 1</a>
                    <a href="../../chart/pasteurisasi/realtime/BT1AM.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">BT 1 AM</a>
                    <a href="../../chart/pasteurisasi/realtime/pumpVD.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">Speed Pump VD</a>
                    <a href="../../chart/pasteurisasi/realtime/levelVD.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">Level VD</a>
                    <a href="../../chart/pasteurisasi/realtime/VDAM.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">VD AM</a>
                    <a href="../../chart/pasteurisasi/realtime/VDHH.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">Press VDHH</a>
                    <a href="../../chart/pasteurisasi/realtime/VDLL.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">Press VDLL</a>
                    <a href="../../chart/pasteurisasi/realtime/press-to-pasteur.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">Press To Pasteur</a>
                </div>
            </div>

            <div class="dropdown">
                <button class="dropbtn">MIXING</button>
                <div class="dropdown-content">
                    <a href="../../chart/pasteurisasi/realtime/pompamixing.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">Speed Pompa Mixing</a>
                    <a href="../../chart/pasteurisasi/realtime/pressure-mixing.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">Pressure Mixing</a>
                    <a href="../../chart/pasteurisasi/realtime/mixingAM.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">MixingAM</a>
                </div>
            </div>
        </div>

        <script>
            // Ambil tahun saat ini
            document.getElementById("date").textContent = new Date().getFullYear();
        </script>
</body>

</html>