<?php
header('Content-Type: application/json');

try {
    // Buat koneksi PDO
    include 'koneksi.php';

    // Set error mode ke exception
    $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Mendapatkan data dari formulir
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $status_user = 'user';

    // Persiapkan statement SQL untuk menyimpan data ke database
    $stmt = $koneksi->prepare("INSERT INTO users (username, password, email, no_telpon, status_user) VALUES (?, ?, ?, ?, ?)");

    // Bind parameter ke statement
    $stmt->bindParam(1, $username);
    $stmt->bindParam(2, $password);
    $stmt->bindParam(3, $email);
    $stmt->bindParam(4, $phone);
    $stmt->bindParam(5, $status_user);

    // Proses data atau simpan ke database
    if ($stmt->execute()) {
        $response = array('status' => 'success', 'message' => 'Data berhasil disimpan');
        header('Location: ../register.php?notif=' . urlencode($response['message']));
        exit();
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

// Mengembalikan response dalam format JSON
echo json_encode($response);
?>
