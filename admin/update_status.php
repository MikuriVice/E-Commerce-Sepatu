<?php
// update_status.php

// Pastikan permintaan datang melalui metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pastikan parameter id dan status tersedia
    if (isset($_POST['id']) && isset($_POST['status'])) {
        $id = $_POST['id'];
        $status = $_POST['status'];

        // Lakukan koneksi ke database
        try {
            $conn = new PDO('mysql:host=localhost;dbname=ecomm', 'root', '');
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Persiapkan dan eksekusi query UPDATE
            $stmt = $conn->prepare("UPDATE sales SET status = :status WHERE id = :id");
            $stmt->execute(['status' => $status, 'id' => $id]);

            // Kirim respons JSON berhasil
            echo json_encode(['success' => true]);
        } catch (PDOException $e) {
            // Tangani kesalahan koneksi atau eksekusi query
            echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        }
    } else {
        // Kirim respons JSON jika parameter tidak lengkap
        echo json_encode(['success' => false, 'message' => 'Missing parameters']);
    }
} else {
    // Kirim respons JSON jika permintaan bukan metode POST
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
