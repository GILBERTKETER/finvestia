<?php

require('./db_conn.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';


function sanitize_input($data)
{
    // Sanitize the data to prevent XSS attacks
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8'); // Use ENT_QUOTES to handle both single and double quotes
    return $data;
}

// Function to validate the password
function validate_password($password)
{
    // Password should be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character
    return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\W_]{8,}$/', $password);
}

$EMAIL_ADDRESS = sanitize_input($_POST['email_address']);
$FIRST_NAME = sanitize_input($_POST['first_name']);
$LAST_NAME = sanitize_input($_POST['last_name']);
$USER_NAME = sanitize_input($_POST['username']);
$PASSWORD = $_POST['password'];
$phoneNumber = sanitize_input($_POST["phone_Number"]);
$CPASSWORD = $_POST['conf_password'];
$refferedBy = sanitize_input($_POST['refferer']);
$accountBalance = 0;
$error = '';
$otp = generateOTP(); // Call a function to generate OTP
$verified = 0; // Set to 0 (false)

// Function to generate OTP
function generateOTP()
{
    return rand(100000, 999999); // Generate a random 6-digit OTP
}
function validateKenyanPhoneNumber($number) {
    // Remove any non-numeric characters
    $cleanedNumber = preg_replace('/[^0-9]/', '', $number);

    // Check if the cleaned number is exactly 10 digits long
    if (strlen($cleanedNumber) !== 10) {
        return false;
    }

    // Check if the number starts with '07' or '01'
    if (!preg_match('/^(07|01)/', $cleanedNumber)) {
        return false;
    }

    // If all checks pass, the number is valid
    return true;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Use prepared statements to prevent SQL injection
    $email_CheckQuery = "SELECT * FROM profitedge_users WHERE Email_Address = ?";
    $userName_CheckQuery = "SELECT * FROM profitedge_users WHERE User_Name = ?";
    $phone_CheckQuery = "SELECT * FROM profitedge_users WHERE Phone_No = ?";
    $stmt1 = $mysqli->prepare($email_CheckQuery);
    $stmt1->bind_param("s", $EMAIL_ADDRESS);
    $stmt1->execute();
    $results1 = $stmt1->get_result();

    $stmt2 = $mysqli->prepare($userName_CheckQuery);
    $stmt2->bind_param("s", $USER_NAME);
    $stmt2->execute();
    $results2 = $stmt2->get_result();

    $stmt0 = $mysqli->prepare($phone_CheckQuery);
    $stmt0->bind_param("s", $phoneNumber);
    $stmt0->execute();
    $results0 = $stmt0->get_result();

    if ($results1->num_rows > 0) {
        $error = "Email Is Already Registered!";
    } else if ($results2->num_rows > 0) {
        $error = "UserName Taken!";
    } else if ($results0->num_rows > 0) {
        $error = "Phone Number Taken!";
    } else if ($PASSWORD != $CPASSWORD) {
        $error = "Passwords don't match!";
    } else if (!validate_password($PASSWORD)) {
        $error = "Password should be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character";
    } 
    elseif(!validateKenyanPhoneNumber($phoneNumber)){
        $error = "The site is not available for your country.";
    }else {
        $status = 'Active';
        $hashed_password = password_hash($PASSWORD, PASSWORD_BCRYPT);
        $sql = "INSERT INTO profitedge_users (Email_Address, First_Name, Last_Name, User_Name, Password, Phone_No,Refferer,Status) 
                    VALUES (?, ?, ?, ?, ?, ?,?,?)";
        $insert_Account_Balance = "INSERT INTO balance_account_users_profitedge(Email_Address,User_Name,Phone_No,Balance_Available) VALUES(?,?,?,?);";
        $balance_stmt = $mysqli->prepare($insert_Account_Balance);
        $balance_stmt->bind_param('ssii', $EMAIL_ADDRESS, $USER_NAME, $phoneNumber, $accountBalance);
        $balance_stmt->execute();

        $stmt3 = $mysqli->prepare($sql);
        $stmt3->bind_param("sssssiss", $EMAIL_ADDRESS, $FIRST_NAME, $LAST_NAME, $USER_NAME, $hashed_password, $phoneNumber, $refferedBy,$status);

        if ($stmt3->execute()) {
            //lets set the users package to bronze by default
            $package = 'Bronze';
            $setDefaultPlan = "INSERT INTO set_plan (Email_Address, User_Name, Package) VALUES (?, ?, ?)";
            $plan_stmt = $mysqli->prepare($setDefaultPlan);
            $plan_stmt->bind_param('sss', $EMAIL_ADDRESS, $USER_NAME, $package);
            $plan_stmt->execute();

            // Update profitedge_users table with OTP and Verified status
            $updateUserQuery = "UPDATE profitedge_users SET OTPCODE = ?, Verified = ? WHERE Email_Address = ?";
            $updateUserStmt = $mysqli->prepare($updateUserQuery);
            $updateUserStmt->bind_param('iss', $otp, $verified, $EMAIL_ADDRESS);
            $otpset = $updateUserStmt->execute();








 if ($otpset) {
                // Construct the reset link with the token

                // Prepare the email content
                $subject = "Verification code";
                $message = "Please use the code $otp to verify your account and proceed to your dashboard!";

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
                    $mail->addAddress($EMAIL_ADDRESS); // Recipient email

                    //Content
                    $mail->isHTML(true);
                    $mail->Subject = $subject;
                    $mail->Body = $message;
                    $mail->send();
                    $error = "Verification code sent to $EMAIL_ADDRESS. Please check your email.";
                } catch (Exception $e) {
                    echo "Error sending reset link: {$mail->ErrorInfo}";
                }
            } else {
                echo "An error occured.";
            }
}
        $stmt3->close();
    }
}

if (isset($error)) {
    echo json_encode(['error' => $error]);
} else {
    echo json_encode(['success' => 'Registration successful']);
}

$stmt1->close();
$stmt2->close();


// Close the connection
$mysqli->close();
