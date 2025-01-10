<?php
// Memuat PHPMailer autoload
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Memasukkan file PHPMailer jika menggunakan Composer
require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $message = isset($_POST['message']) ? $_POST['message'] : '';

    // Membuat objek PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Pengaturan server SMTP
        $mail->isSMTP();                                            // Menggunakan SMTP
        $mail->Host = 'smtp.gmail.com';                               // Server SMTP Gmail
        $mail->SMTPAuth = true;                                       // Mengaktifkan autentikasi SMTP
        $mail->Username = 'your-email@gmail.com';                     // Email Anda
        $mail->Password = 'your-email-password';                      // Password email Anda
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;           // Enkripsi
        $mail->Port = 587;                                           // Port SMTP

        // Pengaturan pengirim dan penerima
        $mail->setFrom($email, $name);                               // Email pengirim
        $mail->addAddress('pt.ceysiapfp@gmail.com', 'Admin');        // Alamat email tujuan yang baru

        // Konten email
        $mail->isHTML(true);                                         // Mengirim email dalam format HTML
        $mail->Subject = 'Message from Contact Form';                 // Subjek email
        $mail->Body    = "Name: " . $name . "<br>Email: " . $email . "<br>Message: " . nl2br($message); // Isi pesan HTML

        // Mengirim email
        $mail->send();
        echo 'Message has been sent.';
    } catch (Exception $e) {
        echo "Error occurred while sending email: {$mail->ErrorInfo}";
    }

    // Mengirim pesan ke dua nomor WhatsApp
    $whatsappMessage = "Name: $name\nEmail: $email\nMessage: $message";

    // WhatsApp URLs for both numbers
    $whatsappUrl1 = "https://wa.me/089503857819?text=" . urlencode($whatsappMessage);  // First WhatsApp number
    $whatsappUrl2 = "https://wa.me/081211976730?text=" . urlencode($whatsappMessage);  // Second WhatsApp number

    // Redirect to both WhatsApp numbers
    header("Location: $whatsappUrl1"); // Redirect to first number
    header("Location: $whatsappUrl2"); // Redirect to second number
}
?>