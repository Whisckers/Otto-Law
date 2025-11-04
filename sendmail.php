<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get and sanitize form data
    $fullname = htmlspecialchars(trim($_POST['fullname']));
    $email    = htmlspecialchars(trim($_POST['email']));
    $phone    = htmlspecialchars(trim($_POST['phone']));
    $message  = htmlspecialchars(trim($_POST['message']));

    $mail = new PHPMailer(true);

    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host       = 'mail.ottoitumelenglaw.co.bw'; 
        $mail->SMTPAuth   = true;
        $mail->Username   = 'info@ottoitumelenglaw.co.bw';
        $mail->Password   = 'YOUR_EMAIL_PASSWORD'; // replace with your actual email password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // For port 465
        $mail->Port       = 465;

        // Sender
        $mail->setFrom('info@ottoitumelenglaw.co.bw', 'Otto Itumeleng Law Chambers Website');

        // Recipients for main submission (your team)
        $mail->addAddress('info@ottoitumelenglaw.co.bw');
        $mail->addAddress('sarona@ottoitumelenglaw.co.bw');
        $mail->addAddress('odirile@ottoitumelenglaw.co.bw');

        // Email content for your team
        $mail->isHTML(true);
        $mail->Subject = "New Contact Form Submission from $fullname";
        $mail->Body    = "
            <h3>New message from your website contact form:</h3>
            <p><strong>Name:</strong> $fullname</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Phone:</strong> $phone</p>
            <p><strong>Message:</strong><br>$message</p>
        ";
        $mail->AltBody = "Name: $fullname\nEmail: $email\nPhone: $phone\nMessage:\n$message";

        // Send the main email first
        $mail->send();

        // --- Send confirmation email to the person who filled the form ---
        $confirmMail = new PHPMailer(true);
        $confirmMail->isSMTP();
        $confirmMail->Host       = 'mail.ottoitumelenglaw.co.bw';
        $confirmMail->SMTPAuth   = true;
        $confirmMail->Username   = 'info@ottoitumelenglaw.co.bw';
        $confirmMail->Password   = 'YOUR_EMAIL_PASSWORD';
        $confirmMail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $confirmMail->Port       = 465;

        $confirmMail->setFrom('info@ottoitumelenglaw.co.bw', 'Otto Itumeleng Law Chambers Website');
        $confirmMail->addAddress($email); // send to the user

        $confirmMail->isHTML(true);
        $confirmMail->Subject = "Thank you for contacting Otto Itumeleng Law Chambers";
        $confirmMail->Body    = "
            <h3>Dear $fullname,</h3>
            <p>Thank you for contacting Otto Itumeleng Law Chambers. We have received your message and will get back to you shortly.</p>
            <p><strong>Your Message:</strong><br>$message</p>
            <p>Best regards,<br>Otto Itumeleng Law Chambers Team</p>
        ";
        $confirmMail->AltBody = "Dear $fullname,\n\nThank you for contacting Otto Itumeleng Law Chambers. We have received your message and will get back to you shortly.\n\nYour Message:\n$message\n\nBest regards,\nOtto Itumeleng Law Chambers Team";

        $confirmMail->send();

        // Success alert
        echo "<script>alert('Thank you, your message has been sent successfully! A confirmation email has also been sent to you.'); window.location.href='contact.html';</script>";

    } catch (Exception $e) {
        echo "<script>alert('Error sending message: {$mail->ErrorInfo}'); window.history.back();</script>";
    }
}
?>
