<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $messageContent = isset($_POST['message']) ? trim($_POST['message']) : '';

    if ($name === '' || $email === '' || $messageContent === '') {
        echo '<div class="alert alert-danger" role="alert">Please fill in all required fields.</div>';
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<div class="alert alert-danger" role="alert">Please provide a valid email address.</div>';
        exit;
    }

    $name_safe = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
    $email_safe = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
    $message_safe = htmlspecialchars($messageContent, ENT_QUOTES, 'UTF-8');

    $to = "mitrapartogi@gmail.com"; 
    $subject = "Contact Form Message";

    $body = "<h3>New Message from $name_safe</h3>\n<p>$message_safe</p>\n<p>Email: $email_safe</p>";
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8\r\n";
    $headers .= "From: <$email_safe>\r\n";

    if (function_exists('mail') && mail($to, $subject, $body, $headers)) {
        echo '<div class="alert alert-success" role="alert">Thank you! Your message was sent successfully.</div>';
    } else {
        echo '<div class="alert alert-warning" role="alert">Message queued but the server could not send the email. (Local mail not configured)</div>';
    }

    exit;

}
?>