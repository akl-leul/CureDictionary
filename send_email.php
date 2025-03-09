<?php
// Import the PHPMailer library
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // If you installed PHPMailer via Composer

// Collect form data
$name = htmlspecialchars($_POST['name']);
$email = htmlspecialchars($_POST['email']);
$message = htmlspecialchars($_POST['message']);

// Sanitize email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die('Invalid email address');
}

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
    $mail->Host = 'smtp.gmail.com';  // Gmail SMTP server
    $mail->SMTPAuth = true;
    $mail->Username = 'ayfokruleul1@gmail.com';  // Your Gmail address
    $mail->Password = 'myr qza yir ytv qjjn';  // Use an app-specific password for Gmail (not your normal password)
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Set the email headers and body
    $mail->setFrom('ayfokruleul1@gmail.com', 'Contact Form');
    $mail->addAddress('ayfokruleul1@gmail.com');  // Your email
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body    = $body;

    // Send email
    if ($mail->send()) {
        // If the email is sent successfully, redirect to the index page
        header('Location: index.html');
        exit(); // Make sure no other code is executed after redirection
    } else {
        // If email fails to send
        echo 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
    }
} catch (Exception $e) {
    // In case of an error
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
