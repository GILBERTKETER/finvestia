<?php
require('./db_conn.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST["token"];
    $newPassword = $_POST["newPassword"];
    $confirmPassword = $_POST["confirmPassword"];

    // Validate inputs and password strength
    if (empty($token) || empty($newPassword) || empty($confirmPassword)) {
        echo "All fields are required.";
    } elseif (strlen($newPassword) < 8) {
        echo "Password must be at least 8 characters long.";
    } elseif (!preg_match('/[A-Z]/', $newPassword)) {
        echo "Password must contain at least one capital letter.";
    } elseif (!preg_match('/[a-z]/', $newPassword)) {
        echo "Password must contain at least one lowercase letter.";
    } elseif (!preg_match('/[0-9]/', $newPassword)) {
        echo "Password must contain at least one digit.";
    } elseif (!preg_match('/[^a-zA-Z\d]/', $newPassword)) {
        echo "Password must contain at least one special character.";
    } elseif ($newPassword !== $confirmPassword) {
        echo "Passwords do not match.";
    } else {
        // Hash the new password before storing it
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Check if the token exists
        $checkTokenQuery = "SELECT ResetToken FROM profitedge_users WHERE ResetToken = ?";
        $checkTokenStmt = $mysqli->prepare($checkTokenQuery);
        $checkTokenStmt->bind_param('s', $token);
        $checkTokenStmt->execute();
        $checkTokenResult = $checkTokenStmt->get_result();

        if ($checkTokenResult->num_rows === 0) {
            echo "Invalid token.";
        } else {
            // Proceed with password change
            $updatePasswordQuery = "UPDATE profitedge_users SET Password = ?, ResetToken = NULL WHERE ResetToken = ?";
            $updatePasswordStmt = $mysqli->prepare($updatePasswordQuery);
            $updatePasswordStmt->bind_param('ss', $hashedPassword, $token);

            if ($updatePasswordStmt->execute()) {
                echo "Password has been successfully changed.";
            } else {
                echo "Error updating the password.";
            }

            $updatePasswordStmt->close();
        }
        
        $checkTokenStmt->close();
    }
} else {
    echo "Invalid request.";
}
