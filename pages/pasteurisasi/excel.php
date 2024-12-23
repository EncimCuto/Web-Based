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
    <link rel="stylesheet" href="../../src/css/pasteurisasi/excel.css">
    <link rel="shortcut icon" href="../../src/img/pasteurisasi/wings.png" type="image/x-icon">
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
            <h2>Excel</h2>
            <div class="user">
                <div class="akun">
                    <p><?php echo htmlspecialchars($Nama); ?></p>
                    <p><?php echo htmlspecialchars($bagian); ?></p>
                </div>
                <img src="../../src/img/user.png" alt="user-logo">
            </div>
        </div>

        <div class="search-container">
            <input type="text" placeholder="Cari file..." id="searchInput">
            <button type="button" onclick="searchTable()">Cari</button>
        </div>

        <div class="info">
            <table border="1" id="dataTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama File</th>
                        <th>Deskripsi</th>
                        <th>File Excel</th>
                        <th>Created at</th>
                        <th>Hapus</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include "../../function/pasteurisasi/koneksi.php";

                    // Menentukan jumlah data per halaman
                    $limit = 10;
                    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    $offset = ($page - 1) * $limit;

                    // Mengambil data dari database dengan limit dan offset
                    $query = $koneksi->query("SELECT * FROM db_excel ORDER BY created_at DESC LIMIT $limit OFFSET $offset");

                    // Menghitung total data untuk pagination
                    $total_data_query = $koneksi->query("SELECT COUNT(*) AS total FROM db_excel");
                    $total_data = $total_data_query->fetch_assoc()['total'];
                    $total_pages = ceil($total_data / $limit);

                    $no = $offset + 1; // Memulai nomor sesuai halaman
                    while ($tampil = $query->fetch_assoc()) {
                        $file = !empty($tampil['Excel'])
                            ? '<a href="../../function/pasteurisasi/download.php?id=' . $tampil['id'] . '"><i class="fa-solid fa-download"></i></a>'
                            : 'Tidak ada file';

                        echo "
                        <tr>
                            <td class='center'>$no</td>
                            <td>" . htmlspecialchars($tampil['Nama_File']) . "</td>
                            <td>" . htmlspecialchars($tampil['Deskripsi']) . "</td>
                            <td class='center1 green-file'>$file</td>
                            <td>" . htmlspecialchars($tampil['created_at']) . "</td>
                            <td class='center1 red-delete'>
                                <a href='../../function/pasteurisasi/delete.php?id=" . urlencode($tampil['id']) . "&token=" . urlencode($_SESSION['token']) . "' 
                                   onclick=\"return confirm('Yakin akan menghapus data?');\">
                                   <i class='fa-solid fa-trash-can'></i>
                                </a>
                            </td>
                        </tr>";
                        $no++;
                    }
                    ?>
                </tbody>
            </table>

        </div>
        <!-- Pagination -->
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?page=<?php echo $page - 1; ?>&token=<?php echo urlencode($_GET['token']); ?>">Previous</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?page=<?php echo $i; ?>&token=<?php echo urlencode($_GET['token']); ?>" <?php if ($i == $page) echo 'class="active"'; ?>>
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
                <a href="?page=<?php echo $page + 1; ?>&token=<?php echo urlencode($_GET['token']); ?>">Next</a>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // Ambil tahun saat ini
        document.getElementById("date").textContent = new Date().getFullYear();

        // Fungsi pencarian
        function searchTable() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("dataTable");
            tr = table.getElementsByTagName("tr");

            for (i = 1; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1]; // Nama File ada di kolom kedua
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>
</body>

</html>