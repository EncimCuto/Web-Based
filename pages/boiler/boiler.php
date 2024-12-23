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
    header('Location: ../dashboard.php?token=' . urlencode($_SESSION['token']) . '&error=not_allowed');
    exit;
}

include '../../function/boiler/koneksi.php';
// Ambil data terakhir dari database
$query = "SELECT Batubara_FK, Steam_FK FROM readsensors ORDER BY id DESC LIMIT 1"; // Ganti 'id' dengan nama kolom utama yang sesuai
$result = $koneksi->query($query);
$lastData = $result->fetch_assoc();

$lastBatubara = $lastData['Batubara_FK'] ?? ''; // Data Batubara terakhir
$lastSteam = $lastData['Steam_FK'] ?? ''; // Data Steam terakhir

// Tutup koneksi
$koneksi->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boiler</title>
    <!-- <link rel="stylesheet" href="../src/boiler/css/homepage.css"> -->
    <link rel="stylesheet" href="../../src/css/boiler/tes.css">
    <link rel="shortcut icon" href="../../src/img/wings.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="../../src/js/boiler/date.js"></script>
    <script src="../../src/js/boiler/level_feed_water.js"></script>
    <script src="../../src/js/boiler/lh.js"></script>
    <script src="../../src/js/boiler/rh.js"></script>
    <script src="../../src/js/boiler/lhguil.js"></script>
    <script src="../../src/js/boiler/rhguil.js"></script>
    <script src="../../src/js/boiler/lhstoker.js"></script>
    <script src="../../src/js/boiler/rhstoker.js"></script>
    <script src="../../src/js/boiler/lhfd.js"></script>
    <script src="../../src/js/boiler/rhfd.js"></script>
    <script src="../../src/js/boiler/pvsteam.js"></script>
    <script src="../../src/js/boiler/pvsteam1.js"></script>
    <script src="../../src/js/boiler/idfan.js"></script>
    <script src="../../src/js/boiler/pump1.js"></script>
    <script src="../../src/js/boiler/pump2.js"></script>
    <script src="../../src/js/boiler/batubara_fk.js"></script>
    <script src="../../src/js/boiler/steam_fk.js"></script>
    <script src="../../src/js/boiler/bbsteam.js"></script>
    <script src="../../src/js/boiler/O2.js"></script>
    <script src="../../src/js/boiler/CO2.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
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
                <li><a href="./operasional_boiler.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>"><i class="fas fa-file"></i>Form PDF</a></li>
                <li><a href="../../function/logout.php"><i class="fa-solid fa-right-from-bracket"></i>Logout</a></li>
            </ul>
            <h6>By <span id="date"></span></h6>
        </div>
    </label>
    <div class="container">
        <div class="header">
            <h2>Boiler</h2>
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
                    <img src="../../src/img/boiler/tampilan.png" alt="">
                </div>
                <div class="date">
                    <span id="day"></span> <span id="month"></span> <span id="year"></span> |
                    <span id="hour"></span>:<span id="minute"></span>:<span id="second"></span>
                </div>
                <p id="pvsteam" class="pvs"></p>
                <p id="pvsteam1" class="pvs1"></p>
                <p id="lhguil" class="lhg"></p>
                <p id="lhstoker" class="lhs"></p>
                <p id="temp1" class="lh"></p>
                <p id="lhfd" class="lhf"></p>
                <p id="value" class="water"></p>
                <p id="rhguil" class="rhg"></p>
                <p id="temp2" class="rh"></p>
                <p id="rhstoker" class="rhs"></p>
                <p id="rhfd" class="rhf"></p>
                <p id="idfan" class="idf"></p>
                <p id="pump1" class="pump1"></p>
                <p id="pump2" class="pump2"></p>
                <p id="batubara_fk" class="batubara_fk"></p>
                <p id="steam_fk" class="steam_fk"></p>
                <p id="batubara" class="batubara"></p>
                <p id="steam" class="steam"></p>
                <p id="bbsteam" class="bbsteam"></p>
                <p id="o2" class="o2"></p>
                <p id="co2" class="co2"></p>
            </div>
            <!-- Tombol untuk membuka modal -->
            <button id="openModal" class="input">Insert</button>
            <!-- Modal -->
            <div id="myModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Tambah Data</h2>
                    <form id="dataForm" method="post">
                        <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">

                        <label for="batubara">Masukkan Batubara (FK):</label>
                        <input type="number" id="batubara" name="batubara" value="<?php echo htmlspecialchars($lastBatubara); ?>" step="any" required>

                        <label for="steam">Masukkan Steam (FK):</label>
                        <input type="number" id="steam" name="steam" value="<?php echo htmlspecialchars($lastSteam); ?>" step="any" required>

                        <button type="submit" class="submit">Simpan</button>
                    </form>
                </div>
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
                e.preventDefault(); // Mencegah pengiriman form secara langsung

                var formData = new FormData(this); // Ambil data dari form

                // Ganti koma dengan titik pada input batubara dan steam
                var batubaraInput = formData.get('batubara').replace(',', '.');
                var steamInput = formData.get('steam').replace(',', '.');

                formData.set('batubara', batubaraInput); // Set nilai baru
                formData.set('steam', steamInput); // Set nilai baru

                var xhr = new XMLHttpRequest(); // Membuat instance XMLHttpRequest
                xhr.open('POST', '../../function/boiler/insert_data.php', true); // Menyiapkan request

                // Menangani respon dari server
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        console.log(xhr.responseText); // Tambahkan ini untuk melihat respons server

                        try {
                            var response = JSON.parse(xhr.responseText); // Parse response JSON
                            if (response.success) {
                                document.getElementById('batubara').value = response.data.batubara;
                                document.getElementById('steam').value = response.data.steam;
                                modal.style.display = 'none';
                            } else {
                                alert('Error saving data: ' + response.message);
                            }
                        } catch (e) {
                            console.error('Error parsing JSON: ', e);
                            alert('Error: Invalid response from server');
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

            function convertToFloat(input) {
                // Ganti koma dengan titik
                input.value = input.value.replace(',', '.');
            }

            let alertShownWater = false; // Variabel untuk melacak apakah alert sudah ditampilkan untuk water level
            let alertShownPvsteam = false; // Variabel untuk melacak apakah alert sudah ditampilkan untuk pvsteam

            // Fungsi untuk memeriksa level feed water
            function checkWaterLevel() {
                const waterLevelElement = document.getElementById("value");
                const waterLevel = parseFloat(waterLevelElement.innerText);

                // Format nilai level feed water menjadi 1 digit desimal
                const formattedWaterLevel = waterLevel.toFixed(1);

                if (!isNaN(waterLevel)) {
                    if (waterLevel > 60 && !alertShownWater) {
                        alertShownWater = true;
                        toastr.warning("Level feed water telah melebihi " + formattedWaterLevel + "% !", "Peringatan", {
                            timeOut: 0, // Membuat toastr tetap muncul
                            extendedTimeOut: 0, // Membuat toastr tetap muncul
                            closeButton: true // Menambahkan tombol close pada toastr
                        });
                    } else if (waterLevel <= 60 && alertShownWater) {
                        alertShownWater = false;
                        toastr.clear(); // Menghilangkan toastr ketika kondisi kembali normal
                    }
                }
            }

            // Fungsi untuk memeriksa level pvsteam
            function checkPvsteamLevel() {
                const pvsteamElement = document.getElementById("pvsteam");
                const pvsteamLevel = parseFloat(pvsteamElement.innerText);

                // Format nilai pvsteam menjadi 1 digit desimal
                const formattedPvsteamLevel = pvsteamLevel.toFixed(1);

                if (!isNaN(pvsteamLevel)) {
                    if (pvsteamLevel > 6 && !alertShownPvsteam) {
                        alertShownPvsteam = true;
                        toastr.warning("Level pvsteam telah melebihi " + formattedPvsteamLevel + " bar !", "Peringatan", {
                            timeOut: 0, // Membuat toastr tetap muncul
                            extendedTimeOut: 0, // Membuat toastr tetap muncul
                            closeButton: true // Menambahkan tombol close pada toastr
                        });
                    } else if (pvsteamLevel <= 6 && alertShownPvsteam) {
                        alertShownPvsteam = false;
                        toastr.clear(); // Menghilangkan toastr ketika kondisi kembali normal
                    }
                }
            }

            // Fungsi untuk terus memantau nilai setiap beberapa detik
            function monitorWaterLevel() {
                setInterval(checkWaterLevel, 1000); // Cek setiap 1 detik
            }

            function monitorPvsteamLevel() {
                setInterval(checkPvsteamLevel, 1000); // Cek setiap 1 detik
            }

            // Jalankan pemantauan saat halaman selesai dimuat
            document.addEventListener("DOMContentLoaded", function() {
                monitorWaterLevel();
                monitorPvsteamLevel();
            });
        </script>

</body>

</html>