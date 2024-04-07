<?php
header('Content-Type: application/json');

include '../koneksi.php';

// Mulai sesi PHP
session_start();

// Inisialisasi langsung username dan password
$username = $_POST['username'];
$password = $_POST['password'];

if (isset($username) && isset($password)) {
    // Mengambil data pengguna dari database berdasarkan username
    $statement = $koneksi->prepare("SELECT * FROM users WHERE username = ?");
    $statement->execute([$username]);
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    if ($user && sha1($password) === $user['password']) {
        // Verifikasi password menggunakan sha1 (sesuai dengan metode Anda)
        $session_token = bin2hex(random_bytes(16));

        $updateStatement = $koneksi->prepare("UPDATE users SET session_token = ? WHERE username = ?");
        $updateStatement->execute([$session_token, $username]);

        // Mengambil informasi status user dari database
        $status_user = $user['status_user'];
        $sesion_username = $user['username'];
        $sesion_foto = $user['foto'];

        // Set the username in the session variable
        $_SESSION['username'] = $sesion_username;
        $_SESSION['foto'] = $sesion_foto;

        // Menyusun respons JSON dengan informasi status user
        $response = array('status' => 'success', 'status_user' => $status_user);

        // Redirect based on status_user using header
        if ($status_user === 'admin') {
            header('Location: ../../beranda.php');
            exit();
        } else if ($status_user === 'user') {
            header('Location: ../../pesan_kamar.php');
            exit();
        } else {
            // Redirect to a default login page if status_user is neither admin nor user
            header('Location: ../../login.php');
            exit();
        }
    } else {
        // Jika verifikasi gagal, kirim pesan kesalahan
        $response = ['status' => 'error', 'message' => 'Kredensial tidak valid'];
        echo json_encode($response);
    }
} else {
    // Jika permintaan tidak valid, kirim pesan kesalahan
    $response = ['status' => 'error', 'message' => 'Permintaan tidak valid'];
    echo json_encode($response);
}
?>
