<?php
header('Content-Type: application/json');
include '../koneksi.php';

try {
    // Buat koneksi PDO

    // Set error mode ke exception
    $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Mendapatkan data dari formulir
    $id_kamar = $_POST['id_kamar'];
    $nomer_kamar = $_POST['nomer_kamar'];
    $status_kamar = $_POST['status_kamar'];

    // Persiapkan statement SQL untuk menyimpan data ke database
    $stmt = $koneksi->prepare("INSERT INTO table_kamar (id_kamar, nomer_kamar, status_kamar) VALUES (?, ?, ?)");

    // Bind parameter ke statement
    $stmt->bindParam(1, $id_kamar, PDO::PARAM_INT);
    $stmt->bindParam(2, $nomer_kamar, PDO::PARAM_STR);
    $stmt->bindParam(3, $status_kamar, PDO::PARAM_STR);

    // Proses data atau simpan ke databasez
    if ($stmt->execute()) {
        $response = array('status' => 'success', 'message' => 'Data Kamar berhasil disimpan');
    } else {
        $response = array('status' => 'error', 'message' => 'Gagal menyimpan data: ' . $stmt->errorInfo()[2]);
    }
} catch (PDOException $e) {
    $response = array('status' => 'error', 'message' => 'Koneksi Gagal: ' . $e->getMessage());
}

// Tutup koneksi
$koneksi = null;

echo json_encode($response);
?>
