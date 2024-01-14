<?php
session_start();
require('./db_conn.php');
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {

    $response = '';
    function sanitize_input($data)
    {
        // Sanitize the data to prevent XSS attacks
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8'); // Use ENT_QUOTES to handle both single and double quotes
        return $data;
    }
    if (isset($_POST['recievedButton'])) {
        $email = $_SESSION['LOGGED_IN_EMAIL'];
        $user = $_SESSION['LOGGED_IN_USERNAME'];
        $phone  = $_SESSION['LOGGED_IN_PHONE'];
        $withdrawalID = sanitize_input($_POST['withdrawalID']);
        $PhoneRecievedFrom = sanitize_input($_POST['recievedfrom']);
        $withdrawalamount = sanitize_input($_POST['withdrawalamount']);
        $withdrawalDate = sanitize_input($_POST['withdrawalDate1']);
        $withdrawalTime = sanitize_input($_POST['withdrawaltime1']);
        $Password = sanitize_input($_POST['password1']);

        //check the password
        $extractPassword = "SELECT Password FROM profitedge_users WHERE Email_Address = ? AND User_Name = ?";
        $extractPassword_stmt = $mysqli->prepare($extractPassword);
        $extractPassword_stmt->bind_param('ss', $email, $user);
        $extractPassword_stmt->execute();
        $extractPassword_stmt_result = $extractPassword_stmt->get_result()->fetch_assoc();
        $realPassword = $extractPassword_stmt_result['Password'];
        if (password_verify($Password, $realPassword)) {
            //we check if the user has done a request
            $transIDQuery = "SELECT * FROM requestedwithdrawals WHERE Email_Address = ? AND User_Name = ?";
            $transIDQuery_stmt = $mysqli->prepare($transIDQuery);
            $transIDQuery_stmt->bind_param('ss', $email, $user);
            $transIDQuery_stmt->execute();
            $transIDQuery_stmt_result = $transIDQuery_stmt->get_result();
            if ($transIDQuery_stmt_result->num_rows > 0) {
                $transIDQuery_stmt_result_fetched = $transIDQuery_stmt_result->fetch_assoc();
                //we check if the transaction id exists
                $transactionIdInTable = $transIDQuery_stmt_result_fetched['TransactionID'];
                if ($transactionIdInTable != '') {
                    if ($transactionIdInTable == $withdrawalID) {
                        //check if the phone number exists
                        $phoneInTable = $transIDQuery_stmt_result_fetched['Recieve_From'];
                        if ($phoneInTable == $PhoneRecievedFrom) {
                            //check the amount recieved
                            $amountinTable = $transIDQuery_stmt_result_fetched['Amount'];
                            if ($amountinTable == $withdrawalamount) {
                                //check the date and time
                                $dateinTable = $transIDQuery_stmt_result_fetched['Date'];
                                $timeInTable = $transIDQuery_stmt_result_fetched['Time'];
                                if ($dateinTable == $withdrawalDate) {
                                    $transactor = $transIDQuery_stmt_result_fetched['Transactor'];
                                    //we then insert the data to the withdrawals table and remove it from the withdrawalsrequest table
                                    $insertToWithdrawals_query = "INSERT INTO  withdrawals(Email_Address,User_Name,Phone_No,TransactionID,Transactor,Amount,Date) VALUES(?,?,?,?,?,?,?)";
                                    $insertToWithdrawals_query_stmt = $mysqli->prepare($insertToWithdrawals_query);
                                    $insertToWithdrawals_query_stmt->bind_param('ssissis', $email, $user, $phone, $transactionIdInTable, $transactor,$amountinTable, $dateinTable);
                                    $inserted = $insertToWithdrawals_query_stmt->execute();

                                    $deletefromRequests = "DELETE FROM requestedwithdrawals WHERE Email_Address = ? AND User_Name = ?";
                                    $deletefromRequests_stmt = $mysqli->prepare($deletefromRequests);
                                    $deletefromRequests_stmt->bind_param('ss', $email, $user);
                                    $deleted = $deletefromRequests_stmt->execute();

                                    if($inserted && $deleted){
                                        $response = "Congratulations.You Recieved The Money!";

                                    }else{
                                        $response = "Our Bad!Server Failed";
                                    }

                                } else {
                                    $response = "Incorrect Time or Date!";
                                }
                            } else {
                                $response = "You did not recieved that Amount!";
                            }
                        } else {
                            $response = "Appologies! You did'nt recieved money from the Number!";
                        }
                    } else {
                        $response = "Sorry!Incorrect Transaction ID";
                    }
                } else {
                    $response = "Please Recieve your money first!";
                }
            } else {
                $response = "Please Request a withdrawal first!";
            }
        } else {
            $response = "Sorry!Incorrect Password!";
        }

        // Handle the response as a JSON object
        $responseData = array('message' => $response);
        echo json_encode($responseData);
    } else {
        // If the request was not made via AJAX, return a forbidden response
        http_response_code(403);
    }
}
