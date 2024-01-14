<?php
require('./db_conn.php');
// Check if the request was made via AJAX
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {

    function sanitize_input($data)
    {
        // Sanitize the data to prevent XSS attacks
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8'); // Use ENT_QUOTES to handle both single and double quotes
        return $data;
    }
    if (isset($_POST['updatewithdrawalRequests4'])) {
        $response = '';
        if (isset($_POST['username']) && isset($_POST['useremail'])) {
            $recieveFrom = sanitize_input($_POST['recieveFrom']);
            $mpesaCode = sanitize_input($_POST['mpesaCode']);
            $userRequestedwithdrawalAmount = sanitize_input($_POST['userRequestedwithdrawalAmount']);
            $useremail = sanitize_input($_POST['useremail']);
            $username = sanitize_input($_POST['username']);


            //we check the records in the db first
            $check = "SELECT * FROM requestedwithdrawals WHERE Email_Address = ?  AND User_Name = ?";
            $check_stmt = $mysqli->prepare($check);
            $check_stmt->bind_param('ss', $useremail, $username);
            $check_stmt->execute();
            $check_stmt_res = $check_stmt->get_result();
            if ($check_stmt_res->num_rows > 0) {
                $check_stmt_result = $check_stmt_res->fetch_assoc();
                $currentUserMpesaCode = $check_stmt_result['TransactionID'];
                $currentSendToUserAccount = $check_stmt_result['Recieve_From'];
                $currentUserWithdrawAmount = $check_stmt_result['Amount'];

                if ($currentUserMpesaCode == $mpesaCode && $currentSendToUserAccount == $recieveFrom && $currentUserWithdrawAmount == $userRequestedwithdrawalAmount) {

                    $response = "Hey!You did not make any change!";
                } else {
                    //we update  the respective table
                    $updateProfitedge = "UPDATE requestedwithdrawals SET TransactionID = ?, Recieve_From = ?,Amount = ? WHERE Email_Address = ? AND User_Name = ?";
                    $updateProfitedge_stmt = $mysqli->prepare($updateProfitedge);
                    $updateProfitedge_stmt->bind_param('siiss', $mpesaCode, $recieveFrom, $userRequestedwithdrawalAmount, $useremail, $username);
                    $updatedProfitedge = $updateProfitedge_stmt->execute();
                    if ($updatedProfitedge) {
                        $response = "Success!The record is Updated";
                    } else {
                        $response = "Appologies!We can't update the record at the moment!";
                    }
                }
            } else {
                $response = "We think the user has not requested a withdrawal!";
            }
        } else {
            $response = "Sorry!Check if user exists!";
        }
    }

    // ================
    if (isset($_POST['updateDepositsRequests'])) {
        $response = '';
        if (isset($_POST['username']) && isset($_POST['useremail'])) {
            $transactionId23 = sanitize_input($_POST['transactionId23']);
            $userRecieveAt = sanitize_input($_POST['myphoneRecieveing1']);
            $useremail = sanitize_input($_POST['useremail']);
            $username = sanitize_input($_POST['username']);


            //we check the records in the db first
            $check = "SELECT * FROM transactionsupdate WHERE Email_Address = ?  AND User_Name = ?";
            $check_stmt = $mysqli->prepare($check);
            $check_stmt->bind_param('ss', $useremail, $username);
            $check_stmt->execute();
            $check_stmt_res = $check_stmt->get_result();
            if ($check_stmt_res->num_rows > 0) {
                $check_stmt_result = $check_stmt_res->fetch_assoc();
                $currentUsertransactionId23 = $check_stmt_result['TransactionID'];
                $currentUserPayTo = $check_stmt_result['PayTo'];

                if ($transactionId23 == $currentUsertransactionId23 && $currentUserPayTo == $userRecieveAt) {

                    $response = "Hey!You did not make any change!Try Again!";
                } else {
                    //we update  the respective table
                    $updateProfitedge3 = "UPDATE transactionsupdate SET TransactionID = ?, PayTo = ? WHERE Email_Address = ? AND User_Name = ?";
                    $updateDepoRequests1 = $mysqli->prepare($updateProfitedge3);
                    $updateDepoRequests1->bind_param('siss', $transactionId23, $userRecieveAt, $useremail, $username);
                    $updatedProfitedge1 = $updateDepoRequests1->execute();
                    if ($updatedProfitedge1) {
                        $response = "Success!Record Updated!";
                    } else {
                        $response = "Appologies!We can't update the record at the moment!";
                    }
                }
            } else {
                $response = "We think the user has not requested a deposit!";
            }
        } else {
            $response = "Sorry!Check if user exists!";
        }
    }
    // Handle the response as a JSON object
    $responseData = array('message' => $response);
    echo json_encode($responseData);
} else {
    // If the request was not made via AJAX, return a forbidden response
    http_response_code(403);
}
