<?php
// beranda.php

// Pastikan sesi sudah dimulai
session_start();
include 'config/koneksi.php';

// Periksa apakah pengguna sudah login (sesi username sudah ada)
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $foto = $_SESSION['foto'];
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
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Profile Page</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            background: #ecf0f3;
        }

        .container {
            background: rgb(22, 106, 145);
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #68b2c8;
        }

        .profile-button {
            background: #34353b;
            box-shadow: none;
            border: none;
        }

        .profile-button:hover {
            background: #1d5d91;
        }
    </style>
</head>

<body>
    <form action="config/simpan_perubahan.php" method="POST" enctype="multipart/form-data">
        <div class="container rounded bg-dark-light mt-5">
            <div class="row">
                <div class="col-md-4 border-right">
                    <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img
                            class="rounded-circle mt-5" src="config/uploads/<?php echo $foto; ?>" width="90"><span
                            class="font-weight-bold" style="color:#ffffff;">
                            <?php echo $username; ?>
                        </span><span class="text-black-50">
                            <?php echo $data_user['email']; ?>
                        </span><span>INDONESIA</span></div>
                </div>
                <div class="col-md-8">
                    <div class="p-3 py-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex flex-row align-items-center back">
                                <a href="pesan_kamar.php" style="color:#ffffff; text-decoration:none; ">Back to home</a>
                            </div>
                            <h6 class="text-right">Edit Profile</h6>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6"><input type="text" name="username" class="form-control" readonly
                                    value="<?php echo $data_user['username']; ?>"></div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6"><input type="text" name="nama" class="form-control"
                                    placeholder="username" value="<?php echo $data_user['nama']; ?>"></div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6"><input type="text" name="email" class="form-control"
                                    placeholder="Email" value="<?php echo $data_user['email']; ?>"></div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6"><input type="text" name="no_telpon" class="form-control"
                                    placeholder="nomer telpon" value="<?php echo $data_user['no_telpon']; ?>"></div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6"><input id="foto" type="file" name="foto" class="form-control"
                                    accept="image/*"></div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="old_foto"
                                    value="<?php echo $data_user['foto']; ?>" readonly>
                            </div>

                        </div>
                        <div class="mt-5 text-right">
                            <button class="btn btn-primary profile-button" type="submit">Save Profile</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>
    <script>
        // Check if there's a notification in the URL
        const urlParams = new URLSearchParams(window.location.search);
        const notification = urlParams.get('notif');

        // Display notification if present
        if (notification) {
            alert(notification);
        }
    </script>
    <!-- Bootstrap JS and jQuery (for file input styling) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
</body>

</html>