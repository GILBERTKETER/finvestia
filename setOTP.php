<?php
session_start();
require('./db_conn.php');
$email = $_SESSION['LOGGED_IN_EMAIL'];
$user = $_SESSION['LOGGED_IN_USERNAME'];
function sanitize_input($data)
{
    // Sanitize the data to prevent XSS attacks
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8'); // Use ENT_QUOTES to handle both single and double quotes
    return $data;
}
if (isset($_POST['changephoneno'])) {
    $PASSWORD = sanitize_input($_POST['password']);
    $CONFOTP = sanitize_input($_POST['confotp']);
    $NEWOTP = sanitize_input($_POST['newotp']);
    $OLDOTP = sanitize_input($_POST['oldotp']);

    //lets check the password
    $admin = "SELECT * FROM profitedge_users WHERE Email_Address = ? AND User_Name = ?";
    $admin_stmt = $mysqli->prepare($admin);
    $admin_stmt->bind_param('ss', $email, $user);
    $admin_stmt->execute();
    $admin_stmt_res = $admin_stmt->get_result()->fetch_assoc();
    $ADMINPASSWORD = $admin_stmt_res['Password'];
    $CURRENTADMINOTP = $admin_stmt_res['AdminOTP'];

    if (password_verify($PASSWORD, $ADMINPASSWORD)) {
        //we proceed to check if the otp is in the db
        if ($OLDOTP == $CURRENTADMINOTP) {
            //check if the otp is equal
            if ($NEWOTP == $CONFOTP) {
                //check  if the otp is greater than 5 chars
                if (mb_strlen($NEWOTP) >= 5) {
                    //we inser it to the db
                    $UPDATE = "UPDATE profitedge_users SET AdminOTP = ? WHERE Email_Address = ? AND User_Name = ?";
                    $UPDATE_stmt = $mysqli->prepare($UPDATE);
                    $UPDATE_stmt->bind_param('sss', $NEWOTP, $email, $user);
                    $UPDATE_stmt->execute();
                    echo "Your OTP has been set Successfully.";
                } else {
                    echo "Sorry!The OTP should be atleast 5 characters!";
                }
            } else {
                echo "The OTP do not match!";
            }
        } else {
            echo "The Old OTP is incorrect!";
        }
    } else {
        echo "Incorrect Password";
    }
}
