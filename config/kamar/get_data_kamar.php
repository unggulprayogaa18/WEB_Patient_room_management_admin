<?php
header('Content-Type: application/json');
include '../koneksi.php';

try {
    $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $koneksi->query("SELECT * FROM table_kamar");
    $data_kamar = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($data_kamar) {
        $response = array('status' => 'success', 'data_kamar' => $data_kamar);
    } else {
        $response = array('status' => 'error', 'message' => 'Gagal mengambil data');
    }
} catch (PDOException $e) {
    $response = array('status' => 'error', 'message' => 'Koneksi Gagal: ' . $e->getMessage());
}

echo json_encode($response);
?>
