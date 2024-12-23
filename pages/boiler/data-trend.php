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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boiler</title>
    <link rel="stylesheet" href="../../src/css/boiler/data-trend.css">
    <link rel="shortcut icon" href="../../src/img/wings.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<style>
    @media (max-width: 750px) {
        .slide img {
            margin-left: 8px;
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
                <li><a href="./boiler.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>"><i class="fas fa-tv"></i>Dashboard</a></li>
                <li><a href="./data-trend.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>"><i class="fa-solid fa-chart-line"></i>Data Trend</a></li>
                <li><a href="./operasional_boiler.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>"><i class="fas fa-file"></i>Form PDF</a></li>
                <li><a href="../../function/logout.php"><i class="fa-solid fa-right-from-bracket"></i>Logout</a></li>
            </ul>
            <h6>By <span id="date"></span></h6>
        </div>
    </label>
    <div class="container">
        <div class="header">
            <h2>Data Trend</h2>
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
                <button class="dropbtn">Select an Option</button>
                <div class="dropdown-content">
                    <a href="../../chart/boiler/level-feed-water.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">Level Feed Water</a>
                    <a href="../../chart/boiler/pv-steam.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">PV Steam</a>
                    <a href="../../chart/boiler/feed-pressure.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">Feed Pressure</a>
                    <a href="../../chart/boiler/lhguil.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">LH Guiloutine</a>
                    <a href="../../chart/boiler/rhguil.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">RH Guiloutine</a>
                    <a href="../../chart/boiler/lh-temp.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">LH TEMP</a>
                    <a href="../../chart/boiler/rh-temp.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">RH TEMP</a>
                    <a href="../../chart/boiler/idfan.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">IDFan</a>
                    <a href="../../chart/boiler/lhfd.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">LHFDFan</a>
                    <a href="../../chart/boiler/rhfd.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">RHFDFan</a>
                    <a href="../../chart/boiler/lhs.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">LH Stoker</a>
                    <a href="../../chart/boiler/rhs.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">RH Stoker</a>
                    <a href="../../chart/boiler/waterpump1.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">Water Pump 1</a>
                    <a href="../../chart/boiler/waterpump2.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">Water Pump 2</a>
                    <a href="../../chart/boiler/inletwater.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">Inlet Water Flow</a>
                    <a href="../../chart/boiler/outletsteam.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">Outlet Steam Flow</a>
                    <a href="../../chart/boiler/suhufeed.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>">Suhu Feed Tank</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Ambil tahun saat ini
        document.getElementById("date").textContent = new Date().getFullYear();
    </script>
</body>

</html>