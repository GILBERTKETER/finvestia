<?php
session_start();
require('./db_conn.php');
$user = $_SESSION['LOGGED_IN_USERNAME'];
$email = $_SESSION['LOGGED_IN_EMAIL'];
$phone = $_SESSION['LOGGED_IN_PHONE'];
$response = '';
if (isset($_POST['request'])) {


    //first check if there is a currently running transaction not confirmed
    $running = "SELECT * FROM transactionsupdate WHERE Email_Address = ? AND User_Name = ?";
    $running_stmt = $mysqli->prepare($running);
    $running_stmt->bind_param('ss', $email, $user);
    $running_stmt->execute();
    $running_result = $running_stmt->get_result();
    if ($running_result->num_rows >= 1) {
        $response = "There is a transaction to be confirmed First!";
    } else {
        
        //update or insert the transaction details for the user
        $insertDetails = "INSERT INTO transactionsupdate (Email_Address,User_Name,Phone_No) VALUES(?,?,?);";
        $insert_stmt = $mysqli->prepare($insertDetails);
        $insert_stmt->bind_param('ssi', $email, $user, $phone);
        $requsted = $insert_stmt->execute();
        if ($requsted) {
            $response = "Thanks! You request is succesfull.";
        } else {
            $response = "Request Unsuccessfull!";
        }
    }
    // Handle the response as a JSON object
    $responseData = array('message' => $response);
    echo json_encode($responseData);
} else {
    // If the request was not made via AJAX, return a forbidden response
    http_response_code(403);
}
