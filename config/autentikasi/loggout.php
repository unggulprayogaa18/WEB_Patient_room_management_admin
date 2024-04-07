<?php
session_start();

include '../koneksi.php';

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    // Update session_token menjadi NULL di database
    $updateStatement = $koneksi->prepare("UPDATE users SET session_token = NULL WHERE username = ?");
    $updateStatement->execute([$username]);

    // Hancurkan sesi
    session_destroy();

    // Arahkan ke halaman home.php
    header('Location: ../../index.php');
    exit(); // Pastikan untuk keluar setelah mengarahkan
} else {
    // Jika tidak ada sesi yang aktif, arahkan kembali ke halaman home.php
    header('Location: ../../index.php');
    exit(); // Pastikan untuk keluar setelah mengarahkan
}
?>
