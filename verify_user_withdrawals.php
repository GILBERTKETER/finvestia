<?php
session_start();
require('./db_conn.php');

// Check if the request was made via AJAX
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    $response = '';
    $type = 'finVestAdminLoggedInAccept';
    function sanitize_input($data)
    {
        // Sanitize the data to prevent XSS attacks
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8'); // Use ENT_QUOTES to handle both single and double quotes
        return $data;
    }
    // Check if the required fields are present in the POST data
    if (isset($_POST['withdrawUserBtn'])) {
        $email = $_SESSION['LOGGED_IN_EMAIL'];
        $user = $_SESSION['LOGGED_IN_USERNAME'];
        $phone = $_SESSION['LOGGED_IN_PHONE'];
        $withdrawID = sanitize_input($_POST['withdrawID']);
        $withdrawPhone = sanitize_input($_POST['withdrawPhone']);
        $withdrawAmount = sanitize_input($_POST['withdrawAmount']);
        $O_T_P = sanitize_input($_POST['O_T_P']);
        $withdrawDate = sanitize_input($_POST['withdrawDate']);
        $withdrawTime = sanitize_input($_POST['withdrawTime']);
        $withdrawPass = sanitize_input($_POST['withdrawPass']);
        $withdrawTransactor = sanitize_input($_POST['withdrawTransactor']);
        $phonerecieving = sanitize_input($_POST['phonerecieving']);



        $adminInfo = "SELECT * FROM profitedge_users WHERE Joiner_Account_Type = ? AND Email_Address = ?";
        $adminInfo_statement = $mysqli->prepare($adminInfo);
        $adminInfo_statement->bind_param('ss', $type, $email);
        $adminInfo_statement->execute();
        $adminInfo_statement_res = $adminInfo_statement->get_result()->fetch_assoc();
        $realAdminPass = $adminInfo_statement_res['Password'];
        $otp = $adminInfo_statement_res['AdminOTP'];
        //check the password before doing any query
        if (password_verify($withdrawPass, $realAdminPass)) {
            //if otp is correct
            if ($O_T_P == $otp) {
                //we check if the phone sending money is in the withdrawrequest
                $verifyPhonesending = "SELECT * FROM requestedwithdrawals WHERE Phone_No = ? AND Amount = ?";
                $verifyPhonesending_stmt = $mysqli->prepare($verifyPhonesending);
                $verifyPhonesending_stmt->bind_param('ii', $phonerecieving, $withdrawAmount);
                $verifyPhonesending_stmt->execute();
                $verifyPhonesending_stmt_results = $verifyPhonesending_stmt->get_result();
                if ($verifyPhonesending_stmt_results->num_rows > 0) {
                    //we update the withdraw request table
                    $updateWithdrawRequestTable = "UPDATE requestedwithdrawals SET Recieve_From = ?,TransactionID = ?,Transactor = ?, Date = ?,Time = ?";
                    $updateWithdrawRequestTable_stmt = $mysqli->prepare($updateWithdrawRequestTable);
                    $updateWithdrawRequestTable_stmt->bind_param('issss', $withdrawPhone, $withdrawID, $withdrawTransactor, $withdrawDate, $withdrawTime);
                    $updatedwithdrawRquest = $updateWithdrawRequestTable_stmt->execute();
                    if ($updatedwithdrawRquest) {
                        $response = "Thanks!You have successfully withdrew for $phonerecieving";
                    } else {
                        $response = "Sorry!The server has a problem!";
                    }
                } else {
                    $response = "Sorry!There is an error on Phone recieving,sending or the amount is incorrect!";
                }
            } else {
                $response = "Incorrect OTP";
            }
        } else {
            $response = "Incorrect Admin Password";
        }

        //check if the amoun customer requested is in the withdraw requests

        // Handle the response as a JSON object
        $responseData = array('message' => $response);
        echo json_encode($responseData);
    } else {
        // If the request was not made via AJAX, return a forbidden response
        http_response_code(403);
    }
}
