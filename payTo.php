<?php
// session_start();
require('../server/db_conn.php');
$email = $_SESSION['LOGGED_IN_EMAIL'];
$username = $_SESSION['LOGGED_IN_USERNAME'];
$phone = $_SESSION['LOGGED_IN_PHONE'];

//lets fetch the number the admin set to the transaction
$numberQuery = "SELECT * FROM transactionsupdate WHERE Email_Address = ? AND User_Name = ? AND Phone_No = ?;";
$numberquery_stmt = $mysqli->prepare($numberQuery);
$numberquery_stmt->bind_param('ssi', $email, $username, $phone);
$numberquery_stmt->execute();
$numberResult = $numberquery_stmt->get_result();


if ($numberResult->num_rows > 0) {
    $Rowwnumber = $numberResult->fetch_assoc();
    $confirmation = $Rowwnumber['PayTo'];
    if ($confirmation == 0 || $confirmation == '') {
        $PayTo = 'Please wait...!';
    } else {
        $PayTo = $Rowwnumber['PayTo'];
    }
} else {
    $PayTo = '';
}
