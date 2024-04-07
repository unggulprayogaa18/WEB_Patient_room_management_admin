<?php
header('Content-Type: application/json');
include '../koneksi.php';

try {
    // Buat koneksi PDO

    // Set error mode ke exception
    $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Mendapatkan data dari formulir
    $username = $_POST['username'];
    $password = $_POST['password'];
    $status_user = $_POST['status_user'];

    // Persiapkan statement SQL untuk menyimpan data ke database
    $stmt = $koneksi->prepare("INSERT INTO users (username, password, status_user) VALUES (?, ?, ?)");

    // Bind parameter ke statement
    $stmt->bindParam(1, $username);
    $stmt->bindParam(2, $password);
    $stmt->bindParam(3, $status_user);

    // Proses data atau simpan ke database
    if ($stmt->execute()) {
        $response = array('status' => 'success', 'message' => 'Data user berhasil disimpan');
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
