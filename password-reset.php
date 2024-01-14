<?php
require('./db_conn.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

if (isset($_POST["submitButton"])) {
    $email = $_POST["email"];

    if (empty($email)) {
        echo "Please provide the Email Address!";
    } else {
        // Generate a unique token
        $token = bin2hex(random_bytes(32)); // Generate a 64-character token

        $emailCheck = "SELECT * FROM profitedge_users WHERE Email_Address = ?";
        $emailCheck_stmt = $mysqli->prepare($emailCheck);
        $emailCheck_stmt->bind_param('s', $email);
        $emailCheck_stmt->execute();
        $emailCheck_stmt_res = $emailCheck_stmt->get_result();
        if ($emailCheck_stmt_res->num_rows == 1) {
            // Insert the token into the database
            $insertTokenQuery = "UPDATE profitedge_users SET ResetToken = ? WHERE Email_Address = ?";
            $insertTokenStmt = $mysqli->prepare($insertTokenQuery);
            $insertTokenStmt->bind_param('ss', $token, $email);

            if ($insertTokenStmt->execute()) {
                // Construct the reset link with the token
                $resetLink = "https://www.finvestia.co.ke/ResetPassword.php?token=" . $token;

                // Prepare the email content
                $subject = "Password Reset Link";
                $message = "Click the following link to reset your password: $resetLink";

                // Create a new PHPMailer instance
                $mail = new PHPMailer(true); // Set true to enable exceptions

                try {
                    //Server settings
                    $mail->SMTPDebug = 0; // 0 = no output, 2 = verbose output
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com'; // Your SMTP server
                    $mail->Port = 587; // Your SMTP server port
                    $mail->SMTPAuth = true;
                    $mail->Username = 'finvestiateam@gmail.com'; // Your SMTP username
                    $mail->Password = 'lgbqkqkonuymxzzi'; // Your SMTP password
                    $mail->SMTPSecure = 'tls'; // tls or ssl

                    //Recipients
                    $mail->setFrom('finvestiateam@gmail.com', 'finVestia Team'); // Sender email and name
                    $mail->addAddress($email); // Recipient email

                    //Content
                    $mail->isHTML(true);
                    $mail->Subject = $subject;
                    $mail->Body = $message;

                    $mail->send();
                    echo "Reset link sent to $email. Please check your email.";
                } catch (Exception $e) {
                    echo "Error sending reset link: {$mail->ErrorInfo}";
                }
            } else {
                echo "An error occured!";
            }

            $insertTokenStmt->close();
        } else {
            echo "The provided Email Does Not Exist In our Server!";
        }
    }
} else {
    echo "No email received.";
}
