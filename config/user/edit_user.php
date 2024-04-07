<?php
header('Content-Type: application/json');
include '../koneksi.php';

try {
    // Buat koneksi PDO

    // Set error mode ke exception
    $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];

        // Persiapkan statement SQL untuk mengambil data dari database
        $stmt = $koneksi->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bindParam(1, $username);

        // Eksekusi statement
        if ($stmt->execute()) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                $data_user = array(
                    'username' => $row['username'],
                    'password' => $row['password'],
                    'status_user' => $row['status_user']
                );

                $response = array('status' => 'success', 'data_user' => $data_user);
            } else {
                $response = array('status' => 'error', 'message' => 'Data tidak ditemukan');
            }
        } else {
            $response = array('status' => 'error', 'message' => 'Gagal mengambil data: ' . $stmt->errorInfo()[2]);
        }
    } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $username = $_GET['username'];
        $password = $_GET['password'];
        $status_user = $_GET['status_user'];

        // Persiapkan statement SQL untuk menyimpan perubahan ke database
        $stmt = $koneksi->prepare("UPDATE users SET status_user = ?, password = ? WHERE username = ?");
        $stmt->bindParam(1, $status_user);
        $stmt->bindParam(2, $password);
        $stmt->bindParam(3, $username);

        // Eksekusi statement
        if ($stmt->execute()) {
            $response = array('status' => 'success', 'message' => 'Perubahan berhasil disimpan.');
        } else {
            $response = array('status' => 'error', 'message' => 'Gagal menyimpan perubahan: ' . $stmt->errorInfo()[2]);
        }
    }
} catch (PDOException $e) {
    $response = array('status' => 'error', 'message' => 'Koneksi Gagal: ' . $e->getMessage());
}

// Tutup koneksi
$koneksi = null;

echo json_encode($response);
?>
