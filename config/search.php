<?php
header('Content-Type: application/json');

include 'config/koneksi.php';


// Ambil keyword dari parameter GET
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

// Siapkan query
$query = "SELECT * FROM pasien WHERE 
          nama LIKE :keyword OR
          jenis_kelamin LIKE :keyword OR
          ciri_ciri LIKE :keyword OR
          status_pasien LIKE :keyword OR
          id_kamar LIKE :keyword";

try {
    // Siapkan statement
    $stmt = $koneksi->prepare($query);

    // Bind parameter
    $keywordParam = "%$keyword%";
    $stmt->bindParam(':keyword', $keywordParam, PDO::PARAM_STR);

    // Eksekusi statement
    $stmt->execute();

    // Ambil hasil
    $data_pasien = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Buat response
    $response = array('status' => 'success', 'data_pasien' => $data_pasien);
} catch (PDOException $e) {
    $response = array('status' => 'error', 'message' => 'Gagal melakukan pencarian: ' . $e->getMessage());
}

// Tutup koneksi
$koneksi = null;

// Keluarkan response dalam format JSON
echo json_encode($response);
?>
