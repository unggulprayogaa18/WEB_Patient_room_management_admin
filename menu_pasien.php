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
        $row = $stmt->fetch(PDO::FETCH_ASSOC); // Tambahkan parameter FETCH_ASSOC

        if ($row) {
            $data_user = array(
                'username' => $row['username'],
                'email' => $row['email'],
                'no_telpon' => $row['no_telpon'],
                'foto' => $row['foto'],
                'nama' => $row['nama']
            );
        } else {
            $response = array('status' => 'error', 'message' => 'No user found');
        }
    } catch (PDOException $e) {
        $response = array('status' => 'error', 'message' => 'Error in query: ' . $e->getMessage());
    }

    // Sekarang, Anda dapat menggunakan nilai $username sesuai kebutuhan
} else {
    // Jika tidak ada sesi username, mungkin pengguna belum login, arahkan ke halaman login
    header("Location: login.php");
    exit(); // Pastikan untuk keluar agar kode di bawah tidak dijalankan
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Menu kamar</title>
    <script src="https://raw.githack.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>

    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/hero-bg.jpg" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets2/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets2/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets2/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets2/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets2/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets2/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets2/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets2/css/style.css" rel="stylesheet">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        input[type="text"] {
            padding: 6px;
            width: 200px;
            margin-bottom: 10px;
        }

        input[type="number"] {
            padding: 6px;
            width: 80px;
            margin-left: 10px;
            margin-bottom: 10px;
        }
    </style>

</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="index.php" class="logo d-flex align-items-center">
                <!-- <img src="assets2/img/logo.png" alt=""> -->
                <span class="d-none d-lg-block">RS Primayoga</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        <div class="search-bar">
            <form class="search-form d-flex align-items-center" method="POST" action="#">
                <input type="text" name="query" placeholder="Search" title="Enter search keyword">
                <button type="submit" title="Search"><i class="bi bi-search"></i></button>
            </form>
        </div><!-- End Search Bar -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <li class="nav-item d-block d-lg-none">
                    <a class="nav-link nav-icon search-bar-toggle " href="#">
                        <i class="bi bi-search"></i>
                    </a>
                </li><!-- End Search Icon-->

                <li class="nav-item dropdown">

                    <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-bell"></i>
                        <span class="badge bg-primary badge-number">4</span>
                    </a><!-- End Notification Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                        <li class="dropdown-header">
                            You have 4 new notifications
                            <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="notification-item">
                            <i class="bi bi-exclamation-circle text-warning"></i>
                            <div>
                                <h4>Lorem Ipsum</h4>
                                <p>Quae dolorem earum veritatis oditseno</p>
                                <p>30 min. ago</p>
                            </div>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="notification-item">
                            <i class="bi bi-x-circle text-danger"></i>
                            <div>
                                <h4>Atque rerum nesciunt</h4>
                                <p>Quae dolorem earum veritatis oditseno</p>
                                <p>1 hr. ago</p>
                            </div>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="notification-item">
                            <i class="bi bi-check-circle text-success"></i>
                            <div>
                                <h4>Sit rerum fuga</h4>
                                <p>Quae dolorem earum veritatis oditseno</p>
                                <p>2 hrs. ago</p>
                            </div>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="notification-item">
                            <i class="bi bi-info-circle text-primary"></i>
                            <div>
                                <h4>Dicta reprehenderit</h4>
                                <p>Quae dolorem earum veritatis oditseno</p>
                                <p>4 hrs. ago</p>
                            </div>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li class="dropdown-footer">
                            <a href="#">Show all notifications</a>
                        </li>

                    </ul><!-- End Notification Dropdown Items -->

                </li><!-- End Notification Nav -->

                <li class="nav-item dropdown">

                    <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-chat-left-text"></i>
                        <span class="badge bg-success badge-number">3</span>
                    </a><!-- End Messages Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
                        <li class="dropdown-header">
                            You have 3 new messages
                            <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>



                        <li class="dropdown-footer">
                            <a href="#">Show all messages</a>
                        </li>

                    </ul><!-- End Messages Dropdown Items -->

                </li><!-- End Messages Nav -->

                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <img src="config/uploads/<?php echo $foto; ?>" alt="Profile" width="40" height="40"  class="rounded-circle">
                        <span class="d-none d-md-block dropdown-toggle ps-2">
                            <?php echo $username; ?>
                        </span>
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6>
                                <?php echo $data_user['nama']; ?>
                            </h6>
                            <span>Web Designer</span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="ubah_profile_admin.php">
                                <i class="bi bi-person"></i>
                                <span>Edit Profile</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <i class="bi bi-gear"></i>
                                <span>Account Settings</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <i class="bi bi-question-circle"></i>
                                <span>Need Help?</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="config/autentikasi/loggout.php">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sign Out</span>
                            </a>
                        </li>

                    </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->

            </ul>
        </nav><!-- End Icons Navigation -->

    </header><!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">


            <li class="nav-item">
                <a class="nav-link collapsed" href="beranda.php">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li><!-- End Dashboard Nav -->


            <li class="nav-item">
                <a class="nav-link " data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-layout-text-window-reverse"></i><span>Menu</span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="tables-nav" class="nav-content collapse show" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="#" class="active">
                            <i class="bi bi-circle"></i><span>Menu pasien</span>
                        </a>
                    </li>
                    <li>
                        <a href="menu_kamar.php">
                            <i class="bi bi-circle "></i><span>Menu kamar</span>
                        </a>
                    </li>
                    <li>
                        <a href="menu_user.php">
                            <i class="bi bi-circle "></i><span>Menu user</span>
                        </a>
                    </li>
                </ul>
            </li>




        </ul>

    </aside><!-- End Sidebar-->

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Menu Pasien</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Menu</li>
                    <li class="breadcrumb-item">Pasien</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <p>Perihal data rumah sakit <a href="https://www.chartjs.org/docs/latest/samples/" target="_blank">official
                website</a> for more examples.</p>

        <section class="section">
            <div class="row">

                <div class="col-lg-h-100">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Table</h5>

                            <div class="row align-items-center">
                                <!-- Search Input -->
                                <div class="col-md-4 mb-3">
                                    <input type="text" id="searchInput" class="form-control"
                                        placeholder="Search by name" oninput="searchTable()">
                                </div>

                                <!-- Show Data Input -->
                                <div class="col-md-4 mb-3" style="display: flex;">
                                    <label for="showDataInput" class="form-label" style="padding-top:7px;">Show
                                        Data:</label>
                                    <input type="number" id="showDataInput" class="form-control"
                                        placeholder="Number of rows" oninput="showRows()">
                                </div>

                                <!-- Export to PDF Button -->
                                <div class="col-md-4 mb-3">
                                    <button id="exportBtn" class="btn btn-primary" style="width: 100%;">Export to
                                        PDF</button>
                                </div>
                            </div>
                            <!-- Line Chart -->
                            <table id="patientTable" class="table-responsive overflow-auto">
                                <table class="table table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <th scope="col">ID Pasien</th>
                                            <th scope="col">Nama Pasien</th>
                                            <th scope="col">Jenis Kelamin</th>
                                            <th scope="col">Ciri-ciri</th>
                                            <th scope="col">Status Pasien</th>
                                            <th scope="col">ID Kamar</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabelfordashboard" style="font-family: 'Space Mono', monospace;">
                                    </tbody>
                                </table>
                        </div>
                        <div class="pagination-container card-footer">
                            <ul class="pagination justify-content-center" id="pagination"></ul>
                        </div>

                    </div>
                </div>
            </div>


            <div class="col-lg-h-100">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Form input</h5>
                        <div class="container mt-5">
                            <div class="column-gap-1">
                                <div class="col-md-8 offset-md-2">
                                    <h2 class="text-center mb-4" style="font-family: 'Space Mono', monospace;">
                                        Pendaftaran Pasien</h2>
                                    <form id="pasienForm">
                                        <div class="form-row">
                                            <div class="mb-3">
                                                <label for="nama" class="form-label">Nama Pasien:</label>
                                                <input type="text" class="form-control" id="nama" name="nama" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="id_kamar" class="form-label">ID Kamar:</label>
                                                <input type="text" class="form-control" id="id_kamar" name="id_kamar"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin:</label>
                                            <select class="form-select" id="jenis_kelamin" name="jenis_kelamin"
                                                required>
                                                <option value="Laki-laki">Laki-laki</option>
                                                <option value="Perempuan">Perempuan</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="ciri_ciri" class="form-label">Ciri-ciri:</label>
                                            <textarea class="form-control" id="ciri_ciri" name="ciri_ciri"></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="status_pasien" class="form-label">Status Pasien:</label>
                                            <select class="form-select" id="status_pasien" name="status_pasien"
                                                required>
                                                <option value="Ditangani">Ditangani</option>
                                                <option value="Menunggu">Menunggu</option>
                                            </select>
                                        </div>

                                        <div class="d-flex justify-content-end">
                                            <button type="button" class="btn btn-info"
                                                onclick="statusdata('simpan' , 'kosong')" id="editsave"
                                                style="margin-right: 10px; font-family: 'Space Mono', monospace; display:none;">Simpan/Edit</button>

                                            <button type="button" class="btn btn-primary" onclick="submitForm()"
                                                id="daftarkan"
                                                style="margin-right: 10px; font-family: 'Space Mono', monospace;">Daftar</button>
                                            <button type="button" class="btn btn-danger" onclick="batalin()"
                                                id="batalkan"
                                                style="font-family: 'Space Mono', monospace;">Batal</button>
                                        </div>
                                    </form>
                                </div>

                                <!-- End Line Chart -->
                            </div>
                        </div>
                    </div>



        </section>

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>kelompok 5</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
            Designed by <a href="">kelompok 5</a>
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="js/ajax-script.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twbs-pagination/1.4.2/jquery.twbsPagination.min.js"></script>


    <!-- Vendor JS Files -->
    <script src="assets2/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>


    <!-- Template Main JS File -->
    <script src="assets2/js/main.js"></script>
    <script>
        // Initialize variables
        document.getElementById('exportBtn').addEventListener('click', exportToPDF);

        function exportToPDF() {
            // Make an AJAX request to get the data from your PHP script
            $.ajax({
                type: 'GET',
                url: 'config/pasien/get_data.php',
                dataType: 'json', // Expect JSON response
                success: function (response) {
                    if (response.status === 'success') {
                        // Call the function to generate PDF with the retrieved data
                        generatePDF(response.data_pasien);
                    } else {
                        console.error('Error:', response.message);
                    }
                },
                error: function (error) {
                    console.error('AJAX Error:', error);
                }
            });
        }

        function generatePDF(dataPasien) {
            // Create an HTML table using the dataPasien
            var tableHtml = '<table id="patientTable">';
            tableHtml += '<thead><tr><th>ID</th><th>Nama</th><th>Jenis Kelamin</th><th>Ciri-Ciri</th><th>Status Pasien</th><th>ID Kamar</th></tr></thead>';
            tableHtml += '<tbody>';

            // Iterate over the dataPasien array and populate the table rows
            for (var i = 0; i < dataPasien.length; i++) {
                var pasien = dataPasien[i];
                tableHtml += '<tr>' +
                    '<td>' + pasien.idpasien + '</td>' +
                    '<td>' + pasien.nama + '</td>' +
                    '<td>' + pasien.jenis_kelamin + '</td>' +
                    '<td>' + pasien.ciri_ciri + '</td>' +
                    '<td>' + pasien.status_pasien + '</td>' +
                    '<td>' + pasien.id_kamar + '</td>' +
                    '</tr>';
            }

            tableHtml += '</tbody></table>';

            // Convert the HTML table to a PDF
            var element = document.createElement('div');
            element.innerHTML = tableHtml;

            var opt = {
                margin: 0,
                filename: 'data_pasien.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
            };

            // Use the dynamically created element for PDF generation
            html2pdf(element, opt);
        }

        function searchTable() {


            // Declare variables
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("patientTable");
            tr = table.getElementsByTagName("tr");

            // Loop through all table rows, and hide those that don't match the search query
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1]; // Index 1 corresponds to the Nama Pasien column
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
            // Update pagination controls
        }

        function showRows() {
            var input, table, tr, i;
            input = document.getElementById("showDataInput");
            table = document.getElementById("patientTable");
            tr = table.getElementsByTagName("tr");

            // Check if the input value is empty
            if (input.value === "") {
                // If empty, display all rows
                for (i = 1; i < tr.length; i++) {
                    tr[i].style.display = "";
                }
            } else {
                var inputValue = parseInt(input.value);

                // Check if input value is within the range of available rows
                if (inputValue >= 1 && inputValue <= tr.length - 1) {
                    // If within range, show/hide based on the user input
                    for (i = 1; i < tr.length; i++) {
                        if (i <= inputValue) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                } else {
                    // If input value exceeds the available rows, show an alert
                    alert("Data hanya memiliki " + (tr.length - 1) + " baris. Silakan masukkan nilai yang sesuai.");
                }
            }
            // Update pagination controls
        }

    </script>
</body>

</html>