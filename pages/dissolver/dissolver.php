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

if ($mesin !== 'dissolver' && $bagian !== 'Master' && $bagian !== 'Produksi') {
    header('Location: ../dashboard.php?token=' . urlencode($_SESSION['token']) . '&error=not_allowed');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dissolver</title>
    <link rel="stylesheet" href="../../src/css/dissolver/style.css">
    <link rel="shortcut icon" href="../../src/img/wings.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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
                <!-- <li><a href="./data-trend.php?token=<?php echo htmlspecialchars($_SESSION['token']); ?>"><i class="fa-solid fa-chart-line"></i>Data Trend</a></li> -->
                <li><a href="../../function/logout.php"><i class="fa-solid fa-right-from-bracket"></i>Logout</a></li>
            </ul>
            <h6>By <span id="date"></span></h6>
        </div>
    </label>
    <div class="container">
        <div class="header">
            <h2>Dissolver</h2>
            <div class="user">
                <div class="akun">
                    <p><?php echo htmlspecialchars($Nama); ?></p>
                    <p><?php echo htmlspecialchars($bagian); ?></p>
                </div>
                <img src="../../src/img/user.png" alt="user-logo">
            </div>
        </div>
        <div class="data">

            <!-- Tanki 1 -->
            <div class="blending-container">
                <div class="ujung-lancip"></div>
                <div class="isi-bahan-baku">
                    <h2>Dissolver 1</h2>
                    <ul>
                        <?php
                        try {
                            // Koneksi ke database
                            include '../../function/dissolver/koneksi.php';

                            $query = "SELECT * FROM dissolver1 ORDER BY id DESC LIMIT 1";
                            $stmt = $koneksi->prepare($query);
                            $stmt->execute();

                            // Memeriksa apakah ada hasil
                            if ($stmt->rowCount() > 0) {
                                echo "<ul>";

                                // Mengambil setiap baris data
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<li>Batch         : " . htmlspecialchars($row['Batch']) . "</li>";
                                    echo "<li>Varian        : " . htmlspecialchars($row['Varian']) . "</li>";
                                    echo "<li>PO Masak      : " . htmlspecialchars($row['PO_Masak']) . "</li>";
                                    echo "<li>No Formulasi  : " . htmlspecialchars($row['No_Formulasi']) . "</li>";
                                    echo "<li>Status GGA    : " . htmlspecialchars($row['Status_GGA']) . "</li>";
                                    echo "<li>Gula          : " . htmlspecialchars($row['Gula']) . "</li>";
                                    echo "<li><b>Hasil Analisa</b>" . "</li>";
                                    echo "<li>NaCl          : " . htmlspecialchars($row['NaCl_GGA']) . "</li>";
                                    echo "<li>Brix          : " . htmlspecialchars($row['Brix_GGA']) . "</li>";
                                    echo "<li>Warna         : " . htmlspecialchars($row['Warna_GGA']) . "</li>";
                                    echo "<li>Organo        : " . htmlspecialchars($row['Organo_GGA']) . "</li>";
                                    echo "<li>Status GGAS   : " . htmlspecialchars($row['Status_GGAS']) . "</li>";
                                    echo "<li><b>Hasil Analisa</b>" . "</li>";
                                    echo "<li>NaCl          : " . htmlspecialchars($row['NaCl_GGAS']) . "</li>";
                                    echo "<li>Brix          : " . htmlspecialchars($row['Brix_GGAS']) . "</li>";
                                    echo "<li>Warna         : " . htmlspecialchars($row['Warna_GGAS']) . "</li>";
                                    echo "<li>Organo        : " . htmlspecialchars($row['Organo_GGAS']) . "</li>";
                                }
                                echo "</ul>";
                            } else {
                                echo "Tidak ada data yang ditemukan.";
                            }
                        } catch (PDOException $e) {
                            echo "Koneksi gagal: " . $e->getMessage();
                        }

                        // Menutup koneksi
                        $koneksi = null;
                        ?>
                    </ul>
                    <button id="dissolver1">Insert</button>
                </div>
            </div>

            <!-- Tanki 2 -->
            <div class="blending-container">
                <div class="ujung-lancip"></div>
                <div class="isi-bahan-baku">
                    <h2>Dissolver 2</h2>
                    <ul>
                        <?php
                        try {
                            // Koneksi ke database
                            include '../../function/dissolver/koneksi.php';

                            $query = "SELECT * FROM dissolver2 ORDER BY id DESC LIMIT 1";
                            $stmt = $koneksi->prepare($query);
                            $stmt->execute();

                            // Memeriksa apakah ada hasil
                            if ($stmt->rowCount() > 0) {
                                echo "<ul>";

                                // Mengambil setiap baris data
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<li>Batch         : " . htmlspecialchars($row['Batch']) . "</li>";
                                    echo "<li>Varian        : " . htmlspecialchars($row['Varian']) . "</li>";
                                    echo "<li>PO Masak      : " . htmlspecialchars($row['PO_Masak']) . "</li>";
                                    echo "<li>No Formulasi  : " . htmlspecialchars($row['No_Formulasi']) . "</li>";
                                    echo "<li>Status GGA    : " . htmlspecialchars($row['Status_GGA']) . "</li>";
                                    echo "<li>Gula          : " . htmlspecialchars($row['Gula']) . "</li>";
                                    echo "<li><b>Hasil Analisa</b>" . "</li>";
                                    echo "<li>NaCl          : " . htmlspecialchars($row['NaCl_GGA']) . "</li>";
                                    echo "<li>Brix          : " . htmlspecialchars($row['Brix_GGA']) . "</li>";
                                    echo "<li>Warna         : " . htmlspecialchars($row['Warna_GGA']) . "</li>";
                                    echo "<li>Organo        : " . htmlspecialchars($row['Organo_GGA']) . "</li>";
                                    echo "<li>Status GGAS   : " . htmlspecialchars($row['Status_GGAS']) . "</li>";
                                    echo "<li><b>Hasil Analisa</b>" . "</li>";
                                    echo "<li>NaCl          : " . htmlspecialchars($row['NaCl_GGAS']) . "</li>";
                                    echo "<li>Brix          : " . htmlspecialchars($row['Brix_GGAS']) . "</li>";
                                    echo "<li>Warna         : " . htmlspecialchars($row['Warna_GGAS']) . "</li>";
                                    echo "<li>Organo        : " . htmlspecialchars($row['Organo_GGAS']) . "</li>";
                                }
                                echo "</ul>";
                            } else {
                                echo "Tidak ada data yang ditemukan.";
                            }
                        } catch (PDOException $e) {
                            echo "Koneksi gagal: " . $e->getMessage();
                        }

                        // Menutup koneksi
                        $koneksi = null;
                        ?>
                    </ul>
                    <button id="dissolver2">Insert</button>
                </div>
            </div>

            <!-- Tanki 3 -->
            <div class="blending-container">
                <div class="ujung-lancip"></div>
                <div class="isi-bahan-baku">
                    <h2>Dissolver 3</h2>
                    <ul>
                        <?php
                        try {
                            // Koneksi ke database
                            include '../../function/dissolver/koneksi.php';

                            $query = "SELECT * FROM dissolver3 ORDER BY id DESC LIMIT 1";
                            $stmt = $koneksi->prepare($query);
                            $stmt->execute();

                            // Memeriksa apakah ada hasil
                            if ($stmt->rowCount() > 0) {
                                echo "<ul>";

                                // Mengambil setiap baris data
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<li>Batch         : " . htmlspecialchars($row['Batch']) . "</li>";
                                    echo "<li>Varian        : " . htmlspecialchars($row['Varian']) . "</li>";
                                    echo "<li>PO Masak      : " . htmlspecialchars($row['PO_Masak']) . "</li>";
                                    echo "<li>No Formulasi  : " . htmlspecialchars($row['No_Formulasi']) . "</li>";
                                    echo "<li>Status GGA    : " . htmlspecialchars($row['Status_GGA']) . "</li>";
                                    echo "<li>Gula          : " . htmlspecialchars($row['Gula']) . "</li>";
                                    echo "<li><b>Hasil Analisa</b>" . "</li>";
                                    echo "<li>NaCl          : " . htmlspecialchars($row['NaCl_GGA']) . "</li>";
                                    echo "<li>Brix          : " . htmlspecialchars($row['Brix_GGA']) . "</li>";
                                    echo "<li>Warna         : " . htmlspecialchars($row['Warna_GGA']) . "</li>";
                                    echo "<li>Organo        : " . htmlspecialchars($row['Organo_GGA']) . "</li>";
                                    echo "<li>Status GGAS   : " . htmlspecialchars($row['Status_GGAS']) . "</li>";
                                    echo "<li><b>Hasil Analisa</b>" . "</li>";
                                    echo "<li>NaCl          : " . htmlspecialchars($row['NaCl_GGAS']) . "</li>";
                                    echo "<li>Brix          : " . htmlspecialchars($row['Brix_GGAS']) . "</li>";
                                    echo "<li>Warna         : " . htmlspecialchars($row['Warna_GGAS']) . "</li>";
                                    echo "<li>Organo        : " . htmlspecialchars($row['Organo_GGAS']) . "</li>";
                                }
                                echo "</ul>";
                            } else {
                                echo "Tidak ada data yang ditemukan.";
                            }
                        } catch (PDOException $e) {
                            echo "Koneksi gagal: " . $e->getMessage();
                        }

                        // Menutup koneksi
                        $koneksi = null;
                        ?>
                    </ul>
                    <button id="dissolver3">Insert</button>
                </div>
            </div>

            <!-- Tanki 4 -->
            <div class="blending-container">
                <div class="ujung-lancip"></div>
                <div class="isi-bahan-baku">
                    <h2>Dissolver 4</h2>
                    <ul>
                        <?php
                        try {
                            // Koneksi ke database
                            include '../../function/dissolver/koneksi.php';

                            $query = "SELECT * FROM dissolver4 ORDER BY id DESC LIMIT 1";
                            $stmt = $koneksi->prepare($query);
                            $stmt->execute();

                            // Memeriksa apakah ada hasil
                            if ($stmt->rowCount() > 0) {
                                echo "<ul>";

                                // Mengambil setiap baris data
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<li>Batch         : " . htmlspecialchars($row['Batch']) . "</li>";
                                    echo "<li>Varian        : " . htmlspecialchars($row['Varian']) . "</li>";
                                    echo "<li>PO Masak      : " . htmlspecialchars($row['PO_Masak']) . "</li>";
                                    echo "<li>No Formulasi  : " . htmlspecialchars($row['No_Formulasi']) . "</li>";
                                    echo "<li>Status GGA    : " . htmlspecialchars($row['Status_GGA']) . "</li>";
                                    echo "<li>Gula          : " . htmlspecialchars($row['Gula']) . "</li>";
                                    echo "<li><b>Hasil Analisa</b>" . "</li>";
                                    echo "<li>NaCl          : " . htmlspecialchars($row['NaCl_GGA']) . "</li>";
                                    echo "<li>Brix          : " . htmlspecialchars($row['Brix_GGA']) . "</li>";
                                    echo "<li>Warna         : " . htmlspecialchars($row['Warna_GGA']) . "</li>";
                                    echo "<li>Organo        : " . htmlspecialchars($row['Organo_GGA']) . "</li>";
                                    echo "<li>Status GGAS   : " . htmlspecialchars($row['Status_GGAS']) . "</li>";
                                    echo "<li><b>Hasil Analisa</b>" . "</li>";
                                    echo "<li>NaCl          : " . htmlspecialchars($row['NaCl_GGAS']) . "</li>";
                                    echo "<li>Brix          : " . htmlspecialchars($row['Brix_GGAS']) . "</li>";
                                    echo "<li>Warna         : " . htmlspecialchars($row['Warna_GGAS']) . "</li>";
                                    echo "<li>Organo        : " . htmlspecialchars($row['Organo_GGAS']) . "</li>";
                                }
                                echo "</ul>";
                            } else {
                                echo "Tidak ada data yang ditemukan.";
                            }
                        } catch (PDOException $e) {
                            echo "Koneksi gagal: " . $e->getMessage();
                        }

                        // Menutup koneksi
                        $koneksi = null;
                        ?>
                    </ul>
                    <button id="dissolver4">Insert</button>
                </div>
            </div>

            <!-- Tanki 5 -->
            <div class="blending-container">
                <div class="ujung-lancip"></div>
                <div class="isi-bahan-baku">
                    <h2>Dissolver 5</h2>
                    <ul>
                        <?php
                        try {
                            // Koneksi ke database
                            include '../../function/dissolver/koneksi.php';

                            $query = "SELECT * FROM dissolver5 ORDER BY id DESC LIMIT 1";
                            $stmt = $koneksi->prepare($query);
                            $stmt->execute();

                            // Memeriksa apakah ada hasil
                            if ($stmt->rowCount() > 0) {
                                echo "<ul>";

                                // Mengambil setiap baris data
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<li>Batch         : " . htmlspecialchars($row['Batch']) . "</li>";
                                    echo "<li>Varian        : " . htmlspecialchars($row['Varian']) . "</li>";
                                    echo "<li>PO Masak      : " . htmlspecialchars($row['PO_Masak']) . "</li>";
                                    echo "<li>No Formulasi  : " . htmlspecialchars($row['No_Formulasi']) . "</li>";
                                    echo "<li>Status GGA    : " . htmlspecialchars($row['Status_GGA']) . "</li>";
                                    echo "<li>Gula          : " . htmlspecialchars($row['Gula']) . "</li>";
                                    echo "<li><b>Hasil Analisa</b>" . "</li>";
                                    echo "<li>NaCl          : " . htmlspecialchars($row['NaCl_GGA']) . "</li>";
                                    echo "<li>Brix          : " . htmlspecialchars($row['Brix_GGA']) . "</li>";
                                    echo "<li>Warna         : " . htmlspecialchars($row['Warna_GGA']) . "</li>";
                                    echo "<li>Organo        : " . htmlspecialchars($row['Organo_GGA']) . "</li>";
                                    echo "<li>Status GGAS   : " . htmlspecialchars($row['Status_GGAS']) . "</li>";
                                    echo "<li><b>Hasil Analisa</b>" . "</li>";
                                    echo "<li>NaCl          : " . htmlspecialchars($row['NaCl_GGAS']) . "</li>";
                                    echo "<li>Brix          : " . htmlspecialchars($row['Brix_GGAS']) . "</li>";
                                    echo "<li>Warna         : " . htmlspecialchars($row['Warna_GGAS']) . "</li>";
                                    echo "<li>Organo        : " . htmlspecialchars($row['Organo_GGAS']) . "</li>";
                                }
                                echo "</ul>";
                            } else {
                                echo "Tidak ada data yang ditemukan.";
                            }
                        } catch (PDOException $e) {
                            echo "Koneksi gagal: " . $e->getMessage();
                        }

                        // Menutup koneksi
                        $koneksi = null;
                        ?>
                    </ul>
                    <button id="dissolver5">Insert</button>
                </div>
            </div>

            <!-- Tanki 6 -->
            <div class="blending-container">
                <div class="ujung-lancip"></div>
                <div class="isi-bahan-baku">
                    <h2>Dissolver 6</h2>
                    <ul>
                        <?php
                        try {
                            // Koneksi ke database
                            include '../../function/dissolver/koneksi.php';

                            $query = "SELECT * FROM dissolver6 ORDER BY id DESC LIMIT 1";
                            $stmt = $koneksi->prepare($query);
                            $stmt->execute();

                            // Memeriksa apakah ada hasil
                            if ($stmt->rowCount() > 0) {
                                echo "<ul>";

                                // Mengambil setiap baris data
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<li>Batch         : " . htmlspecialchars($row['Batch']) . "</li>";
                                    echo "<li>Varian        : " . htmlspecialchars($row['Varian']) . "</li>";
                                    echo "<li>PO Masak      : " . htmlspecialchars($row['PO_Masak']) . "</li>";
                                    echo "<li>No Formulasi  : " . htmlspecialchars($row['No_Formulasi']) . "</li>";
                                    echo "<li>Status GGA    : " . htmlspecialchars($row['Status_GGA']) . "</li>";
                                    echo "<li>Gula          : " . htmlspecialchars($row['Gula']) . "</li>";
                                    echo "<li><b>Hasil Analisa</b>" . "</li>";
                                    echo "<li>NaCl          : " . htmlspecialchars($row['NaCl_GGA']) . "</li>";
                                    echo "<li>Brix          : " . htmlspecialchars($row['Brix_GGA']) . "</li>";
                                    echo "<li>Warna         : " . htmlspecialchars($row['Warna_GGA']) . "</li>";
                                    echo "<li>Organo        : " . htmlspecialchars($row['Organo_GGA']) . "</li>";
                                    echo "<li>Status GGAS   : " . htmlspecialchars($row['Status_GGAS']) . "</li>";
                                    echo "<li><b>Hasil Analisa</b>" . "</li>";
                                    echo "<li>NaCl          : " . htmlspecialchars($row['NaCl_GGAS']) . "</li>";
                                    echo "<li>Brix          : " . htmlspecialchars($row['Brix_GGAS']) . "</li>";
                                    echo "<li>Warna         : " . htmlspecialchars($row['Warna_GGAS']) . "</li>";
                                    echo "<li>Organo        : " . htmlspecialchars($row['Organo_GGAS']) . "</li>";
                                }
                                echo "</ul>";
                            } else {
                                echo "Tidak ada data yang ditemukan.";
                            }
                        } catch (PDOException $e) {
                            echo "Koneksi gagal: " . $e->getMessage();
                        }

                        // Menutup koneksi
                        $koneksi = null;
                        ?>
                    </ul>
                    <button id="dissolver6">Insert</button>
                </div>
            </div>

            <!-- Tanki 7 -->
            <div class="blending-container">
                <div class="ujung-lancip"></div>
                <div class="isi-bahan-baku">
                    <h2>Dissolver 7</h2>
                    <ul>
                        <?php
                        try {
                            // Koneksi ke database
                            include '../../function/dissolver/koneksi.php';

                            $query = "SELECT * FROM dissolver7 ORDER BY id DESC LIMIT 1";
                            $stmt = $koneksi->prepare($query);
                            $stmt->execute();

                            // Memeriksa apakah ada hasil
                            if ($stmt->rowCount() > 0) {
                                echo "<ul>";

                                // Mengambil setiap baris data
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<li>Batch         : " . htmlspecialchars($row['Batch']) . "</li>";
                                    echo "<li>Varian        : " . htmlspecialchars($row['Varian']) . "</li>";
                                    echo "<li>PO Masak      : " . htmlspecialchars($row['PO_Masak']) . "</li>";
                                    echo "<li>No Formulasi  : " . htmlspecialchars($row['No_Formulasi']) . "</li>";
                                    echo "<li>Status GGA    : " . htmlspecialchars($row['Status_GGA']) . "</li>";
                                    echo "<li>Gula          : " . htmlspecialchars($row['Gula']) . "</li>";
                                    echo "<li><b>Hasil Analisa</b>" . "</li>";
                                    echo "<li>NaCl          : " . htmlspecialchars($row['NaCl_GGA']) . "</li>";
                                    echo "<li>Brix          : " . htmlspecialchars($row['Brix_GGA']) . "</li>";
                                    echo "<li>Warna         : " . htmlspecialchars($row['Warna_GGA']) . "</li>";
                                    echo "<li>Organo        : " . htmlspecialchars($row['Organo_GGA']) . "</li>";
                                    echo "<li>Status GGAS   : " . htmlspecialchars($row['Status_GGAS']) . "</li>";
                                    echo "<li><b>Hasil Analisa</b>" . "</li>";
                                    echo "<li>NaCl          : " . htmlspecialchars($row['NaCl_GGAS']) . "</li>";
                                    echo "<li>Brix          : " . htmlspecialchars($row['Brix_GGAS']) . "</li>";
                                    echo "<li>Warna         : " . htmlspecialchars($row['Warna_GGAS']) . "</li>";
                                    echo "<li>Organo        : " . htmlspecialchars($row['Organo_GGAS']) . "</li>";
                                }
                                echo "</ul>";
                            } else {
                                echo "Tidak ada data yang ditemukan.";
                            }
                        } catch (PDOException $e) {
                            echo "Koneksi gagal: " . $e->getMessage();
                        }

                        // Menutup koneksi
                        $koneksi = null;
                        ?>
                    </ul>
                    <button id="dissolver7">Insert</button>
                </div>
            </div>

            <!-- Tanki 8 -->
            <div class="blending-container">
                <div class="ujung-lancip"></div>
                <div class="isi-bahan-baku">
                    <h2>Dissolver 8</h2>
                    <ul>
                        <?php
                        try {
                            // Koneksi ke database
                            include '../../function/dissolver/koneksi.php';

                            $query = "SELECT * FROM dissolver8 ORDER BY id DESC LIMIT 1";
                            $stmt = $koneksi->prepare($query);
                            $stmt->execute();

                            // Memeriksa apakah ada hasil
                            if ($stmt->rowCount() > 0) {
                                echo "<ul>";

                                // Mengambil setiap baris data
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<li>Batch         : " . htmlspecialchars($row['Batch']) . "</li>";
                                    echo "<li>Varian        : " . htmlspecialchars($row['Varian']) . "</li>";
                                    echo "<li>PO Masak      : " . htmlspecialchars($row['PO_Masak']) . "</li>";
                                    echo "<li>No Formulasi  : " . htmlspecialchars($row['No_Formulasi']) . "</li>";
                                    echo "<li>Status GGA    : " . htmlspecialchars($row['Status_GGA']) . "</li>";
                                    echo "<li>Gula          : " . htmlspecialchars($row['Gula']) . "</li>";
                                    echo "<li><b>Hasil Analisa</b>" . "</li>";
                                    echo "<li>NaCl          : " . htmlspecialchars($row['NaCl_GGA']) . "</li>";
                                    echo "<li>Brix          : " . htmlspecialchars($row['Brix_GGA']) . "</li>";
                                    echo "<li>Warna         : " . htmlspecialchars($row['Warna_GGA']) . "</li>";
                                    echo "<li>Organo        : " . htmlspecialchars($row['Organo_GGA']) . "</li>";
                                    echo "<li>Status GGAS   : " . htmlspecialchars($row['Status_GGAS']) . "</li>";
                                    echo "<li><b>Hasil Analisa</b>" . "</li>";
                                    echo "<li>NaCl          : " . htmlspecialchars($row['NaCl_GGAS']) . "</li>";
                                    echo "<li>Brix          : " . htmlspecialchars($row['Brix_GGAS']) . "</li>";
                                    echo "<li>Warna         : " . htmlspecialchars($row['Warna_GGAS']) . "</li>";
                                    echo "<li>Organo        : " . htmlspecialchars($row['Organo_GGAS']) . "</li>";
                                }
                                echo "</ul>";
                            } else {
                                echo "Tidak ada data yang ditemukan.";
                            }
                        } catch (PDOException $e) {
                            echo "Koneksi gagal: " . $e->getMessage();
                        }

                        // Menutup koneksi
                        $koneksi = null;
                        ?>
                    </ul>
                    <button id="dissolver8">Insert</button>
                </div>
            </div>

            <!-- Inputan Dissolver 1 -->
            <div id="myModal1" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Tambah Data Dissolver 1</h2>
                    <form action="../../function/dissolver/input/tambah1.php" method="post">
                        <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">

                        <label for="Batch">Batch:</label>
                        <input type="text" id="Batch" name="Batch" required>

                        <label for="Varian">Varian:</label>
                        <select id="Varian" name="Varian" required>
                            <option value="BB">BB</option>
                            <option value="JB">JB</option>
                            <option value="SS1">SS1</option>
                            <option value="SS2">SS2</option>
                            <option value="MSD">MSD</option>
                            <option value="NR2">NR2</option>
                        </select>

                        <label for="masak">PO Masak:</label>
                        <input type="number" id="masak" name="masak" step="0.1" required>

                        <label for="formulasi">No Formulasi:</label>
                        <input type="number" id="formulasi" name="formulasi" step="0.1" required>

                        <label for="GGA">Status GGA:</label>
                        <select id="GGA" name="GGA" required>
                            <option value="0">0</option>
                            <option value="Start">Start</option>
                            <option value="Start Adjust 1">Start Adjust 1</option>
                            <option value="Finish Adjust 1">Finish Adjust 1</option>
                            <option value="Start Adjust 2">Start Adjust 2</option>
                            <option value="Finish Adjust 2">Finish Adjust 2</option>
                            <option value="Finish">Finish</option>
                            <option value="Drain">Drain</option>
                        </select>

                        <label for="Gula">Gula:</label>
                        <input type="number" id="Gula" name="Gula" step="0.1" required>

                        <label for="NaCl_GGA">Nacl:</label>
                        <input type="number" id="NaCl_GGA" name="NaCl_GGA" step="0.1" required>

                        <label for="Brix_GGA">Brix:</label>
                        <input type="number" id="Brix_GGA" name="Brix_GGA" step="0.1" required>

                        <label for="Warna_GGA">Warna:</label>
                        <input type="number" id="Warna_GGA" name="Warna_GGA" step="0.1" required>

                        <label for="Organo_GGA">Organo:</label>
                        <input type="number" id="Organo_GGA" name="Organo_GGA" step="0.1" required>

                        <label for="GGAS">Status GGAS:</label>
                        <select id="GGAS" name="GGAS" required>
                            <option value="0">0</option>
                            <option value="Start">Start</option>
                            <option value="Finish">Finish</option>
                            <option value="Drain">Drain</option>
                        </select>

                        <label for="NaCl_GGAS">Nacl:</label>
                        <input type="number" id="NaCl_GGAS" name="NaCl_GGAS" step="0.1" required>

                        <label for="Brix_GGAS">Brix:</label>
                        <input type="number" id="Brix_GGAS" name="Brix_GGAS" step="0.1" required>

                        <label for="Warna_GGAS">Warna:</label>
                        <input type="number" id="Warna_GGAS" name="Warna_GGAS" step="0.1" required>

                        <label for="Organo_GGAS">Organo:</label>
                        <input type="number" id="Organo_GGAS" name="Organo_GGAS" step="0.1" required>

                        <button type="submit" class="submit">Simpan</button>
                    </form>

                </div>
            </div>

            <!-- Inputan Dissolver 2 -->
            <div id="myModal2" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Tambah Data Dissolver 2</h2>
                    <form action="../../function/dissolver/input/tambah2.php" method="post">
                        <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">

                        <label for="Batch">Batch:</label>
                        <input type="text" id="Batch" name="Batch" required>

                        <label for="Varian">Varian:</label>
                        <select id="Varian" name="Varian" required>
                            <option value="BB">BB</option>
                            <option value="JB">JB</option>
                            <option value="SS1">SS1</option>
                            <option value="SS2">SS2</option>
                            <option value="MSD">MSD</option>
                            <option value="NR2">NR2</option>
                        </select>

                        <label for="masak">PO Masak:</label>
                        <input type="number" id="masak" name="masak" step="0.1" required>

                        <label for="formulasi">No Formulasi:</label>
                        <input type="number" id="formulasi" name="formulasi" step="0.1" required>

                        <label for="GGA">Status GGA:</label>
                        <select id="GGA" name="GGA" required>
                            <option value="0">0</option>
                            <option value="Start">Start</option>
                            <option value="Start Adjust 1">Start Adjust 1</option>
                            <option value="Finish Adjust 1">Finish Adjust 1</option>
                            <option value="Start Adjust 2">Start Adjust 2</option>
                            <option value="Finish Adjust 2">Finish Adjust 2</option>
                            <option value="Finish">Finish</option>
                            <option value="Drain">Drain</option>
                        </select>

                        <label for="Gula">Gula:</label>
                        <input type="number" id="Gula" name="Gula" step="0.1" required>

                        <label for="NaCl_GGA">Nacl:</label>
                        <input type="number" id="NaCl_GGA" name="NaCl_GGA" step="0.1" required>

                        <label for="Brix_GGA">Brix:</label>
                        <input type="number" id="Brix_GGA" name="Brix_GGA" step="0.1" required>

                        <label for="Warna_GGA">Warna:</label>
                        <input type="number" id="Warna_GGA" name="Warna_GGA" step="0.1" required>

                        <label for="Organo_GGA">Organo:</label>
                        <input type="number" id="Organo_GGA" name="Organo_GGA" step="0.1" required>

                        <label for="GGAS">Status GGAS:</label>
                        <select id="GGAS" name="GGAS" required>
                            <option value="0">0</option>
                            <option value="Start">Start</option>
                            <option value="Finish">Finish</option>
                            <option value="Drain">Drain</option>
                        </select>

                        <label for="NaCl_GGAS">Nacl:</label>
                        <input type="number" id="NaCl_GGAS" name="NaCl_GGAS" step="0.1" required>

                        <label for="Brix_GGAS">Brix:</label>
                        <input type="number" id="Brix_GGAS" name="Brix_GGAS" step="0.1" required>

                        <label for="Warna_GGAS">Warna:</label>
                        <input type="number" id="Warna_GGAS" name="Warna_GGAS" step="0.1" required>

                        <label for="Organo_GGAS">Organo:</label>
                        <input type="number" id="Organo_GGAS" name="Organo_GGAS" step="0.1" required>

                        <button type="submit" class="submit">Simpan</button>
                    </form>

                </div>
            </div>

            <!-- Inputan Dissolver 3 -->
            <div id="myModal3" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Tambah Data Dissolver 3</h2>
                    <form action="../../function/dissolver/input/tambah3.php" method="post">
                        <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">

                        <label for="Batch">Batch:</label>
                        <input type="text" id="Batch" name="Batch" required>

                        <label for="Varian">Varian:</label>
                        <select id="Varian" name="Varian" required>
                            <option value="BB">BB</option>
                            <option value="JB">JB</option>
                            <option value="SS1">SS1</option>
                            <option value="SS2">SS2</option>
                            <option value="MSD">MSD</option>
                            <option value="NR2">NR2</option>
                        </select>

                        <label for="masak">PO Masak:</label>
                        <input type="number" id="masak" name="masak" step="0.1" required>

                        <label for="formulasi">No Formulasi:</label>
                        <input type="number" id="formulasi" name="formulasi" step="0.1" required>

                        <label for="GGA">Status GGA:</label>
                        <select id="GGA" name="GGA" required>
                            <option value="0">0</option>
                            <option value="Start">Start</option>
                            <option value="Start Adjust 1">Start Adjust 1</option>
                            <option value="Finish Adjust 1">Finish Adjust 1</option>
                            <option value="Start Adjust 2">Start Adjust 2</option>
                            <option value="Finish Adjust 2">Finish Adjust 2</option>
                            <option value="Finish">Finish</option>
                            <option value="Drain">Drain</option>
                        </select>

                        <label for="Gula">Gula:</label>
                        <input type="number" id="Gula" name="Gula" step="0.1" required>

                        <label for="NaCl_GGA">Nacl:</label>
                        <input type="number" id="NaCl_GGA" name="NaCl_GGA" step="0.1" required>

                        <label for="Brix_GGA">Brix:</label>
                        <input type="number" id="Brix_GGA" name="Brix_GGA" step="0.1" required>

                        <label for="Warna_GGA">Warna:</label>
                        <input type="number" id="Warna_GGA" name="Warna_GGA" step="0.1" required>

                        <label for="Organo_GGA">Organo:</label>
                        <input type="number" id="Organo_GGA" name="Organo_GGA" step="0.1" required>

                        <label for="GGAS">Status GGAS:</label>
                        <select id="GGAS" name="GGAS" required>
                            <option value="0">0</option>
                            <option value="Start">Start</option>
                            <option value="Finish">Finish</option>
                            <option value="Drain">Drain</option>
                        </select>

                        <label for="NaCl_GGAS">Nacl:</label>
                        <input type="number" id="NaCl_GGAS" name="NaCl_GGAS" step="0.1" required>

                        <label for="Brix_GGAS">Brix:</label>
                        <input type="number" id="Brix_GGAS" name="Brix_GGAS" step="0.1" required>

                        <label for="Warna_GGAS">Warna:</label>
                        <input type="number" id="Warna_GGAS" name="Warna_GGAS" step="0.1" required>

                        <label for="Organo_GGAS">Organo:</label>
                        <input type="number" id="Organo_GGAS" name="Organo_GGAS" step="0.1" required>

                        <button type="submit" class="submit">Simpan</button>
                    </form>

                </div>
            </div>

            <!-- Inputan Dissolver 4 -->
            <div id="myModal4" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Tambah Data Dissolver 4</h2>
                    <form action="../../function/dissolver/input/tambah4.php" method="post">
                        <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">

                        <label for="Batch">Batch:</label>
                        <input type="text" id="Batch" name="Batch" required>

                        <label for="Varian">Varian:</label>
                        <select id="Varian" name="Varian" required>
                            <option value="BB">BB</option>
                            <option value="JB">JB</option>
                            <option value="SS1">SS1</option>
                            <option value="SS2">SS2</option>
                            <option value="MSD">MSD</option>
                            <option value="NR2">NR2</option>
                        </select>

                        <label for="masak">PO Masak:</label>
                        <input type="number" id="masak" name="masak" step="0.1" required>

                        <label for="formulasi">No Formulasi:</label>
                        <input type="number" id="formulasi" name="formulasi" step="0.1" required>

                        <label for="GGA">Status GGA:</label>
                        <select id="GGA" name="GGA" required>
                            <option value="0">0</option>
                            <option value="Start">Start</option>
                            <option value="Start Adjust 1">Start Adjust 1</option>
                            <option value="Finish Adjust 1">Finish Adjust 1</option>
                            <option value="Start Adjust 2">Start Adjust 2</option>
                            <option value="Finish Adjust 2">Finish Adjust 2</option>
                            <option value="Finish">Finish</option>
                            <option value="Drain">Drain</option>
                        </select>

                        <label for="Gula">Gula:</label>
                        <input type="number" id="Gula" name="Gula" step="0.1" required>

                        <label for="NaCl_GGA">Nacl:</label>
                        <input type="number" id="NaCl_GGA" name="NaCl_GGA" step="0.1" required>

                        <label for="Brix_GGA">Brix:</label>
                        <input type="number" id="Brix_GGA" name="Brix_GGA" step="0.1" required>

                        <label for="Warna_GGA">Warna:</label>
                        <input type="number" id="Warna_GGA" name="Warna_GGA" step="0.1" required>

                        <label for="Organo_GGA">Organo:</label>
                        <input type="number" id="Organo_GGA" name="Organo_GGA" step="0.1" required>

                        <label for="GGAS">Status GGAS:</label>
                        <select id="GGAS" name="GGAS" required>
                            <option value="0">0</option>
                            <option value="Start">Start</option>
                            <option value="Finish">Finish</option>
                            <option value="Drain">Drain</option>
                        </select>

                        <label for="NaCl_GGAS">Nacl:</label>
                        <input type="number" id="NaCl_GGAS" name="NaCl_GGAS" step="0.1" required>

                        <label for="Brix_GGAS">Brix:</label>
                        <input type="number" id="Brix_GGAS" name="Brix_GGAS" step="0.1" required>

                        <label for="Warna_GGAS">Warna:</label>
                        <input type="number" id="Warna_GGAS" name="Warna_GGAS" step="0.1" required>

                        <label for="Organo_GGAS">Organo:</label>
                        <input type="number" id="Organo_GGAS" name="Organo_GGAS" step="0.1" required>

                        <button type="submit" class="submit">Simpan</button>
                    </form>

                </div>
            </div>

            <!-- Inputan Dissolver 5 -->
            <div id="myModal5" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Tambah Data Dissolver 5</h2>
                    <form action="../../function/dissolver/input/tambah5.php" method="post">
                        <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">

                        <label for="Batch">Batch:</label>
                        <input type="text" id="Batch" name="Batch" required>

                        <label for="Varian">Varian:</label>
                        <select id="Varian" name="Varian" required>
                            <option value="BB">BB</option>
                            <option value="JB">JB</option>
                            <option value="SS1">SS1</option>
                            <option value="SS2">SS2</option>
                            <option value="MSD">MSD</option>
                            <option value="NR2">NR2</option>
                        </select>

                        <label for="masak">PO Masak:</label>
                        <input type="number" id="masak" name="masak" step="0.1" required>

                        <label for="formulasi">No Formulasi:</label>
                        <input type="number" id="formulasi" name="formulasi" step="0.1" required>

                        <label for="GGA">Status GGA:</label>
                        <select id="GGA" name="GGA" required>
                            <option value="0">0</option>
                            <option value="Start">Start</option>
                            <option value="Start Adjust 1">Start Adjust 1</option>
                            <option value="Finish Adjust 1">Finish Adjust 1</option>
                            <option value="Start Adjust 2">Start Adjust 2</option>
                            <option value="Finish Adjust 2">Finish Adjust 2</option>
                            <option value="Finish">Finish</option>
                            <option value="Drain">Drain</option>
                        </select>

                        <label for="Gula">Gula:</label>
                        <input type="number" id="Gula" name="Gula" step="0.1" required>

                        <label for="NaCl_GGA">Nacl:</label>
                        <input type="number" id="NaCl_GGA" name="NaCl_GGA" step="0.1" required>

                        <label for="Brix_GGA">Brix:</label>
                        <input type="number" id="Brix_GGA" name="Brix_GGA" step="0.1" required>

                        <label for="Warna_GGA">Warna:</label>
                        <input type="number" id="Warna_GGA" name="Warna_GGA" step="0.1" required>

                        <label for="Organo_GGA">Organo:</label>
                        <input type="number" id="Organo_GGA" name="Organo_GGA" step="0.1" required>

                        <label for="GGAS">Status GGAS:</label>
                        <select id="GGAS" name="GGAS" required>
                            <option value="0">0</option>
                            <option value="Start">Start</option>
                            <option value="Finish">Finish</option>
                            <option value="Drain">Drain</option>
                        </select>

                        <label for="NaCl_GGAS">Nacl:</label>
                        <input type="number" id="NaCl_GGAS" name="NaCl_GGAS" step="0.1" required>

                        <label for="Brix_GGAS">Brix:</label>
                        <input type="number" id="Brix_GGAS" name="Brix_GGAS" step="0.1" required>

                        <label for="Warna_GGAS">Warna:</label>
                        <input type="number" id="Warna_GGAS" name="Warna_GGAS" step="0.1" required>

                        <label for="Organo_GGAS">Organo:</label>
                        <input type="number" id="Organo_GGAS" name="Organo_GGAS" step="0.1" required>

                        <button type="submit" class="submit">Simpan</button>
                    </form>

                </div>
            </div>

            <!-- Inputan Dissolver 6 -->
            <div id="myModal6" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Tambah Data Dissolver 6</h2>
                    <form action="../../function/dissolver/input/tambah6.php" method="post">
                        <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">

                        <label for="Batch">Batch:</label>
                        <input type="text" id="Batch" name="Batch" required>

                        <label for="Varian">Varian:</label>
                        <select id="Varian" name="Varian" required>
                            <option value="BB">BB</option>
                            <option value="JB">JB</option>
                            <option value="SS1">SS1</option>
                            <option value="SS2">SS2</option>
                            <option value="MSD">MSD</option>
                            <option value="NR2">NR2</option>
                        </select>

                        <label for="masak">PO Masak:</label>
                        <input type="number" id="masak" name="masak" step="0.1" required>

                        <label for="formulasi">No Formulasi:</label>
                        <input type="number" id="formulasi" name="formulasi" step="0.1" required>

                        <label for="GGA">Status GGA:</label>
                        <select id="GGA" name="GGA" required>
                            <option value="0">0</option>
                            <option value="Start">Start</option>
                            <option value="Start Adjust 1">Start Adjust 1</option>
                            <option value="Finish Adjust 1">Finish Adjust 1</option>
                            <option value="Start Adjust 2">Start Adjust 2</option>
                            <option value="Finish Adjust 2">Finish Adjust 2</option>
                            <option value="Finish">Finish</option>
                            <option value="Drain">Drain</option>
                        </select>

                        <label for="Gula">Gula:</label>
                        <input type="number" id="Gula" name="Gula" step="0.1" required>

                        <label for="NaCl_GGA">Nacl:</label>
                        <input type="number" id="NaCl_GGA" name="NaCl_GGA" step="0.1" required>

                        <label for="Brix_GGA">Brix:</label>
                        <input type="number" id="Brix_GGA" name="Brix_GGA" step="0.1" required>

                        <label for="Warna_GGA">Warna:</label>
                        <input type="number" id="Warna_GGA" name="Warna_GGA" step="0.1" required>

                        <label for="Organo_GGA">Organo:</label>
                        <input type="number" id="Organo_GGA" name="Organo_GGA" step="0.1" required>

                        <label for="GGAS">Status GGAS:</label>
                        <select id="GGAS" name="GGAS" required>
                            <option value="0">0</option>
                            <option value="Start">Start</option>
                            <option value="Finish">Finish</option>
                            <option value="Drain">Drain</option>
                        </select>

                        <label for="NaCl_GGAS">Nacl:</label>
                        <input type="number" id="NaCl_GGAS" name="NaCl_GGAS" step="0.1" required>

                        <label for="Brix_GGAS">Brix:</label>
                        <input type="number" id="Brix_GGAS" name="Brix_GGAS" step="0.1" required>

                        <label for="Warna_GGAS">Warna:</label>
                        <input type="number" id="Warna_GGAS" name="Warna_GGAS" step="0.1" required>

                        <label for="Organo_GGAS">Organo:</label>
                        <input type="number" id="Organo_GGAS" name="Organo_GGAS" step="0.1" required>

                        <button type="submit" class="submit">Simpan</button>
                    </form>

                </div>
            </div>

            <!-- Inputan Dissolver 7 -->
            <div id="myModal7" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Tambah Data Dissolver 7</h2>
                    <form action="../../function/dissolver/input/tambah7.php" method="post">
                        <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">

                        <label for="Batch">Batch:</label>
                        <input type="text" id="Batch" name="Batch" required>

                        <label for="Varian">Varian:</label>
                        <select id="Varian" name="Varian" required>
                            <option value="BB">BB</option>
                            <option value="JB">JB</option>
                            <option value="SS1">SS1</option>
                            <option value="SS2">SS2</option>
                            <option value="MSD">MSD</option>
                            <option value="NR2">NR2</option>
                        </select>

                        <label for="masak">PO Masak:</label>
                        <input type="number" id="masak" name="masak" step="0.1" required>

                        <label for="formulasi">No Formulasi:</label>
                        <input type="number" id="formulasi" name="formulasi" step="0.1" required>

                        <label for="GGA">Status GGA:</label>
                        <select id="GGA" name="GGA" required>
                            <option value="0">0</option>
                            <option value="Start">Start</option>
                            <option value="Start Adjust 1">Start Adjust 1</option>
                            <option value="Finish Adjust 1">Finish Adjust 1</option>
                            <option value="Start Adjust 2">Start Adjust 2</option>
                            <option value="Finish Adjust 2">Finish Adjust 2</option>
                            <option value="Finish">Finish</option>
                            <option value="Drain">Drain</option>
                        </select>

                        <label for="Gula">Gula:</label>
                        <input type="number" id="Gula" name="Gula" step="0.1" required>

                        <label for="NaCl_GGA">Nacl:</label>
                        <input type="number" id="NaCl_GGA" name="NaCl_GGA" step="0.1" required>

                        <label for="Brix_GGA">Brix:</label>
                        <input type="number" id="Brix_GGA" name="Brix_GGA" step="0.1" required>

                        <label for="Warna_GGA">Warna:</label>
                        <input type="number" id="Warna_GGA" name="Warna_GGA" step="0.1" required>

                        <label for="Organo_GGA">Organo:</label>
                        <input type="number" id="Organo_GGA" name="Organo_GGA" step="0.1" required>

                        <label for="GGAS">Status GGAS:</label>
                        <select id="GGAS" name="GGAS" required>
                            <option value="0">0</option>
                            <option value="Start">Start</option>
                            <option value="Finish">Finish</option>
                            <option value="Drain">Drain</option>
                        </select>

                        <label for="NaCl_GGAS">Nacl:</label>
                        <input type="number" id="NaCl_GGAS" name="NaCl_GGAS" step="0.1" required>

                        <label for="Brix_GGAS">Brix:</label>
                        <input type="number" id="Brix_GGAS" name="Brix_GGAS" step="0.1" required>

                        <label for="Warna_GGAS">Warna:</label>
                        <input type="number" id="Warna_GGAS" name="Warna_GGAS" step="0.1" required>

                        <label for="Organo_GGAS">Organo:</label>
                        <input type="number" id="Organo_GGAS" name="Organo_GGAS" step="0.1" required>

                        <button type="submit" class="submit">Simpan</button>
                    </form>

                </div>
            </div>

            <!-- Inputan Dissolver 8 -->
            <div id="myModal8" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Tambah Data Dissolver 8</h2>
                    <form action="../../function/dissolver/input/tambah8.php" method="post">
                        <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">

                        <label for="Batch">Batch:</label>
                        <input type="text" id="Batch" name="Batch" required>

                        <label for="Varian">Varian:</label>
                        <select id="Varian" name="Varian" required>
                            <option value="BB">BB</option>
                            <option value="JB">JB</option>
                            <option value="SS1">SS1</option>
                            <option value="SS2">SS2</option>
                            <option value="MSD">MSD</option>
                            <option value="NR2">NR2</option>
                        </select>

                        <label for="masak">PO Masak:</label>
                        <input type="number" id="masak" name="masak" step="0.1" required>

                        <label for="formulasi">No Formulasi:</label>
                        <input type="number" id="formulasi" name="formulasi" step="0.1" required>

                        <label for="GGA">Status GGA:</label>
                        <select id="GGA" name="GGA" required>
                            <option value="0">0</option>
                            <option value="Start">Start</option>
                            <option value="Start Adjust 1">Start Adjust 1</option>
                            <option value="Finish Adjust 1">Finish Adjust 1</option>
                            <option value="Start Adjust 2">Start Adjust 2</option>
                            <option value="Finish Adjust 2">Finish Adjust 2</option>
                            <option value="Finish">Finish</option>
                            <option value="Drain">Drain</option>
                        </select>

                        <label for="Gula">Gula:</label>
                        <input type="number" id="Gula" name="Gula" step="0.1" required>

                        <label for="NaCl_GGA">Nacl:</label>
                        <input type="number" id="NaCl_GGA" name="NaCl_GGA" step="0.1" required>

                        <label for="Brix_GGA">Brix:</label>
                        <input type="number" id="Brix_GGA" name="Brix_GGA" step="0.1" required>

                        <label for="Warna_GGA">Warna:</label>
                        <input type="number" id="Warna_GGA" name="Warna_GGA" step="0.1" required>

                        <label for="Organo_GGA">Organo:</label>
                        <input type="number" id="Organo_GGA" name="Organo_GGA" step="0.1" required>

                        <label for="GGAS">Status GGAS:</label>
                        <select id="GGAS" name="GGAS" required>
                            <option value="0">0</option>
                            <option value="Start">Start</option>
                            <option value="Finish">Finish</option>
                            <option value="Drain">Drain</option>
                        </select>

                        <label for="NaCl_GGAS">Nacl:</label>
                        <input type="number" id="NaCl_GGAS" name="NaCl_GGAS" step="0.1" required>

                        <label for="Brix_GGAS">Brix:</label>
                        <input type="number" id="Brix_GGAS" name="Brix_GGAS" step="0.1" required>

                        <label for="Warna_GGAS">Warna:</label>
                        <input type="number" id="Warna_GGAS" name="Warna_GGAS" step="0.1" required>

                        <label for="Organo_GGAS">Organo:</label>
                        <input type="number" id="Organo_GGAS" name="Organo_GGAS" step="0.1" required>

                        <button type="submit" class="submit">Simpan</button>
                    </form>

                </div>
            </div>
        </div>
    </div>


    <script>
        // Ambil tahun saat ini
        document.getElementById("date").textContent = new Date().getFullYear();

        var btn1 = document.getElementById("dissolver1");
        var btn2 = document.getElementById("dissolver2");
        var btn3 = document.getElementById("dissolver3");
        var btn4 = document.getElementById("dissolver4");
        var btn5 = document.getElementById("dissolver5");
        var btn6 = document.getElementById("dissolver6");
        var btn7 = document.getElementById("dissolver7");
        var btn8 = document.getElementById("dissolver8");
        var modal1 = document.getElementById("myModal1");
        var modal2 = document.getElementById("myModal2");
        var modal3 = document.getElementById("myModal3");
        var modal4 = document.getElementById("myModal4");
        var modal5 = document.getElementById("myModal5");
        var modal6 = document.getElementById("myModal6");
        var modal7 = document.getElementById("myModal7");
        var modal8 = document.getElementById("myModal8");
        var spans = document.getElementsByClassName("close");

        // Fungsi untuk membuka modal
        function openModal(modal) {
            modal.style.display = "block";
        }

        // Ketika tombol diklik, buka modal
        btn1.onclick = function() {
            openModal(modal1);
        };
        btn2.onclick = function() {
            openModal(modal2);
        };
        btn3.onclick = function() {
            openModal(modal3);
        };
        btn4.onclick = function() {
            openModal(modal4);
        };
        btn5.onclick = function() {
            openModal(modal5);
        };
        btn6.onclick = function() {
            openModal(modal6);
        };
        btn7.onclick = function() {
            openModal(modal7);
        };
        btn8.onclick = function() {
            openModal(modal8);
        };

        // Ketika tombol close diklik, tutup modal
        for (var i = 0; i < spans.length; i++) {
            spans[i].onclick = function() {
                modal1.style.display = "none";
                modal2.style.display = "none";
                modal3.style.display = "none";
                modal4.style.display = "none";
                modal5.style.display = "none";
                modal6.style.display = "none";
                modal7.style.display = "none";
                modal8.style.display = "none";
            };
        }

        // Ketika user mengklik di luar modal, tutup modal
        window.onclick = function(event) {
            if (event.target === modal1) {
                modal1.style.display = "none";
            } else if (event.target === modal2) {
                modal2.style.display = "none";
            } else if (event.target === modal3) {
                modal3.style.display = "none";
            } else if (event.target === modal4) {
                modal4.style.display = "none";
            } else if (event.target === modal5) {
                modal5.style.display = "none";
            } else if (event.target === modal6) {
                modal6.style.display = "none";
            } else if (event.target === modal7) {
                modal7.style.display = "none";
            } else if (event.target === modal8) {
                modal8.style.display = "none";
            }
        };
    </script>

</body>

</html>