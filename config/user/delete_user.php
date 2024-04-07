<?php
header('Content-Type: application/json');
include '../koneksi.php';

try {
    // Buat koneksi PDO

    // Set error mode ke exception
    $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Mendapatkan data dari formulir
    $username = $_POST['username'];

    // Persiapkan statement SQL untuk menghapus data dari database
    $stmt = $koneksi->prepare("DELETE FROM users WHERE username = ?");

    // Bind parameter ke statement
    $stmt->bindParam(1, $username);

    // Eksekusi statement
    if ($stmt->execute()) {
        $response = array('status' => 'success', 'message' => 'Data berhasil dihapus');
    } else {
        $response = array('status' => 'error', 'message' => 'Gagal menghapus data: ' . $stmt->errorInfo()[2]);
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
