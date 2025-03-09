<?php
// Import the PHPMailer library
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Ensure the request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die(json_encode(['status' => 'error', 'message' => 'Invalid request']));
}

// Collect and sanitize form data
$name = htmlspecialchars($_POST['name']);
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$message = htmlspecialchars($_POST['message']);

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die(json_encode(['status' => 'error', 'message' => 'Invalid email address']));
}

// Email credentials (Use environment variables for security)
$smtpHost = 'smtp.gmail.com';
$smtpUsername = getenv('SMTP_USERNAME'); // Set in your server or hosting panel
$smtpPassword = getenv('SMTP_PASSWORD'); // Set an app-specific password in Gmail
$receiverEmail = 'ayfokruleul1@gmail.com'; // Your email

// Prepare the email content
$subject = "New Contact Form Submission from " . $name;
$body = "<h3>Message from: $name</h3>
         <p>Email: $email</p>
         <p>Message: $message</p>";

try {
    // Create PHPMailer object
    $mail = new PHPMailer(true);

    // SMTP configuration
    $mail->isSMTP();
    $mail->Host = $smtpHost;
    $mail->SMTPAuth = true;
    $mail->Username = $smtpUsername;
    $mail->Password = $smtpPassword;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Set email headers and body
    $mail->setFrom($smtpUsername, 'Contact Form');
    $mail->addAddress($receiverEmail);
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body    = $body;

    // Send email
    if ($mail->send()) {
        echo json_encode(['status' => 'success', 'message' => 'Message sent successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Message could not be sent.']);
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => "Mailer Error: {$mail->ErrorInfo}"]);
}
?>