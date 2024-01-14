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

$PASSWORD = sanitize_input($_POST['password']);
$phoneNumber = sanitize_input($_POST["phoneNumber"]);



if (isset($_POST['changephoneno'])) {
    $phone_CheckQuery = "SELECT * FROM profitedge_users WHERE Phone_No = ?";
    $stmt0 = $mysqli->prepare($phone_CheckQuery);
    $stmt0->bind_param("s", $phoneNumber);
    $stmt0->execute();
    $results0 = $stmt0->get_result();

    if ($results0->num_rows > 0) {
        echo "Phone Number Taken!";
    } else {

        $passwordDB = '';
        //lets check the password
        $checkpass = "SELECT * FROM profitedge_users WHERE Email_Address = ?";
        $stmt2 = $mysqli->prepare($checkpass);
        $stmt2->bind_param('s', $email);
        $stmt2->execute();
        $resultingPass = $stmt2->get_result();
        if ($resultingPass->num_rows > 0) {
            $rowPass = $resultingPass->fetch_assoc();
            $passwordDB = $rowPass['Password'];
        }
        if (password_verify($PASSWORD, $passwordDB)) {
            //update the db and log out
            $setPhoneSql = "UPDATE profitedge_users SET Phone_No = ? WHERE Email_Address = ?";
            $stmt = $mysqli->prepare($setPhoneSql);
            $stmt->bind_param('is', $phoneNumber, $email);
            $stmt->execute();
            echo "successfull phone number change.Please Relogin!";
        } else {
            echo "Unsuccessfull Modification!Incorrect Password";
        }
    }
}
