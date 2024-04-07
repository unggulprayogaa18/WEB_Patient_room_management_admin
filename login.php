<?php
session_start(); // Mulai session jika belum dimulai

// Periksa apakah ada pesan kesalahan dalam session
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
    <title>LOGIN </title>
    <link href="assets/img/hero-bg.jpg" rel="icon">

    <link rel="stylesheet" href="bootstrap-5.3.2-dist/css/bootstrap.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #ecf0f3;
        }

        .wrapper {
            color: rgb(17, 12, 12);
            max-width: 350px;
            min-height: 500px;
            margin: 80px auto;
            padding: 40px 30px 30px 30px;
            background: linear-gradient(rgba(37, 39, 39, 0.7), rgba(56, 58, 59, 0.39)), url('assets2/img/hero-bg.jpg');
            border-radius: 15px;
            box-shadow: 13px 13px 20px #cbced1, -13px -13px 20px #fff;
        }

        .logo {
            width: 80px;
            margin: auto;
        }

        .logo img {
            width: 100%;
            height: 80px;
            object-fit: cover;
            border-radius: 50%;

        }

        .wrapper .name {
            font-weight: 600;
            font-size: 1.4rem;
            letter-spacing: 1.3px;
            padding-left: 10px;
            color: white;

        }

        .wrapper .form-field input {
            width: 100%;
            display: block;
            border: none;
            outline: none;
            background: none;
            font-size: 1.2rem;
            color: rgb(2, 1, 1);

            padding: 10px 15px 10px 10px;
        }

        .wrapper .form-field {
            padding-left: 10px;
            margin-bottom: 20px;
            border-radius: 20px;
            background-color: white;
            box-shadow: inset 8px 8px 8px #c3d2e0, inset -8px -8px 8px #fff;
        }

        .wrapper .form-field .fas {
            color: rgb(3, 2, 2);
        }

        .wrapper .btn {
            box-shadow: none;
            width: 100%;
            height: 40px;
            background-color: rgba(47, 52, 58, 0.959);
            color: #fff;
            border-radius: 25px;

            letter-spacing: 1.3px;
        }


        .wrapper .btn:hover {
            background-color: #39667c;
        }

        .wrapper a {
            text-decoration: none;
            color: white;
        }



        @media(max-width: 380px) {
            .wrapper {
                margin: 30px 20px;
                padding: 40px 15px 15px 15px;
            }
        }

        .gmabar {
            margin-top: -70px;
            margin-left: 10px;
            position: fixed;
            height: 40px;
        }

        .kembali {
            display: inline-block;
            width: 100%;
            height: 40px;
            line-height: 40px;
            background-color: rgba(47, 52, 58, 0.959);
            text-align: center;
            text-decoration: none;
            border-radius: 25px;
            margin-top: 14px;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
        }

        .wrapper .kembali:hover {
            background-color: #39667c;
        }
    </style>
</head>

<body>
    <div class="wrapper">


        <div class="logo">
            <img src="assets/img/medical-symbol.png" alt="">
        </div>
        <div class="text-center mt-4 name">
            Login Admin
        </div>
        <form class="p-3 mt-3" action="config/autentikasi/login_proses.php" method="POST">
            <div class="form-field d-flex align-items-center">
                <span class="far fa-user"></span>
                <input type="text" name="username" id="username" placeholder="Username">
            </div>
            <div class="form-field d-flex align-items-center">
                <span class="fas fa-key"></span>
                <input type="password" name="password" id="password" placeholder="Password">
            </div>
            <button class="btn btn-btn" type="submit">Login</button>
            <a href="home.php" class="kembali" style="margin-top: 14px;">kembali</a>
        </form>
        <div class="text-center fs-6">
        </div>
    </div>
    <script>
        // Periksa apakah ada pesan kesalahan yang tersimpan
        if(errorMessage !== '') {
            // Tampilkan pesan kesalahan dalam alert
            alert(errorMessage);
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- <script src="js/ajax-script.js"></script> -->

</body>

</html>