<?php
session_start();
require('./db_conn.php');
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitButton'])) {

    $enteredOTP = $_POST["enteredOTP"];
    $sessionEmail = $_SESSION["LOGGED_IN_EMAIL"]; // Assuming you've set the session variable

        if (empty($enteredOTP)) {
            echo "Please enter the OTP.";
        } else {
            $getUserQuery = "SELECT OTPCODE FROM profitedge_users WHERE Email_Address = ?";
            $getUserStmt = $mysqli->prepare($getUserQuery);
            $getUserStmt->bind_param('s', $sessionEmail);
            $getUserStmt->execute();
            $getUserResult = $getUserStmt->get_result();
    
            if ($getUserResult->num_rows === 1) {
                $userRow = $getUserResult->fetch_assoc();
                $storedOTP = $userRow["OTPCODE"];
                
                if ($enteredOTP == $storedOTP) {
                    // OTP is correct, update the Verified field
                    $updateVerifiedQuery = "UPDATE profitedge_users SET Verified = 1, OTPCODE = NULL WHERE Email_Address = ?";
                    $updateVerifiedStmt = $mysqli->prepare($updateVerifiedQuery);
                    $updateVerifiedStmt->bind_param('s', $sessionEmail);
    
                    if ($updateVerifiedStmt->execute()) {
                        echo "OTP verified successfully. Your account is now verified.";
                    } else {
                        echo "Error updating verification status.";
                    }
    
                    $updateVerifiedStmt->close();
                } else {
                    echo "Invalid OTP.";
                }
            } else {
                echo "User not found.";
            }
        }
    } else {
        echo "Invalid request.";
    }
