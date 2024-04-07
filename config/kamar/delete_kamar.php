<?php
header('Content-Type: application/json');
include '../koneksi.php';

try {
    $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_kamar = $_POST['id_kamar'];

        $stmt = $koneksi->prepare("DELETE FROM table_kamar WHERE id_kamar = :id_kamar");
        $stmt->bindParam(':id_kamar', $id_kamar, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $response = array('status' => 'success', 'message' => 'Data berhasil dihapus');
        } else {
            $response = array('status' => 'error', 'message' => 'Gagal menghapus data');
        }
    } else {
        $response = array('status' => 'error', 'message' => 'Metode request tidak valid');
    }
} catch (PDOException $e) {
    $response = array('status' => 'error', 'message' => 'Koneksi Gagal: ' . $e->getMessage());
}

echo json_encode($response);
?>
