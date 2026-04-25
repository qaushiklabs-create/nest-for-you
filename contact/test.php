<?php
    $receiving_email_address = 'kaushik06shivam@gmail.com';
    $to = 'kaushik06shivam@gmail.com';

    // Sanitize inputs
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    $from = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_SPECIAL_CHARS);
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS);
    $number = filter_input(INPUT_POST, 'number', FILTER_SANITIZE_SPECIAL_CHARS);

    // Validate email
    if (filter_var($from, FILTER_VALIDATE_EMAIL)) {
        // Build the "From" header with display name if provided
        $fromName = !empty($name) ? htmlspecialchars($name) : 'Anonymous';
        $fromEmail = htmlspecialchars($from);

        // Sanitize the subject to prevent email header injection
        $subject = htmlspecialchars($subject);
        
        // Prepare the email headers, ensuring the email is from getnestforyou@gmail.com to avoid spoofing issues
        $headers = "From: $fromName <kaushik06shivam@gmail.com>\r\n";
        $headers .= "Reply-To: $fromEmail\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n"; // Set content type for encoding

        // Construct the email message
        $message_with_number = "Phone Number: " . htmlspecialchars($number) . "\r\nMessage:\r\n" . htmlspecialchars($message);

        // Attempt to send the email
        if (mail($to, $subject, $message_with_number, $headers)) {
            // Response if successful
            echo 'OK';
        } else {
            // Response if the email fails to send
            echo 'Error: Email could not be sent. Please try again later.';
        }
    } else {
        // Response if the email is invalid
        echo 'Invalid email address.';
    }
?>
