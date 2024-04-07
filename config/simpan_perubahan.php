<?php
header('Content-Type: application/json');

include 'config/koneksi.php';
try {
    

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $nama = $_POST['nama'];
        $email = $_POST['email'];
        $nomer_telpon = $_POST['no_telpon'];

        // Foto
        $foto = '';
        // Handle file upload
        $upload_dir = "config/uploads/";
        $target_file = $upload_dir . basename($_FILES["foto"]["name"]);
        move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file);

        $foto_path = empty($_FILES["foto"]["name"]) ? $_POST['old_foto'] : $_FILES["foto"]["name"];

        $query = "UPDATE users SET 
            nama = :nama,
            email = :email,
            no_telpon = :nomer_telpon,
            foto = :foto_path
            WHERE username = :username";

        $stmt = $koneksi->prepare($query);
        $stmt->bindParam(':nama', $nama);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':nomer_telpon', $nomer_telpon);
        $stmt->bindParam(':foto_path', $foto_path);
        $stmt->bindParam(':username', $username);

        if ($stmt->execute()) {
            $response = array('status' => 'success', 'message' => 'Perubahan berhasil disimpan.');
            header('Location: ../ubah_profile_user.php?notif=' . urlencode($response['message']));
            exit();
        } else {
            $response = array('status' => 'error', 'message' => 'Gagal menyimpan perubahan: ' . $stmt->errorInfo()[2]);
        }
    } else {
        $response = array('status' => 'error', 'message' => 'Metode permintaan tidak valid');
    }
} catch (PDOException $e) {
    $response = array('status' => 'error', 'message' => 'Koneksi Gagal: ' . $e->getMessage());
}

echo json_encode($response);
?>