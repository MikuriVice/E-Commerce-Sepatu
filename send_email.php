<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil nilai dari form
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Email tujuan
    $to = "tujuan@example.com"; // Ganti dengan alamat email tujuan

    // Subjek email
    $subject = "Pesan dari Formulir Kontak Toko Sepatu";

    // Konten email
    $content = "Nama: $name\n";
    $content .= "Email: $email\n\n";
    $content .= "Pesan:\n$message\n";

    // Header email
    $headers = "From: $email";

    // Kirim email
    if (mail($to, $subject, $content, $headers)) {
        echo '<script>alert("Pesan Anda telah berhasil dikirim.");</script>';
    } else {
        echo '<script>alert("Maaf, pesan Anda gagal dikirim. Silakan coba lagi nanti.");</script>';
    }
}
?>
