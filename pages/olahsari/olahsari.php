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

if ($mesin !== 'olahsari' && $bagian !== 'Master' && $bagian !== 'Produksi') {
    header('Location: ../dashboard.php?token=' . urlencode($_SESSION['token']) . '&error=not_allowed');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Olahsari</title>
    <!-- <link rel="stylesheet" href="../../src/css/homepage.css"> -->
    <link rel="stylesheet" href="../../src/css/olahsari/style.css">
    <link rel="shortcut icon" href="../../src/img/wings.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://kit.fontawesome.com/b99e6756e.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="../../src/js/olahsari/date.js"></script>
    <script src="../../src/js/olahsari/temp1.js"></script>
    <script src="../../src/js/olahsari/lc1.js"></script>
    <script src="../../src/js/olahsari/temp2.js"></script>
    <script src="../../src/js/olahsari/lc2.js"></script>

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
                <li><a href="../dashboard.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>"><i class="fas fa-tv"></i>Dashboard</a></li>
                <li><a href="./data-trend.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>"><i class="fa-solid fa-chart-line"></i>Data Trend</a></li>
                <li><a href="../../function/logout.php"><i class="fa-solid fa-right-from-bracket"></i>Logout</a></li>
            </ul>
            <h6>By <span id="date"></span></h6>
        </div>
    </label>
    <div class="container">
        <div class="header">
            <h2>Olahsari</h2>
            <div class="user">
                <div class="akun">
                    <p><?php echo htmlspecialchars($Nama); ?></p>
                    <p><?php echo htmlspecialchars($bagian); ?></p>
                </div>
                <img src="../../src/img/user.png" alt="user-logo">
            </div>
        </div>
        <div class="data">
            <div class="data">
                <div class="info">
                    <img src="../../src/img/olahsari/tampilan.png" alt="">
                </div>
                <div class="date">
                    <span id="day"></span> <span id="month"></span> <span id="year"></span> |
                    <span id="hour"></span>:<span id="minute"></span>:<span id="second"></span>
                </div>
                <p class="nama"><?php echo htmlspecialchars($Nama); ?></p>
                <p id="temp1" class="temp1"></p>
                <p id="lc1" class="lc1"></p>
                <p id="temp2" class="temp2"></p>
                <p id="lc2" class="lc2"></p>
            </div>
        </div>

        <script>
            // Ambil tahun saat ini
            document.getElementById("date").textContent = new Date().getFullYear();
        </script>
</body>

</html>