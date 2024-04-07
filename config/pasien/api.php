<?php
header('Content-Type: application/json');
include '../koneksi.php';

try {
    // Buat koneksi PDO

    // Set error mode ke exception
    $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Mendapatkan data dari formulir
    $nama = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $ciri_ciri = $_POST['ciri_ciri'];
    $status_pasien = $_POST['status_pasien'];
    $id_kamar = $_POST['id_kamar'];

    // Persiapkan statement SQL untuk menyimpan data ke database
    $stmt = $koneksi->prepare("INSERT INTO pasien (nama, jenis_kelamin, ciri_ciri, status_pasien, id_kamar) VALUES (?, ?, ?, ?, ?)");
    
    // Bind parameter ke statement
    $stmt->bindParam(1, $nama);
    $stmt->bindParam(2, $jenis_kelamin);
    $stmt->bindParam(3, $ciri_ciri);
    $stmt->bindParam(4, $status_pasien);
    $stmt->bindParam(5, $id_kamar);

    // Proses data atau simpan ke database
    if ($stmt->execute()) {
        $response = array('status' => 'success', 'message' => 'Data Pasien berhasil disimpan');
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

echo json_encode($response);
?>
