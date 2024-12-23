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

if ($mesin !== 'boiler' && $bagian !== 'Master') {
    header('Location: ../page/dashboard.php?token=' . urlencode($_SESSION['token']) . '&error=not_allowed');
    exit;
}

?>

<title>PT BAS</title>
<script src="https://kit.fontawesome.com/b99e6756e.js"></script>
<link rel="shortcut icon" href="../src/img/wings1.png" type="image/x-icon">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Ubuntu", sans-serif;
        /* border: 1px solid; */
    }

    body {
        background-color: #f2f2f2;
    }

    .slide {
        height: 55rem;
        width: 14%;
        position: absolute;
        background-color: black;
        z-index: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .slide img {
        width: 80%;
        margin-left: 25px;
        border-radius: 100%;
    }

    .slide p {
        color: #fff;
        font-weight: bold;
        text-align: center;
        font-size: 15px;
    }

    ul li {
        list-style: none;
        border-radius: 100px;
        padding: 10px 20px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        margin-top: 20%;
    }

    ul li :hover {
        background-color: #E3651D;
    }

    ul li a {
        color: #fff;
        font-weight: bold;
        padding: 20px 0;
        display: block;
        text-decoration: none;
        border-radius: 20px;
    }

    ul li a i {
        width: 30%;
        text-align: center;
    }

    .slide h6 {
        color: #fff;
        font-weight: 800;
        text-align: center;
        padding: 10px 0;
        margin-top: auto;
    }

    .container {
        min-width: 1200px;
        margin-left: 14%;
    }

    .container .header {
        padding: 8px;
        border-bottom: 1px solid #e0e4e8;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .container .header h2 {
        display: flex;
        align-items: center;
        margin-left: 10px;
        font-size: 40px;
    }

    .container .header .user {
        text-align: right;
        display: flex;
    }

    .container .header .akun {
        margin-right: 20px;
        margin-top: 7px;
    }

    .container .header .akun p {
        font-weight: 800;
    }

    .container .header img {
        width: 50px;
        border-radius: 50px;
        margin-right: 10px;
    }

    /* Search Box Styling */
    .search-container {
        display: flex;
        justify-content: center;
        margin: 20px 0;
    }

    .search-container input[type="text"] {
        width: 35%;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    .search-container button {
        padding: 10px 15px;
        border-radius: 5px;
        background-color: #b82e2e;
        color: white;
        border: none;
        margin-left: 10px;
        cursor: pointer;
    }

    .search-container button:hover {
        background-color: #a12626;
    }

    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 20px;
    }

    .pagination a {
        color: #007bff;
        padding: 8px 16px;
        text-decoration: none;
        border: 1px solid #ddd;
        margin: 0 5px;
    }

    .pagination a.active {
        background-color: #007bff;
        color: white;
        border: 1px solid #007bff;
    }

    .pagination a:hover {
        background-color: #ddd;
    }
</style>


<div class="slide">
    <img src="../../src/img/kecap.png" alt="logo">
    <p>Boiler PT Bumi Alam Segar</p>
    <ul>
        <li><a href="./boiler.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>"><i class="fas fa-tv"></i>Dashboard</a></li>
        <li><a href="./data-trend.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>"><i class="fa-solid fa-chart-line"></i>Data Trend</a></li>
        <li><a href="./operasional_boiler.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>"><i class="fas fa-file"></i>Form PDF</a></li>
        <li><a href="../../function/logout.php"><i class="fa-solid fa-right-from-bracket"></i>Logout</a></li>
    </ul>
    <h6>By <span id="date"></span></h6>
</div>
<div class="container">
    <div class="header">
        <h2>Form Operasional Boiler</h2>
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

    <?php
    include_once '../../function/boiler/koneksi.php'; // Pastikan koneksi sudah benar

    // Menentukan jumlah data per halaman
    $limit = 15;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $limit;

    // Query untuk mengambil data PDF dari tabel form_boiler
    $sql = "SELECT id, file_name, created_at FROM form_boiler ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
    $result = $koneksi->query($sql);

    // Memastikan query berhasil dijalankan
    if (!$result) {
        die("Query Error: " . $koneksi->error);
    }

    // Menghitung total data untuk pagination
    $total_data_query = $koneksi->query("SELECT COUNT(*) AS total FROM form_boiler");
    $total_data = $total_data_query->fetch_assoc()['total'];
    $total_pages = ceil($total_data / $limit);

    $no = $offset + 1; // Memulai nomor sesuai halaman
    ?>

    <div style='display: flex; justify-content: center;'>
        <table id="dataTable" border='1' cellspacing='0' cellpadding='5' style='border-collapse: collapse; margin-top: 15px;'>
            <tr>
                <th style='padding: 5px;'>No</th>
                <th style='padding: 10px;'>Nama File</th>
                <th style='padding: 10px;'>Waktu Dibuat</th>
                <th style='padding: 10px;'>Aksi</th>
            </tr>

            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                    <td style='padding: 10px;'>" . $no . "</td>
                    <td style='padding: 10px;'>" . $row['file_name'] . "</td>
                    <td style='padding: 10px;'>" . $row['created_at'] . "</td>
                    <td style='padding: 10px;'>
                        <a href='../../function/boiler/lihat_pdf.php?id=" . $row['id'] . "' target='_blank'>Lihat</a> | 
                        <a href='../../function/boiler/unduh_pdf.php?id=" . $row['id'] . "'>Unduh</a>
                    </td>
                </tr>";
                    $no++;
                }
            } else {
                echo "<tr><td colspan='4'>Tidak ada file PDF yang tersedia.</td></tr>";
            }
            ?>
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