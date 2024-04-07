<?php
// proses_ubah_password.php

// Pastikan sesi sudah dimulai
session_start();
include '../koneksi.php';

// Periksa apakah pengguna sudah login (sesi username sudah ada)
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    try {
        // Ambil data yang di-submit dari form
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        // Validasi konfirmasi password
        if ($new_password !== $confirm_password) {
            // Jika konfirmasi password tidak sesuai, arahkan kembali ke halaman ubah password
            header("Location: beranda.php?error=password_mismatch");
            exit();
        }

        // Konversi password baru ke SHA1
        $sha1_password = sha1($new_password);

        // Update password di database
        $stmt = $koneksi->prepare("UPDATE users SET password = ? WHERE username = ?");
        $stmt->execute([$sha1_password, $username]);

        // Redirect ke halaman beranda dengan pesan sukses
        header("Location: ../../beranda.php?success=password_changed");
        exit();
    } catch (PDOException $e) {
        // Tangani kesalahan koneksi/database
        $response = array('status' => 'error', 'message' => 'Koneksi Gagal: ' . $e->getMessage());
        // Anda bisa menambahkan log atau pesan kesalahan yang sesuai dengan kebutuhan
    }
} else {
    // Jika tidak ada sesi username, mungkin pengguna belum login, arahkan ke halaman login
    header("Location: login.php");
    exit(); // Pastikan untuk keluar agar kode di bawah tidak dijalankan
}
?>
