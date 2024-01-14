<?php
session_start();
require('./db_conn.php');
$user = $_SESSION['LOGGED_IN_USERNAME'];
$email = $_SESSION['LOGGED_IN_EMAIL'];
$phone = $_SESSION['LOGGED_IN_PHONE'];
$response = '';
function sanitize_input($data)
{
    // Sanitize the data to prevent XSS attacks
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8'); // Use ENT_QUOTES to handle both single and double quotes
    return $data;
}

//this is to check if there is a transaction ongoing
$runningTransaction = "SELECT * FROM requestedwithdrawals WHERE Email_Address = ? AND User_Name = ?";
$runningTransaction_stmt = $mysqli->prepare($runningTransaction);
$runningTransaction_stmt->bind_param('ss', $email, $user);
$runningTransaction_stmt->execute();
$runningTransaction_stmt_result = $runningTransaction_stmt->get_result();
if ($runningTransaction_stmt_result->num_rows > 0) {
    $runningTransaction_stmt_result2 = $runningTransaction_stmt_result->fetch_assoc();

    $RecieveFrom = $runningTransaction_stmt_result2['Recieve_From'];
    $TransactionID = $runningTransaction_stmt_result2['TransactionID'];
} else {
    $RecieveFrom = 0;
    $TransactionID = 0;
}
//then if there is a traansaction to be confirmed

$accountBalanceQuery = "SELECT * FROM balance_account_users_profitedge WHERE Email_Address = ? AND User_Name = ?";
$accountBalanceQuery_stmt = $mysqli->prepare($accountBalanceQuery);
$accountBalanceQuery_stmt->bind_param('ss', $email, $user);
$accountBalanceQuery_stmt->execute();
$accountBalanceQuery_stmt_res = $accountBalanceQuery_stmt->get_result();
$UserAccount = $accountBalanceQuery_stmt_res->fetch_assoc();
$AccountBalance = $UserAccount['Balance_Available'];

//refferals count check
$refferalsCheck = "SELECT COUNT(*) AS MYREFFERALSTODAY FROM profitedge_users WHERE Refferer = ?";
$refferalsCheck_stmt = $mysqli->prepare($refferalsCheck);
$refferalsCheck_stmt->bind_param('s', $user);
$refferalsCheck_stmt->execute();
$refferalsCheck_stmt_res = $refferalsCheck_stmt->get_result();
$Row_refferalsCheck = $refferalsCheck_stmt_res->fetch_assoc();
$TotalRefferals = $Row_refferalsCheck['MYREFFERALSTODAY'];
// echo "total refferals $TotalRefferals";
$minimumRefferals = 2;
$minInvestedReferrals = 2;

$investedReferralsQuery = "SELECT COUNT(DISTINCT User_Name) AS investedReferralCount
                               FROM investments
                               WHERE User_Name IN (
                                   SELECT User_Name FROM profitedge_users WHERE Refferer = ?
                               )";
$investedReferralsStmt = $mysqli->prepare($investedReferralsQuery);
$investedReferralsStmt->bind_param('s', $user);
$investedReferralsStmt->execute();
$investedReferralsResult = $investedReferralsStmt->get_result();
$row = $investedReferralsResult->fetch_assoc();
$investedReferralCount = $row['investedReferralCount'];
// echo "refferals invested: $investedReferralCount";

if (isset($_POST['requestWithdraw'])) {
    $withdrawalAmount = sanitize_input($_POST['withdrawal']);
    //lets check i the value is zero
    if ($withdrawalAmount == 0 || $withdrawalAmount == '' || $withdrawalAmount == null) {
        $response = "The amount should be greater than zero and should not be empty!";
    } else if ($withdrawalAmount > $AccountBalance) {
        $response = "Insufficient Funds in Your Wallet!";
    } elseif ($withdrawalAmount < 2500) {
        $response = "Beneath minimum withdrawal amount of Ksh. 2,500!";
    } elseif ($TotalRefferals < $minimumRefferals) {
        $response = "You need two or more refferals for a successfull withdrawal request!";
    } elseif ($investedReferralCount  < $minInvestedReferrals) {
        $response = "Make Sure atleats two of Your Refferals have atleast invested once!";
    } elseif ($runningTransaction_stmt_result->num_rows > 0 && empty($RecieveFrom) || $runningTransaction_stmt_result->num_rows > 0 &&  $RecieveFrom == 0 ||  $runningTransaction_stmt_result->num_rows > 0 &&  $TransactionID == '' || $runningTransaction_stmt_result->num_rows > 0 &&  $TransactionID == null || $runningTransaction_stmt_result->num_rows > 0 &&  $RecieveFrom == 0 && $TransactionID == '') {
        $response = "Sorry!There is an ongoing Withdrawal Request!Please Wait!";
    } elseif ($TransactionID != '' && $RecieveFrom != 0) {
        $response = "Sorry!You have a withdrawal transaction to confirm!";
    } else {
        //we insert to the requested withdrawals
        $InsertToRequestedWithdrawals = "INSERT INTO requestedwithdrawals (Email_Address,User_Name,Phone_No,Amount) VALUES(?,?,?,?)";
        $InsertToRequestedWithdrawals_stmt = $mysqli->prepare($InsertToRequestedWithdrawals);
        $InsertToRequestedWithdrawals_stmt->bind_param('ssii', $email, $user, $phone, $withdrawalAmount);
        $inserted = $InsertToRequestedWithdrawals_stmt->execute();
        if ($inserted) {
            $response = "Thanks for your Request. Wait for your Payments!";
        } else {
            $response = "Sorry!There was an Error on our End!";
        }
    }



    // Handle the response as a JSON object
    $responseData = array('message' => $response);
    echo json_encode($responseData);
} else {
    // If the request was not made via AJAX, return a forbidden response
    http_response_code(403);
}
