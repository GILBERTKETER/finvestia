<?php
session_start();
require('./db_conn.php');
$email = $_SESSION['LOGGED_IN_EMAIL'];
$username = $_SESSION['LOGGED_IN_USERNAME'];
$phoneNumber = $_SESSION['LOGGED_IN_PHONE'];

function sanitize_input($data)
{
    // Sanitize the data to prevent XSS attacks
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8'); // Use ENT_QUOTES to handle both single and double quotes
    return $data;
}
// Check if the request was made via AJAX
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    // Check if the required fields are present in the POST data
    if (isset($_POST['transactBtn2'])) {
        $transactionID = sanitize_input($_POST['transactionID']);
        $phone = sanitize_input($_POST['phone']);
        $Amount = sanitize_input($_POST['amount']);
        $password = sanitize_input($_POST['pass']);
        $date = sanitize_input($_POST['date']);
        $response = '';
        $AccountType = 'finVestAdminLoggedInAccept';

        $User_Credentials = "SELECT * FROM profitedge_users WHERE Email_Address = ?";
        $user_stmt = $mysqli->prepare($User_Credentials);
        $user_stmt->bind_param('s', $email);
        $user_stmt->execute();
        $user_result = $user_stmt->get_result();
        if ($user_result->num_rows > 0) {
            //lets check the password
            $rowUser = $user_result->fetch_assoc();
            $RealUserPwd = $rowUser['Password'];
            if (password_verify($password, $RealUserPwd)) {

                //lets check the transactions table
                $transactions = "SELECT * FROM deposits WHERE Phone_No = ? AND Amount = ? AND TransactionID = ? AND Date = ?";
                $transaction_stmt2 = $mysqli->prepare($transactions);
                $transaction_stmt2->bind_param('iiss', $phone, $Amount, $transactionID, $date);
                $transaction_stmt2->execute();
                $transaction_result2 = $transaction_stmt2->get_result();

                if ($transaction_result2->num_rows == 0) {

                    if ($phone != $phoneNumber) {
                        $response = "The Transaction was not ment for this Account.If the deposi is yours,first change your number.";
                    } else {
                        //check credentials in the transaction table
                        $credentials = "SELECT * FROM transactionsupdate WHERE Email_Address = ? AND User_Name = ?";
                        $credentials_stmt = $mysqli->prepare($credentials);
                        $credentials_stmt->bind_param('ss', $email, $username);
                        $credentials_stmt->execute();
                        $credentialsResults = $credentials_stmt->get_result();
                        $rowCredentials = $credentialsResults->fetch_assoc();
                        $paidAmount = $rowCredentials['Amount'];
                        $datePaid = $rowCredentials['Date'];
                        $transactorname = $rowCredentials['Transactor'];

                        if ($paidAmount == $Amount && $date == $datePaid) {



                            //we also insert to deposits
                            $deposits_insert = "INSERT INTO deposits (Email_Address,User_Name,Phone_No,TransactionID,Transactor,Amount,Date) VALUES(?,?,?,?,?,?,?)";
                            $deposits_stmt = $mysqli->prepare($deposits_insert);
                            $deposits_stmt->bind_param('ssissis', $email, $username, $phone, $transactionID, $transactorname, $Amount, $date);
                            $updatedDeposits = $deposits_stmt->execute();

                            $updateTransactions = "DELETE FROM transactionsupdate WHERE Email_Address = ?";
                            $updateTransaction_stmt = $mysqli->prepare($updateTransactions);
                            $updateTransaction_stmt->bind_param('s', $email);
                            $updatedTransactions = $updateTransaction_stmt->execute();

                            if ($updatedTransactions && $updatedDeposits) {
                                $response = "Your Transactions is confirmed succesfully.Proceed to investment!";
                            } else {
                                $response = "There was an error(anonymous).Please review the your details again.";
                            }
                        } else {
                            $response = "Sorry!Please Check Your Phone No or Date paid!";
                        }
                    }
                } else {
                    $response = "You already made the confirmation!";
                }
            } else {
                $response = "Incorrect Password Used!";
            }
        } else {
            $response = "No record";
        }




        // Handle the response as a JSON object
        $responseData = array('message' => $response);
        echo json_encode($responseData);
    } else {
        // If the request was not made via AJAX, return a forbidden response
        http_response_code(403);
    }
}
