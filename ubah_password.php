<?php
// beranda.php

// Pastikan sesi sudah dimulai
session_start();
include 'config/koneksi.php';

// Periksa apakah pengguna sudah login (sesi username sudah ada)
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    try {
        // Gunakan prepared statement untuk mencegah SQL injection
        $stmt = $koneksi->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $data_user = $stmt->fetch(PDO::FETCH_ASSOC); // Hapus parameter pada fetch()

        // Sekarang, Anda dapat menggunakan nilai $data_user sesuai kebutuhan
    } catch (PDOException $e) {
        $response = array('status' => 'error', 'message' => 'Koneksi Gagal: ' . $e->getMessage());
    }
} else {
    // Jika tidak ada sesi username, mungkin pengguna belum login, arahkan ke halaman login
    header("Location: login.php");
    exit(); // Pastikan untuk keluar agar kode di bawah tidak dijalankan
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Password</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        /* Style untuk tata letak dan tampilan formulir */
        .eye-icon {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="text-center mb-4">Ubah Password</h2>
                        <form action="config/autentikasi/proses_ubah_password.php" method="post">
                            <div class="form-group">
                                <label for="new_password">Password Baru:</label>
                                <div class="input-group">
                                    <input type="password" id="new_password" name="new_password"
                                        placeholder="Masukan password baru" class="form-control" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text eye-icon" 
                                            onclick="togglePasswordVisibility('new_password', 'toggle_new_password')">
                                            <i id="toggle_new_password" class="fa fa-eye"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="confirm_password">Konfirmasi Password Baru:</label>
                                <div class="input-group">
                                    <input type="password" id="confirm_password" name="confirm_password" placeholder="Konfirmasi password baru"
                                        class="form-control" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text eye-icon"
                                            onclick="togglePasswordVisibility('confirm_password', 'toggle_confirm_password')">
                                            <i id="toggle_confirm_password" class="fa fa-eye"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-info btn-block" value="Ubah Password">
                            </div>
                        </form>
                        <form action="beranda.php" method="get">
                            <div class="form-group">
                                <button type="submit" class="btn btn-secondary btn-block">Kembali</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePasswordVisibility(inputId, iconId) {
            var input = document.getElementById(inputId);
            var icon = document.getElementById(iconId);

            if (input.type === "password") {
                input.type = "text";
                icon.className = "fa fa-eye-slash";
            } else {
                input.type = "password";
                icon.className = "fa fa-eye";
            }
        }
    </script>

</body>

</html>
