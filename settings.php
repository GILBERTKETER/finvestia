<?php
session_start();
require('./db_conn.php');
$email = $_SESSION['LOGGED_IN_EMAIL'];
function sanitize_input($data)
{
    // Sanitize the data to prevent XSS attacks
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8'); // Use ENT_QUOTES to handle both single and double quotes
    return $data;
}
if (isset($_POST['changePass'])) {
    $hashed_Password = '';
    $oldPassword = sanitize_input($_POST['old']);
    $newPassword = sanitize_input($_POST['new']);
    $confirmPass = sanitize_input($_POST['conf_new']);

    //fetch the passwords from the db
    $RealPassword = "SELECT * FROM profitedge_users WHERE Email_Address=?";
    $stmt = $mysqli->prepare($RealPassword);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $hashed_Password = $row['Password'];
    }

    if (password_verify($oldPassword, $hashed_Password)) {
        if ($newPassword == $confirmPass) {
            $newHashed_Password = password_hash($newPassword, PASSWORD_BCRYPT);
            //perform the sql query
            $updatePassword = "UPDATE profitedge_users SET Password = ? WHERE Email_Address = ?";
            $stmt2 = $mysqli->prepare($updatePassword);
            $stmt2->bind_param('ss', $newHashed_Password, $email);
            $stmt2->execute();
            echo "Password changed Successfully";
        } else {
            echo "New and Old Passwords Dont Match";
        }
    } else {
        echo "Old Password Incorrect";
    }
}
