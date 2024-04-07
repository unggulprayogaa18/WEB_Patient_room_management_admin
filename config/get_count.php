<?php
header('Content-Type: application/json');

include 'config/koneksi.php';

try {
    // Buat koneksi menggunakan PDO
    $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Query untuk menghitung jumlah pasien yang sedang menunggu
    $stmtWaiting = $koneksi->prepare("SELECT COUNT(*) as waiting_count FROM pasien WHERE status_pasien = 'menunggu'");
    $stmtWaiting->execute();
    $waitingCount = $stmtWaiting->fetch(PDO::FETCH_ASSOC)['waiting_count'];

    // Query untuk menghitung jumlah pasien yang sudah ditangani
    $stmtHandled = $koneksi->prepare("SELECT COUNT(*) as handled_count FROM pasien WHERE status_pasien = 'ditangani'");
    $stmtHandled->execute();
    $handledCount = $stmtHandled->fetch(PDO::FETCH_ASSOC)['handled_count'];

    // Tutup koneksi PDO
    $koneksi = null;

    // Buat respons dalam format JSON
    $response = [
        'status' => 'success',
        'message' => 'Data berhasil diambil',
        'waiting_count' => $waitingCount,
        'handled_count' => $handledCount,
    ];

} catch (PDOException $e) {
    // Tangani pengecualian jika terjadi error pada PDO
    $response = [
        'status' => 'error',
        'message' => 'Error: ' . $e->getMessage(),
    ];
}

// Keluarkan respons dalam format JSON
echo json_encode($response);
?>