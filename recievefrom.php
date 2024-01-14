<?php
// session_start();
require('./db_conn.php');
$email = $_SESSION['LOGGED_IN_EMAIL'];
$username = $_SESSION['LOGGED_IN_USERNAME'];
$phone = $_SESSION['LOGGED_IN_PHONE'];

// Lets fetch the number the admin set for the transaction
$numberQuery1 = "SELECT * FROM requestedwithdrawals WHERE Email_Address = ? AND User_Name = ? AND Phone_No = ?;";
$numberquery_stmt1 = $mysqli->prepare($numberQuery1);
$numberquery_stmt1->bind_param('ssi', $email, $username, $phone);
$numberquery_stmt1->execute();
$numberResult1 = $numberquery_stmt1->get_result();

if ($numberResult1->num_rows > 0) {
    $Rowwnumber = $numberResult1->fetch_assoc();
    $recievefrom = $Rowwnumber['Recieve_From'];
    if (empty($recievefrom)) {
        $recivefromthis = 'Just A Bit..!!';
    } else {
        $recivefromthis = $Rowwnumber['Recieve_From'];
    }
} else {
    $recivefromthis = '';
}
