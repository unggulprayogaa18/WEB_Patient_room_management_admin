<?php
header('Content-Type: application/json');
include '../koneksi.php';

try {
    // Buat koneksi PDO

    // Set error mode ke exception
    $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Persiapkan statement SQL untuk mengambil data dari database
    $stmt = $koneksi->query("SELECT * FROM users");

    // Eksekusi statement
    if ($stmt) {
        $data_user = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $response = array('status' => 'success', 'data_user' => $data_user);
    } else {
        $response = array('status' => 'error', 'message' => 'Gagal mengambil data: ' . $koneksi->errorInfo()[2]);
    }
} catch (PDOException $e) {
    $response = array('status' => 'error', 'message' => 'Koneksi Gagal: ' . $e->getMessage());
}

// Tutup koneksi
$koneksi = null;

echo json_encode($response);
?>
