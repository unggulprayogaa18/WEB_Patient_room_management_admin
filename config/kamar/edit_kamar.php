<?php
header('Content-Type: application/json');
include '../koneksi.php';

try {
    $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_kamar = $_POST['id_kamar'];
        $nomer_kamar = $_POST['nomer_kamar'];
        $status_kamar = $_POST['status_kamar'];

        $stmt = $koneksi->prepare("UPDATE table_kamar SET status_kamar = :status_kamar, nomer_kamar = :nomer_kamar WHERE id_kamar = :id_kamar");
        $stmt->bindParam(':id_kamar', $id_kamar, PDO::PARAM_INT);
        $stmt->bindParam(':nomer_kamar', $nomer_kamar, PDO::PARAM_STR);
        $stmt->bindParam(':status_kamar', $status_kamar, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $response = array('status' => 'success', 'message' => 'Perubahan berhasil disimpan.');
        } else {
            $response = array('status' => 'error', 'message' => 'Gagal menyimpan perubahan');
        }
    } else {
        $response = array('status' => 'error', 'message' => 'Metode request tidak valid');
    }
} catch (PDOException $e) {
    $response = array('status' => 'error', 'message' => 'Koneksi Gagal: ' . $e->getMessage());
}

echo json_encode($response);
?>
