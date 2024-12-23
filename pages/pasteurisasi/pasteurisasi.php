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
    <link rel="stylesheet" href="../../src/css/pasteurisasi/pasteur.css">
    <link rel="shortcut icon" href="../../src/img/wings.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="../../src/js/pasteurisasi/date.js"></script>
    <script src="../../src/js/pasteurisasi/cooling.js"></script>
    <script src="../../src/js/pasteurisasi/heating.js"></script>
    <script src="../../src/js/pasteurisasi/precooling.js"></script>
    <script src="../../src/js/pasteurisasi/pump2.js"></script>
    <script src="../../src/js/pasteurisasi/lvlBT2.js"></script>
    <script src="../../src/js/pasteurisasi/flowrate.js"></script>
    <script src="../../src/js/pasteurisasi/pressurebt2.js"></script>
    <script src="../../src/js/pasteurisasi/preheating.js"></script>
    <script src="../../src/js/pasteurisasi/holding.js"></script>
    <script src="../../src/js/pasteurisasi/pcv1.js"></script>
    <script src="../../src/js/pasteurisasi/divert1.js"></script>
    <script src="../../src/js/pasteurisasi/mode.js"></script>
    <script src="../../src/js/pasteurisasi/varian.js"></script>
    <script src="../../src/js/pasteurisasi/batch.js"></script>
    <script src="../../src/js/pasteurisasi/storage.js"></script>
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
            <h2>Pasteurisasi</h2>
            <div class="user">
                <div class="akun">
                    <p><?php echo htmlspecialchars($Nama); ?></p>
                    <p><?php echo htmlspecialchars($bagian); ?></p>
                </div>
                <img src="../../src/img/user.png" alt="user-logo">
            </div>
        </div>
        <div class="data">
            <div class="info">
                <img src="../../src/img/pasteurisasi/tampilan.png" alt="">
            </div>
            <div class="date">
                <span id="weekday"></span>,
                <span id="month"></span> <span id="day"></span>, <span id="year"></span>
                <span id="hour"></span>:<span id="minute"></span>:<span id="second"></span>
            </div>
            <p id="pcv1" class="pcv1"></p>
            <p id="storage1" class="storage1"></p>
            <p id="flowrate" class="flowrate"></p>
            <p id="cool" class="cooling"></p>
            <p id="precool" class="precooling"></p>
            <p id="pressurebt2" class="pressurebt2"></p>
            <p id="BT2" class="BT2"></p>
            <p id="mode" class="mode"></p>
            <p id="varian" class="varian"></p>
            <p id="batch" class="batch"></p>
            <p id="storage" class="storage"></p>
            <p id="preheating" class="preheating"></p>
            <p id="pump2" class="pump2"></p>
            <p id="holding" class="holding"></p>
            <p id="suheat" class="heating"></p>
            <p id="TD1" class="TD1"></p>
            <p id="TD2" class="TD2"></p>
        </div>
    </div>
    <!-- Tombol untuk membuka modal -->
    <button id="openModal" class="input">Insert</button>

    <!-- Tabel Output Data -->
    <table id="dataTable">
        <thead>
            <tr>
                <th>Mode</th>
                <th>Varian</th>
                <th>Batch</th>
                <th>Storage</th>
            </tr>
        </thead>
        <tbody>
            <!-- Data akan diisi oleh JavaScript -->
        </tbody>
    </table>

    <!-- Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Tambah Data</h2>
            <form id="dataForm" method="post">
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">

                <label for="mode">Mode :</label>
                <select id="mode" name="mode" required>
                    <option value="REPRO">REPRO</option>
                    <option value="PRODUK">PRODUK</option>
                    <option value="CIP">CIP</option>
                    <option value="SIP">SIP</option>
                    <option value="FLUSHING">FLUSHING</option>
                    <option value="STK">STK</option>
                    <option value="SWITCH STK">SWITCH STK</option>
                </select>

                <label for="varian">Varian :</label>
                <select id="varian" name="varian" required>
                    <option value="BB">BB</option>
                    <option value="JB">JB</option>
                    <option value="SS1">SS1</option>
                    <option value="SS2">SS2</option>
                    <option value="MSD">MSD</option>
                    <option value="NR2">NR2</option>
                </select>

                <label for="batch">Batch:</label>
                <input type="text" id="batch" name="batch" required>

                <label for="storage">Storage :</label>
                <select id="storage" name="storage" required>
                    <optgroup label="A">
                        <option value="A1">A1</option>
                        <option value="A2">A2</option>
                        <option value="A3">A3</option>
                        <option value="A4">A4</option>
                        <option value="A5">A5</option>
                    </optgroup>

                    <optgroup label="B">
                        <option value="B1">B1</option>
                        <option value="B2">B2</option>
                        <option value="B3">B3</option>
                        <option value="B4">B4</option>
                        <option value="B5">B5</option>
                    </optgroup>

                    <optgroup label="C">
                        <option value="C1">C1</option>
                        <option value="C2">C2</option>
                        <option value="C3">C3</option>
                        <option value="C4">C4</option>
                        <option value="C5">C5</option>
                    </optgroup>

                    <optgroup label="D">
                        <option value="D1">D1</option>
                        <option value="D2">D2</option>
                        <option value="D3">D3</option>
                        <option value="D4">D4</option>
                        <option value="D5">D5</option>
                    </optgroup>
                </select>

                <button type="submit" class="submit">Simpan</button>
            </form>
        </div>
    </div>
    <script>
        // Ambil tahun saat ini
        document.getElementById("date").textContent = new Date().getFullYear();

        // Ambil elemen modal dan tombol
        var modal = document.getElementById("myModal");
        var btn = document.getElementById("openModal");
        var span = document.getElementsByClassName("close")[0];

        // Ketika tombol diklik, buka modal
        btn.onclick = function() {
            modal.style.display = "block";
        }

        // Ketika tombol close diklik, tutup modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // Ketika user mengklik di luar modal, tutup modal
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        // Submit form via AJAX
        document.getElementById('dataForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Mencegah pengiriman form

            console.log('Form submission intercepted'); // Debugging log

            var formData = new FormData(this); // Ambil data dari form

            var xhr = new XMLHttpRequest(); // Membuat instance XMLHttpRequest
            xhr.open('POST', '../../function/pasteurisasi/insert_data.php', true); // Menyiapkan request

            // Menangani respon dari server
            xhr.onload = function() {
                console.log('XHR onload called'); // Debugging log
                if (xhr.status === 200) {
                    console.log('Response:', xhr.responseText); // Debugging log
                    if (xhr.responseText.includes('Data processed successfully')) {
                        loadLatestData(); // Memuat data terbaru
                        modal.style.display = 'none'; // Menutup modal
                        document.getElementById('dataForm').reset(); // Reset form fields
                    } else {
                        alert('Error saving data: ' + xhr.responseText);
                    }
                } else {
                    alert('Error saving data: ' + xhr.statusText);
                }
            };

            xhr.onerror = function() {
                alert('Request failed');
            };

            xhr.send(formData); // Mengirimkan data form
        });

        // Function to load the latest data from the database using AJAX
        function loadLatestData() {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '../../function/pasteurisasi/fetch_data.php', true); // Assume fetch_data.php returns the latest data
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var table = document.getElementById('dataTable');
                    table.innerHTML = `
                <tr>
                    <th>Mode</th>
                    <th>Varian</th>
                    <th>Batch</th>
                    <th>Storage</th>
                </tr>
            ` + xhr.responseText; // Replace table content with latest data
                } else {
                    console.error('Failed to load data: ' + xhr.statusText);
                }
            };
            xhr.onerror = function() {
                console.error('Request failed');
            };
            xhr.send();
        }

        // Call loadLatestData on page load to display the initial data
        window.onload = function() {
            loadLatestData();
            setInterval(loadLatestData, 5000); // Memuat data setiap 5 detik
        };
    </script>
</body>

</html>