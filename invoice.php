<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


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
    // Check if the required fields are present in the POST data
    if (isset($_POST['transactBtn2'])) {
        $transactionID = sanitize_input($_POST['transactionID']);
        $phone = sanitize_input($_POST['phone']);
        $Amount = sanitize_input($_POST['amount']);
        $OTP = sanitize_input($_POST['OTP']);
        $password = sanitize_input($_POST['pass']);
        $date = sanitize_input($_POST['date']);
        $time = sanitize_input($_POST['time']);
        $transactor = sanitize_input($_POST['transactor']);
        $response = '';
        $AccountType = 'finVestAdminLoggedInAccept';

        $admin_info = "SELECT * FROM profitedge_users WHERE Joiner_Account_Type = ?";
        $admin_stmt = $mysqli->prepare($admin_info);
        $admin_stmt->bind_param('s', $AccountType);
        $admin_stmt->execute();
        $results = $admin_stmt->get_result();

        if ($results->num_rows > 0) {
            $RowAdmin = $results->fetch_assoc();
            $adminPass = $RowAdmin['Password'];
            $onetimepassword = $RowAdmin['AdminOTP'];
            $status = 'Suspended';


            $checkUserPhone = "SELECT * FROM transactionsupdate WHERE Phone_No = ? ";
            $email_stmt = $mysqli->prepare($checkUserPhone);
            $email_stmt->bind_param('i', $phone);
            $email_stmt->execute();
            $email_result = $email_stmt->get_result();

            $checkUserPhone2 = "SELECT * FROM profitedge_users WHERE Phone_No = ? ";
            $email_stmt2 = $mysqli->prepare($checkUserPhone2);
            $email_stmt2->bind_param('i', $phone);
            $email_stmt2->execute();
            $email_result2 = $email_stmt2->get_result();



            if ($email_result->num_rows == 1  && password_verify($password, $adminPass) && $OTP == $onetimepassword) {

                $userStatus2 = $email_result2->fetch_assoc();
                $User_Status_Acive = $userStatus2['Status'];

                if ($User_Status_Acive == $status) {
                    $response = "The user '$phone' is currently under suspension!Transaction won't complete";
                } else {

                    //check if it already exists
                    $check = "SELECT * FROM transactionsupdate WHERE Phone_No = ? AND TransactionID = ?";
                    $check_stmt = $mysqli->prepare($check);
                    $check_stmt->bind_param('is', $phone, $transactionID);
                    $check_stmt->execute();
                    $checkResults = $check_stmt->get_result();
                    if ($checkResults->num_rows >= 1) {
                        $response = "The user '$phone' has already been transacted with Ksh. $Amount";
                    } else {
                        // Let's transact the user
                        $transactQuery = "UPDATE transactionsupdate SET Transactor = ?,TransactionID = ?,Amount = ?,Date = ?,Time = ? WHERE Phone_No = ?";
                        $transact_stmt = $mysqli->prepare($transactQuery);
                        $transact_stmt->bind_param('ssissi', $transactor, $transactionID, $Amount, $date, $time, $phone);
                        $transact = $transact_stmt->execute();

                        if ($transact) {
                            $response = "The User '$phone' has been Transacted with Ksh. '$Amount' successfully";
                        } else {
                            $response = "There was an error or user is already Transacted";
                        }
                    }
                }
            } else {
                $response = "Please check Your Credentials!User is Not found or Wrong Password or OTP!";
            }
        } else {
            $response = "No admin account found";
        }


        // Handle the response as a JSON object
        $responseData = array('message' => $response);
        echo json_encode($responseData);
    } else {
        // If the request was not made via AJAX, return a forbidden response
        http_response_code(403);
    }
}
