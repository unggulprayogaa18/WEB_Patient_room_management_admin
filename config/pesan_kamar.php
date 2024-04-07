<?php
header('Content-Type: application/json');

include 'koneksi.php';

try {
    // Buat koneksi PDO

    // Set error mode ke exception
    $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Mendapatkan data dari formulir
    $id_kamar = $_POST['id_kamar'];
    $nik = $_POST['nik'];
    $nama = $_POST['nama'];
    $jenisKelamin = $_POST['jenisKelamin'];
    $alamat = $_POST['alamat'];
    $date = $_POST['date'];
    $penjamin = $_POST['penjamin'];
    $metodePembayaran = $_POST['metodePembayaran'];

    // Informasi penyakit
    $info = $_POST['info'];

    // Kontak
    $email = $_POST['email'];
    $nomer_telpon = $_POST['nomer_telpon'];

    // Foto
    $foto = ''; // Nama file foto yang akan disimpan di database

    // Memeriksa apakah elemen file sudah diunggah
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $foto = $_FILES['foto']['name'];
    } else {
        $response = array('status' => 'error', 'message' => 'Gagal mengunggah foto');
        echo json_encode($response);
        exit;
    }

    // Simpan foto di folder uploads
    $uploadsDirectory = 'uploads/'; // Sesuaikan dengan folder Anda
    $targetFile = $uploadsDirectory . basename($_FILES['foto']['name']);

    if (move_uploaded_file($_FILES['foto']['tmp_name'], $targetFile)) {
        $foto = $_FILES['foto']['name'];
    } else {
        $response = array('status' => 'error', 'message' => 'Gagal mengunggah foto');
        echo json_encode($response);
        exit;
    }

    // Persiapkan statement SQL untuk menyimpan data ke database
    $stmt = $koneksi->prepare("INSERT INTO pesan_kamar (id_kamar, nik, nama, jenis_kelamin, alamat, date, penjamin, metode_pembayaran, info, email, nomer_telpon, foto) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Bind parameter ke statement
    $stmt->bindParam(1, $id_kamar);
    $stmt->bindParam(2, $nik);
    $stmt->bindParam(3, $nama);
    $stmt->bindParam(4, $jenisKelamin);
    $stmt->bindParam(5, $alamat);
    $stmt->bindParam(6, $date);
    $stmt->bindParam(7, $penjamin);
    $stmt->bindParam(8, $metodePembayaran);
    $stmt->bindParam(9, $info);
    $stmt->bindParam(10, $email);
    $stmt->bindParam(11, $nomer_telpon);
    $stmt->bindParam(12, $foto);

    // Proses data atau simpan ke database
    if ($stmt->execute()) {
        $response = array('status' => 'success', 'message' => 'Data berhasil disimpan');
    } else {
        $response = array('status' => 'error', 'message' => 'Gagal menyimpan data: ' . $stmt->errorInfo()[2]);
    }

    // Tutup statement
    $stmt = null;
} catch (PDOException $e) {
    $response = array('status' => 'error', 'message' => 'Koneksi Gagal: ' . $e->getMessage());
}

// Tutup koneksi
$koneksi = null;

// Mengembalikan response dalam format JSON
echo json_encode($response);
?>
