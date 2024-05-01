<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Path to PHPMailer autoload file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'saipradyumna1@gmail.com'; // Your Gmail email address
        $mail->Password = '8801364653'; // Your Gmail password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('saipradyumna1@gmail.com', 'Sai pradyumna'); // Sender's email address and name
        $mail->addAddress($email); // Recipient's email address
        $mail->Subject = 'Table Booking Confirmation';
        $mail->Body = "Hello $name,\n\nYour table has been successfully booked.\n\nBooking Details:\nName: $name\nPhone: $phone\nEmail: $email\n\nThank you!";

        $mail->send();
        echo "<script>alert('Booking successful! Check your email for confirmation.')</script>";
    } catch (Exception $e) {
        echo "<script>alert('Booking failed! Please try again.')</script>";
    }
}
?>
