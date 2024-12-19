<?php

session_start();
require_once '../function/koneksi_login.php';

if (!isset($_SESSION['token']) || $_SESSION['token'] !== $_GET['token']) {
    header('Location: ../index.php');
    exit;
}

$Nama = $_SESSION['Nama'];
$bagian = $_SESSION['bagian'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PT BAS</title>
    <link rel="stylesheet" href="../src/css/boiler/homepage.css">
    <link rel="shortcut icon" href="../src/img/wings1.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<style>
    .right {
        text-align: right;
        margin-right: 20px;
    }

    .logout-btn {
        background-color: #ff4d4d;
        /* Warna tombol merah */
        color: white;
        /* Warna teks putih */
        border: none;
        border-radius: 5px;
        padding: 10px 15px;
        cursor: pointer;
        font-size: 16px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .logout-btn a {
        color: white;
        /* Pastikan link tetap putih */
        text-decoration: none;
    }

    .logout-btn a:hover {
        text-decoration: underline;
        /* Tambahkan efek hover pada teks */
    }

    .logout-btn:hover {
        background-color: #ff1a1a;
        /* Warna saat tombol di-hover */
    }
</style>

<body>
    <div class="container">
        <div class="header">
            <img src="../src/img/kecap.png" alt="logo" class="logo">
            <h2>PT BUMI ALAM SEGAR</h2>
            <!-- Bagian Logout -->
            <div class="right">
                <button class="logout-btn">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <a href="../function/logout.php">Logout</a>
                </button>
            </div>
        </div>
    </div>

    <div class="card-container">
        <a href="../pages/boiler/boiler.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>" class="card">
            <img src="../src/img/boiler/background.png" alt="Card 1">
            <p>Boiler</p>
        </a>
        <a href="../pages/pasteurisasi/pasteurisasi.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>" class="card">
            <img src="../src/img/pasteurisasi/pasteur.png" alt="Card 2">
            <p>Pasteurisasi</p>
        </a>
        <a href="../../dissolver/page/dissolver.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>" class="card">
            <img src="../src/img/dissolver.jpg" alt="Card 3">
            <p>Dissolver</p>
        </a>
        <a href="../../olahsari/page/olahsari.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>" class="card">
            <img src="../src/img/olahsari.png" alt="Card 4">
            <p>Olahsari</p>
        </a>
        <a href="../../glucose/page/glucose.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>" class="card">
            <img src="../src/img/glucose.png" alt="Card 5">
            <p>Glucose</p>
        </a>
        <a href="../../daily_tank/page/daily_tank.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>" class="card">
            <img src="../src/img/daily-tank.jpg" alt="Card 6">
            <p>Daily Tank</p>
        </a>
    </div>
    </div>
</body>

</html>