<?php

try {
    $koneksi = new PDO("mysql:host=localhost;dbname=dissolverdb", "root", "");
    // Set atribut error mode PDO untuk menangkap error
    $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Koneksi gagal: " . $e->getMessage();
}
