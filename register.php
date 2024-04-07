<!DOCTYPE html>
<html>

<head>
    <title>Registration</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Set tinggi kotak di sebelah kanan */

        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

        * {
            margin: 0;
            padding: 0;
            font-family: "Poppins", sans-serif;
        }

        .right-box {
            min-height: 200px;
        }

        /* Memberi margin bawah pada formulir */
        .form-container {
            margin-bottom: 20px;
        }

        .container {
            margin-top: 20px;
            padding: 80px;
            width: 800px;
            height: 700px;
        }

        /* Membuat background setengah gambar setengah warna abu-abu */
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            background-size: 100% 300px;
            /* Ganti nilai 300px sesuai kebutuhan tinggi gambar Anda */
            background: #ecf0f3;
            background-position: center top;
            display: flex;
            flex-direction: column;
            align-items: center;
            background-repeat: no-repeat;
        }

        /* Memberikan warna latar belakang pada navbar */
        .navbar {
            background-color: rgba(255, 255, 255, 0.103);
            /* Warna latar belakang navbar dengan transparansi */
            box-shadow: 5px 5px 10px rgba(128, 128, 128, 0.747);
            border: 2px solid rgb(53, 86, 105);
            /* Ubah lebar border menjadi 2px */
        }

        .navbar,
        h6 {
            padding-right: 130px;
        }

        .kotaksyarat {
            padding: 10px;
            width: 450px;
            background: #ecf0f3;
            border: 2px solid rgb(53, 86, 105);
            box-shadow: 5px 5px 10px rgba(128, 128, 128, 0.747)
        }

        .box {
            display: flex;
        }

        .kotak {
            color: white;
            margin-right: 10px;
            box-shadow: 5px 5px 10px rgba(128, 128, 128, 0.747)
                /* Horizontal offset, Vertical offset, Blur radius, Color */
        }
       .kotaksyarat, .syarat ,p{
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            font-size: 13px;
        }
    </style>
</head>

<body>
    <div class="container">

        <nav class="navbar navbar-light bg-light mb-2  rounded">
            <a class="navbar-brand" href="home.php" style="color:rgb(60, 66, 68); font-size: 13px;">
                Kembali</a>
            <h6 style="padding-top: 6px;">Pendaftaran</h6>
        </nav>

        <div class="box">
            <div class="kotak">
                <div class="border rounded p-5"
                    style="background: linear-gradient(rgba(26, 27, 27, 0.7), rgba(56, 58, 59, 0.39)), url('assets2/img/hero-bg.jpg');">
                    <form action="config/register_proses.php" method="POST">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="password">Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="password" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text password-toggle-btn"
                                            onclick="togglePassword('password')">
                                            <i class="far fa-eye-slash" id="password-toggle-icon"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="konfirmasi_password">Konfirmasi Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="konfirmasi_password"
                                    name="konfirmasi_password" required>
                                <div class="input-group-append">
                                    <span class="input-group-text password-toggle-btn"
                                        onclick="togglePassword('konfirmasi_password')">
                                        <i class="far fa-eye-slash" id="konfirmasi-password-toggle-icon"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="text" class="form-control" id="phone" name="phone">
                        </div>
                        <button type="submit" class="btn btn-dark "
                            style="border-radius: 40px; margin-left: 30px; width: 200px; margin-top: 20px;">Submit</button>
                    </form>
                </div>
            </div>

            <div class="kotaksyarat  rounded">
                <div class="syarat">
                    <h4 style="text-align: center;">Syarat</h4>
                    <p>1.Password harus terdiri dari minimal 8 karakter </p>
                    <p>2.Gunakan kombinasi huruf (besar dan kecil) dan angka untuk keamanan tambahan </p>
                    <p>3.Pastikan untuk mengonfirmasi ulang password yang dimasukkan untuk menghindari kesalahan </p>
                    <p>4.Masukkan alamat email yang valid untuk menerima informasi dan verifikasi akun </p>
                    <p>5.Jika diinginkan, masukkan nomor telepon yang valid untuk dapat dihubungi </p>
                    <p>6.pastikan semua informasi akun yang dimasukkan lengkap dan akurat. </p>
                </div>

            </div>
        </div>
    </div>
    <script>
        // Check if there's a notification in the URL
        const urlParams = new URLSearchParams(window.location.search);
        const notification = urlParams.get('notif');

        // Display notification if present
        if (notification) {
            alert(notification);
        }
    </script>
    <script>
        function togglePassword(inputId) {
            var passwordInput = document.getElementById(inputId);
            var passwordToggleIcon = document.getElementById(inputId + '-toggle-icon');

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                passwordToggleIcon.classList.remove('fa-eye-slash');
                passwordToggleIcon.classList.add('fa-eye');
            } else {
                passwordInput.type = "password";
                passwordToggleIcon.classList.remove('fa-eye');
                passwordToggleIcon.classList.add('fa-eye-slash');
            }
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>