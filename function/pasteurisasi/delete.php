<?php
if (isset($_GET['id']) && isset($_GET['token'])) {
    include "../../function/pasteurisasi/koneksi.php";

    // Mulai sesi untuk memastikan token valid
    session_start();
    if (!isset($_SESSION['token']) || $_SESSION['token'] !== $_GET['token']) {
        header("Location: ../../pages/pasteurisasi/excel.php?message=Token tidak valid");
        exit;
    }

    $id = (int)$_GET['id'];
    $stmt = $koneksi->prepare("DELETE FROM db_excel WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: ../../pages/pasteurisasi/excel.php?token=" . urlencode($_SESSION['token']) . "&message=Data berhasil dihapus");
    } else {
        header("Location: ../../pages/pasteurisasi/excel.php?token=" . urlencode($_SESSION['token']) . "&message=Gagal menghapus data");
    }

    $stmt->close();
    $koneksi->close();
} else {
    header("Location: ../../pages/pasteurisasi/excel.php?message=Parameter ID tidak valid");
    exit();
}
