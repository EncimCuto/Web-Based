<?php
session_start();
require_once '../koneksi.php';

if (!isset($_SESSION['token']) || $_SESSION['token'] !== $_POST['token']) {
    header('Location: ../../../pages/dissolver/dissolver.php');
    exit;
}

$Batch          = $_POST['Batch'];
$Varian         = $_POST['Varian'];
$masak          = $_POST['masak'];
$formulasi      = $_POST['formulasi'];
$GGA            = $_POST['GGA'];
$Gula           = $_POST['Gula'];
$NaCl_GGA       = $_POST['NaCl_GGA'];
$Brix_GGA       = $_POST['Brix_GGA'];
$Warna_GGA      = $_POST['Warna_GGA'];
$Organo_GGA     = $_POST['Organo_GGA'];
$Status_GGAS    = $_POST['GGAS'];
$NaCl_GGAS      = $_POST['NaCl_GGAS'];
$Brix_GGAS      = $_POST['Brix_GGAS'];
$Warna_GGAS     = $_POST['Warna_GGAS'];
$Organo_GGAS    = $_POST['Organo_GGAS'];


$stmt = $koneksi->prepare(
    "INSERT INTO dissolver4 (Batch, Varian, PO_Masak, No_Formulasi, Status_GGA, Gula, NaCl_GGA, Brix_GGA, Warna_GGA, Organo_GGA, Status_GGAS, NaCl_GGAS, Brix_GGAS, Warna_GGAS, Organo_GGAS) 
        VALUES (:Batch, :Varian, :masak, :formulasi, :GGA, :Gula, :NaCl_GGA, :Brix_GGA, :Warna_GGA, :Organo_GGA, :Status_GGAS, :NaCl_GGAS, :Brix_GGAS, :Warna_GGAS, :Organo_GGAS)"
);
$stmt->bindParam(':Batch', $Batch);
$stmt->bindParam(':Varian', $Varian);
$stmt->bindParam(':masak', $masak);
$stmt->bindParam(':formulasi', $formulasi);
$stmt->bindParam(':GGA', $GGA);
$stmt->bindParam(':Gula', $Gula);
$stmt->bindParam(':NaCl_GGA', $NaCl_GGA);
$stmt->bindParam(':Brix_GGA', $Brix_GGA);
$stmt->bindParam(':Warna_GGA', $Warna_GGA);
$stmt->bindParam(':Organo_GGA', $Organo_GGA);
$stmt->bindParam(':Status_GGAS', $Status_GGAS);
$stmt->bindParam(':NaCl_GGAS', $NaCl_GGAS);
$stmt->bindParam(':Brix_GGAS', $Brix_GGAS);
$stmt->bindParam(':Warna_GGAS', $Warna_GGAS);
$stmt->bindParam(':Organo_GGAS', $Organo_GGAS);
$stmt->execute();

header("Location: ../../../pages/dissolver/dissolver.php?token=" . urlencode($_POST['token']));
exit;
