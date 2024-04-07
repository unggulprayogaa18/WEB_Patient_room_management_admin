<?php
header('Content-Type: application/json');
include '../koneksi.php';

try {
    // Buat koneksi PDO

    // Set error mode ke exception
    $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $idpasien = $_POST['idpasien'];

        // Persiapkan statement SQL untuk mengambil data pasien berdasarkan ID
        $stmt = $koneksi->prepare("SELECT * FROM pasien WHERE idpasien = ?");
        $stmt->bindParam(1, $idpasien);

        // Eksekusi statement
        if ($stmt->execute()) {
            $data_pasien = $stmt->fetch(PDO::FETCH_ASSOC);
            $response = array('status' => 'success', 'data_pasien' => $data_pasien);
        } else {
            $response = array('status' => 'error', 'message' => 'Gagal mengambil data: ' . $stmt->errorInfo()[2]);
        }
    } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $idpasien = $_GET['idpasien'];
        $nama = $_GET['nama'];
        $jenis_kelamin = $_GET['jenis_kelamin'];
        $ciri_ciri = $_GET['ciri_ciri'];
        $status_pasien = $_GET['status_pasien'];
        $id_kamar = $_GET['id_kamar'];

        // Persiapkan statement SQL untuk memperbarui data pasien
        $stmt = $koneksi->prepare("UPDATE pasien SET 
        nama = ?,
        jenis_kelamin = ?,
        ciri_ciri = ?,
        status_pasien = ?,
        id_kamar = ?
        WHERE idpasien = ?");
        $stmt->bindParam(1, $nama);
        $stmt->bindParam(2, $jenis_kelamin);
        $stmt->bindParam(3, $ciri_ciri);
        $stmt->bindParam(4, $status_pasien);
        $stmt->bindParam(5, $id_kamar);
        $stmt->bindParam(6, $idpasien);

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
