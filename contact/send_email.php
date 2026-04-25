<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $name = htmlspecialchars($_POST['name']);
    $message = htmlspecialchars($_POST['message']);
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    
    // Main recipient email
    $to = "getnestforyou@gmail.com"; // Your main recipient email
    $subject = "New Query from " . $name;

    // Main email message
    $message = "Hi $name,\n\nThank you for reaching out to nestforyou for your query: '$message'. Our consultants will contact you on $email or $subject to serve your needs.\n\nThanks,\n\nnestforyou.";

    // Set headers
    $headers = "From: getnestforyou@gmail.com\r\n";
    $headers .= "CC: getnestforyou@gmail.com\r\n"; // CC recipient email

    // Send the main email
    if (mail($to, $subject, $message, $headers)) {
        echo "Email sent successfully.";
        echo "<script>console.log('Email sent successfully to $to with subject: $subject');</script>";
    } else {
        echo "Failed to send email.";
        echo "<script>console.log('Failed to send email to $to');</script>";
    }
}
?>
