<?php
// beranda.php

// Pastikan sesi sudah dimulai
session_start();
include 'config/koneksi.php';

// Periksa apakah pengguna sudah login (sesi username sudah ada)
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $foto = $_SESSION['foto'];

    // Sekarang, Anda dapat menggunakan nilai $username sesuai kebutuhan
    echo "Selamat datang, $username!";
} else {
    // Jika tidak ada sesi username, mungkin pengguna belum login, arahkan ke halaman login
    header("Location: login.php");
    exit(); // Pastikan untuk keluar agar kode di bawah tidak dijalankan
}


if(isset($_SESSION['error_message'])) {
    // Simpan pesan kesalahan dalam variabel JavaScript
    echo "<script>var errorMessage = '{$_SESSION['error_message']}';</script>";
    // Hapus pesan kesalahan dari session setelah ditampilkan
    unset($_SESSION['error_message']);
} else {
    // Jika tidak ada pesan kesalahan, tetapkan variabel JavaScript sebagai string kosong
    echo "<script>var errorMessage = '';</script>";
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

        * {
            margin: 0;
            padding: 0;
            font-family: "Poppins", sans-serif;
        }

        body {
            height: 100px;
            /* Set the height to the full viewport height */
            background-image: url('assets2/img/hero-bg.jpg');
            background-size: cover;
            background-repeat: no-repeat;

        }

        .container {
            display: flex;
            text-align: center;
            align-items: center;
        }

        .contentvisible {
            background: linear-gradient(to right, rgba(39, 41, 41, 0.74), rgba(50, 50, 51, 0.61), rgba(36, 34, 34, 0.753));
            background-size: cover;
            height: 100px;
        }

        .contentvisible2 {
            background: linear-gradient(to right, rgba(60, 66, 68, 0.74), rgba(50, 50, 51, 0.61), rgba(36, 34, 34, 0.753)), url('assets2/img/hero-bg.jpg');
            background-size: cover;
            height: 100px;
        }

        .content {
            background-color: white;
            height: 720px;
            width: 100%;
        }

        .footer {
            height: 40px;
            background-color: white;
            width: 100%;
        }

        .content {
            display: flex;
            justify-content: center;
            padding-top: 20px;
        }

        .kotak {
            display: flex;
            flex-direction: column;
            /* Updated to column */
            align-items: center;
            height: 670px;
            width: 700px;
            border: 2px solid rgba(3, 3, 3, 0.404);
            margin-right: 20px;
            padding: 20px;
            /* Added padding */
        }

        .kotak2 {
            display: flex;
            height: 290px;
            width: 560px;
            border: 2px solid rgba(3, 3, 3, 0.404);
            margin-bottom: 20px;
        }


        .kotak3 {
            display: flex;
            height: 360px;
            width: 560px;
            border: 2px solid rgba(3, 3, 3, 0.404);
        }

        .garis {
            border: 3px solid rgb(20, 75, 138);
            width: 100vh;
            margin-bottom: 20px;
        }

        .garis2 {
            border: 3px solid rgba(43, 102, 170, 0.521);
            width: 511px;
        }

        .kartu {
            height: 230px;
            width: 515px;
            border-radius: 30px;
            border: 2px solid rgba(3, 3, 3, 0.404);
            margin-bottom: 20px;
        }

        .kotakfoto {
            height: 120px;
            width: 125px;
            border: 2px solid rgba(3, 3, 3, 0.404);
            margin-bottom: 20px;
        }
    </style>


</head>

<body>
    <div class="contentvisible">

    </div>
    <!-- Use Bootstrap navigation bar with fixed-top class -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">Rs Wulandari</a>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item ">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="#"
                        style="color: rgb(41, 134, 255);  font-family: Verdana, Geneva, Tahoma, sans-serif;">Pesan
                        kamar</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span id="user-avatar"><img src="" alt="User Avatar" width="30" height="30"></span>
                        <span id="user-name"></span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="ubah_profile_user.php">Profile</a>
                        <a class="dropdown-item" href="#">Settings</a>
                        <div class="dropdown-divider"></div>
                        <a id="logoutBtn" class="dropdown-item" href="">Log out</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>



    <div class="contentvisible">
        <h2 style="justify-content: center; text-align: center ; color: white;">Pesan kamar pasien</h2>
        <p style="justify-content: center; text-align: center ; color: rgb(255, 255, 255);">pesan & submit</p>
    </div>
    <div class="content">
        <div class="kotak">
            <!-- Form Example -->
            <h5> Pendaftaran</h5>
            <div class="garis"></div>
            <form action="config/pesan_kamar.php" method="POST" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="roomId">Button id kamar</label>
                        <a type="button" class="form-control" id="button">button</a>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="id_kamar">ID Kamar:</label>
                        <input type="text" name="id_kamar" class="form-control" id="id_kamar"
                            placeholder="click button ID Kamar">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="nik">NIK:</label>
                        <input type="text" name="nik" class="form-control" id="nik" placeholder="Enter NIK">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="nama">Nama:</label>
                        <input type="text" name="nama" class="form-control" id="nama" placeholder="Enter Nama">
                    </div>
                </div>
                <div class="form-group  ">
                    <label for="jenisKelamin">Jenis Kelamin: </label>
                    <div class="form-check form-check-inline  ">
                        <input class="form-check-input " type="radio" name="jenisKelamin" id="lakiLaki"
                            value="lakiLaki">
                        <label class="form-check-label" for="lakiLaki">Laki-Laki</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="jenisKelamin" id="perempuan"
                            value="perempuan">
                        <label class="form-check-label" for="perempuan">Perempuan</label>
                    </div>
                </div>
                <div class="form-group ">
                    <label for="alamat">Alamat:</label>
                    <textarea class="form-control" name="alamat" id="alamat" rows="3"
                        placeholder="Enter Alamat"></textarea>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="fotoPemesan">Foto Pemesan:</label>
                        <input type="file" name="foto" class="form-control-file" id="fotoPemesan">
                    </div>
                    <div class="form-group">
                        <label for="tanggalPesan">Tanggal Pesan:</label>
                        <input type="date" name="date" class="form-control" id="tanggalPesan">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="penjamin">Penjamin:</label>
                        <select class="form-control" id="penjamin" name="penjamin">
                            <option value="penjamin1">Penjamin 1</option>
                            <option value="penjamin2">Penjamin 2</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="metodePembayaran">Metode Pembayaran:</label>
                        <select class="form-control" id="metodePembayaran" name="metodePembayaran">
                            <option value="cash">Cash</option>
                            <option value="creditCard">Credit Card</option>
                        </select>
                    </div>
                </div>
                <div class="form-group col-md-19 text-center">
                    <button type="submit" class="btn btn-primary">Pilih Kamar</button>
                </div>

        </div>

        <div class="Pemisah ">
            <div class="kotak2">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group ">
                            <label for="info">Informasi penyakit:</label>
                            <textarea class="form-control" id="info" name="info" rows="3"
                                placeholder="Enter info"></textarea>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="email">email:</label>
                                <input type="text" class="form-control" name="email" id="email"
                                    placeholder="Enter email">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="nomer_telpon">nomer telpon:</label>
                                <input type="text" class="form-control" name="nomer_telpon" id="nomer_telpon"
                                    placeholder="Enter nomer">
                            </div>
                        </div>
                        <input type="checkbox" class="card-text" id="informasiCheckBox">
                        <label for="informasiCheckBox">setujui untuk informasi lebih lanjut.</label>

                    </div>
                </div>
            </div>
            </form>
            <div class="kotak3">
                <div class="card">
                    <div class="card-body">
                        <div class="kartu" style="justify-content: center;">
                            <div class="header" style="background-color: rgb(25, 90, 150); color: aliceblue; width: 511px; height: 70px; border-top-left-radius: 28px;
                            border-top-right-radius: 28px; display: flex;">
                                <div style="padding-top: 20px; padding-left: 40px;">ID kamar</div>
                                <div class="colum"
                                    style=" flex-direction: column; padding-top: 11px; padding-left: 45px;">
                                    <h6>Rumah sakit Wulandari</h6>
                                    <p style="font-size: 8px; padding-left: 25px;">jln bekasi selatan | bekasi barat</p>

                                </div>
                                <div style="padding-top: 10px; padding-left: 66px;"><img
                                        src="assets2/img/qr-code-scan.png" alt="" width="50px"></div>

                            </div>
                            <div class="garis2"></div>
                            <div class="main" style="padding-top: 15px; padding-left: 30px; display: flex;">
                                <div class="group">
                                    <p class="card-text"
                                        style="font-size: 12px; margin-bottom: 2px; padding-right: 90px;">Nik </p>
                                    <p class="card-text" style="font-size: 12px; margin-bottom: 2px">Nama </p>
                                    <p class="card-text" style="font-size: 12px; margin-bottom: 2px">jenis kelamin </p>
                                    <p class="card-text" style="font-size: 12px; margin-bottom: 2px">No telpon</p>
                                    <p class="card-text" style="font-size: 12px; margin-bottom: 2px">Email </p>
                                    <p class="card-text" style="font-size: 12px; margin-bottom: 2px">alamat </p>
                                </div>
                                <div class="group2">
                                    <p class="card-text"
                                        style="font-size: 12px; margin-bottom: 2px; padding-right: 4px ;"> : </p>
                                    <p class="card-text" style="font-size: 12px; margin-bottom: 2px"> : </p>
                                    <p class="card-text" style="font-size: 12px; margin-bottom: 2px"> : </p>
                                    <p class="card-text" style="font-size: 12px; margin-bottom: 2px"> : </p>
                                    <p class="card-text" style="font-size: 12px; margin-bottom: 2px"> : </p>
                                    <p class="card-text" style="font-size: 12px; margin-bottom: 2px"> : </p>
                                </div>
                                <div class="group-tampil-data">
                                    <p id="nik-display" class="card-text"
                                        style="font-size: 12px; margin-bottom: 2px;  "> </p>
                                    <p id="nama-display" class="card-text" style="font-size: 12px; margin-bottom: 2px">
                                    </p>
                                    <p id="jenisKelamin-display" class="card-text"
                                        style="font-size: 12px; margin-bottom: 2px"> </p>
                                    <p id="nomerTelpon-display" class="card-text"
                                        style="font-size: 12px; margin-bottom: 2px"> </p>
                                    <p id="email-display" class="card-text" style="font-size: 12px; margin-bottom: 2px">
                                    </p>
                                    <p id="alamat-display" class="card-text"
                                        style="font-size: 12px; margin-bottom: 2px"> </p>

                                </div>

                                <div class="kotakfoto" style="position: absolute; margin-left: 310px;">

                                </div>
                            </div>

                        </div>
                        <p class="card-text" style="font-size: 12px; margin-bottom: 2px; color: darkred;">1. Tunjukan
                            selalu kartu ketika berobat
                        </p>
                        <p class="card-text" style="font-size: 12px; margin-bottom: 2px ;color: darkred">2. Kartu tidak
                            boleh disalahgunakan
                        </p>
                        <p class="card-text" style="font-size: 12px; color: darkred">3. Apabila ada perubahan data bisa
                            konsultasi ke rs</p>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="contentvisible2">

    </div>
    <div class="footer">

        <p style="text-align: center; position: relative; padding-top: 10px;">Designed and Crafted with by
            <strong>@KElOMPOK 5</strong>
        </p>

    </div>
    <!-- Add Bootstrap JS and Popper.js scripts -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script>
        // Example JavaScript to set user name and avatar dynamically
        document.addEventListener("DOMContentLoaded", function () {
            // Assuming you have variables named 'userPhoto' and 'userName' from your database
            var userPhoto = <?php echo json_encode($foto); ?>; // Set this value dynamically from your database
            var userName = "<?php echo $username; ?>"; // Set this value dynamically from your database
            // Set this value dynamically from your database

            // Set the user's name
            document.getElementById('user-name').innerText = userName || 'user';

            // Set the user's avatar or use the default if the photo is not available
            var userAvatar = document.getElementById('user-avatar').querySelector('img');
            userAvatar.src = userPhoto ? 'config/uploads/' + userPhoto : 'assets2/img/avatar.png'; // Sesuaikan path foto dari root direktori
            userAvatar.alt = 'User Avatar';
            userAvatar.style.display = 'inline-block';
        });

        if(errorMessage !== '') {
            // Tampilkan pesan kesalahan dalam alert
            alert(errorMessage);
        }
       
    </script>
    <script>
        $(document).ready(function () {
            // Tangani klik tombol logout
            $('#logoutBtn').on('click', function () {
                // Kirim permintaan AJAX ke file PHP yang meng-handle logout
                $.ajax({
                    type: 'POST',
                    url: 'config/autentikasi/loggout.php', // Sesuaikan dengan lokasi file logout.php Anda
                    dataType: 'json',
                    success: function (response) {
                        // Tampilkan pesan logout berhasil
                        alert(response.message);

                        // Redirect ke halaman login atau halaman lain setelah logout
                        window.location.href = 'login.php'; // Sesuaikan dengan halaman tujuan setelah logout
                    },
                    error: function (xhr, status, error) {
                        console.error('Error during logout request:', error);
                    }
                });
            });
        });
    </script>
</body>

</html>