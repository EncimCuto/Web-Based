<?php
session_start();

require_once '../function/koneksi_login.php';

$username = $_POST['username'];
$password = md5($_POST['password']);

$query = "SELECT id, Nama, username, bagian, mesin FROM user WHERE username = :username AND password = :password";
$stmt = $koneksi->prepare($query);
$stmt->bindParam(':username', $username);
$stmt->bindParam(':password', $password);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    $token = md5(uniqid());

    $_SESSION['token'] = $token;
    $_SESSION['id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['Nama'] = $user['Nama'];
    $_SESSION['bagian'] = $user['bagian'];
    $_SESSION['mesin'] = $user['mesin'];

    setcookie('token', $token, time() + 86400, "/");

    if ($user['mesin'] == 'all') {
        header('Location: ../page/admin.php?token=' .  $token);
    } else {
        header('Location: ../pages/dashboard.php?token=' .  $token);
    }
    exit;
} else {
    // Setel pesan error sesi
    $_SESSION['login_error'] = "Username atau password salah.";

    // Redirect kembali ke halaman login dengan parameter error
    header('Location: ../index.php?error=login_failed');
    exit;
}
