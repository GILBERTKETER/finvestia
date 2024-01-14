<?php
// ... (previous code)

// ACCOUNT BALANCE CALCULATION
$email = $_SESSION['LOGGED_IN_EMAIL'];
$userName = $_SESSION['LOGGED_IN_USERNAME'];

// DEPOSITS MADE
$deposits_made = "SELECT SUM(Amount) AS DEPOSITS FROM deposits WHERE Email_Address = ?";
$deposits_stmt = $mysqli->prepare($deposits_made);
$deposits_stmt->bind_param('s', $email);
$deposits_stmt->execute();
$resulting_Deposits = $deposits_stmt->get_result()->fetch_assoc();
$Total_Deposits = intval($resulting_Deposits['DEPOSITS']);

// REFERRAL EARNINGS
// $refferal_Earnings = "SELECT COUNT(*) AS MYREFFERALS FROM profitedge_users WHERE Refferer = ?";
$refferal_Earnings = "SELECT COUNT(*) AS MYREFFERALS FROM profitedge_users AS refferer JOIN profitedge_users AS reffered_users ON refferer.User_Name = reffered_users.Refferer JOIN investments ON reffered_users.User_Name = investments.User_Name WHERE refferer.User_Name = ?";
$refferal_stmt = $mysqli->prepare($refferal_Earnings);
$refferal_stmt->bind_param('s', $userName);
$refferal_stmt->execute();
$refferalEarningsResult = $refferal_stmt->get_result()->fetch_assoc();
$Total_Refferals = intval($refferalEarningsResult['MYREFFERALS']);
$Refferal_Earns = $Total_Refferals * 50;

// APPROVED INVESTMENTS
$status = 'Approved';
$investments_approved = "SELECT SUM(Total_Amount_To_Earn) AS APPROVEDINVESTMENTS FROM investments WHERE Email_Address = ? AND Status = ?";
$stmt_investments = $mysqli->prepare($investments_approved);
$stmt_investments->bind_param('ss', $email, $status);
$stmt_investments->execute();
$resulting_investments = $stmt_investments->get_result()->fetch_assoc();
$Approved_investments = intval($resulting_investments['APPROVEDINVESTMENTS']);

// PROCESSING INVESTMENTS
$status2 = 'processing';
$investments_approved1 = "SELECT SUM(Amount) AS PROCESSINGINVESTMENTS FROM investments WHERE Email_Address = ? AND Status = ?";
$stmt_investments1 = $mysqli->prepare($investments_approved1);
$stmt_investments1->bind_param('ss', $email, $status2);
$stmt_investments1->execute();
$resulting_investments1 = $stmt_investments1->get_result()->fetch_assoc();
$Approved_investments1 = intval($resulting_investments1['PROCESSINGINVESTMENTS']);

// APPROVED WITHDRAWALS
$withdrawals_approved = "SELECT SUM(Amount) AS WITHDRAWN FROM withdrawals WHERE Email_Address = ?";
$stmt_withdrawals = $mysqli->prepare($withdrawals_approved);
$stmt_withdrawals->bind_param('s', $email);
$stmt_withdrawals->execute();
$resultingWithdrawals = $stmt_withdrawals->get_result()->fetch_assoc();
$Approved_Withdrawals = intval($resultingWithdrawals['WITHDRAWN']);

$ACCOUNTBALANCEAVAILABLE = ($Total_Deposits + $Refferal_Earns + $Approved_investments) - ($Approved_Withdrawals + $Approved_investments1); //also subtract investments in processing stage


//update everytime the account balance when user logs in
$update_my_account = "UPDATE balance_account_users_profitedge SET Balance_Available = ? WHERE Email_Address = ?";
$UPDATE_MY_ACCOUT_STMT = $mysqli->prepare($update_my_account);
$UPDATE_MY_ACCOUT_STMT->bind_param('is', $ACCOUNTBALANCEAVAILABLE, $email);
$UPDATE_MY_ACCOUT_STMT->execute();
