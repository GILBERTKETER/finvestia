<?php
session_start();
require('./db_conn.php');

$email = $_SESSION['LOGGED_IN_EMAIL'];
$phone = $_SESSION['LOGGED_IN_PHONE'];
$userName = $_SESSION['LOGGED_IN_USERNAME'];
$statusinvest = 'processing';

function sanitize_input($data)
{
    // Sanitize the data to prevent XSS attacks
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8'); // Use ENT_QUOTES to handle both single and double quotes
    return $data;
}

$acount = "SELECT * FROM balance_account_users_profitedge WHERE Email_Address = ? AND User_Name = ?";
$acount_stmt = $mysqli->prepare($acount);
$acount_stmt->bind_param('ss', $email, $userName);
$acount_stmt->execute();
$acount_stmt_result = $acount_stmt->get_result();
$row_accbalance = $acount_stmt_result->fetch_assoc();
$AccountBalance = $row_accbalance['Balance_Available'];

if (isset($_POST['investGoldNow'])) {


    $status = '';
    $dateInvested = '';
    $DateToEnd = '';

    $amount = sanitize_input($_POST['gold_amount']);
    $package = sanitize_input($_POST['gold_package']);
    $selectDays = sanitize_input($_POST['gold_selectDays']);
    $accumulative = sanitize_input($_POST['gold_accumulative']);



    if ($AccountBalance >= $amount) {
        $currentDateTime = date('Y-m-d H:i:s');
        $endDate = date('Y-m-d H:i:s', strtotime($currentDateTime . ' + ' . $selectDays . ' days'));
        $Total_Amount_To_Earn = intval($amount + $accumulative);

        // Get the current date and time
        // Calculate the end date by adding the selected number of days to the start date

        // Insert the investment details into the database
        $insertGoldInvestment = "INSERT INTO investments(Email_Address,User_Name,Phone_No,Amount,Days,Accumulative_Amount,Total_Amount_To_Earn,Package,End_Date,Status) VALUES(?,?,?,?,?,?,?,?,?,?);";
        $invested = "INSERT INTO invested_amount(Email_Address,Phone_No,Amount,Date_invested) VALUES(?,?,?,?);";
        
        $stmt88 = $mysqli->prepare($invested);
        $stmt88->bind_param('siis', $email, $phone, $amount, $currentDateTime);
        $stmt88->execute();

        $stmt = $mysqli->prepare($insertGoldInvestment);
        $stmt->bind_param('ssiiiiisss', $email, $userName, $phone, $amount, $selectDays, $accumulative, $Total_Amount_To_Earn, $package, $endDate,$statusinvest);

        $stmt->execute();
        echo "Congratulations! Gold Investment Success.";
    } else {
        echo "Insufficient funds in your Wallet!";
    }
}
if (isset($_POST['investSilver'])) {
    $status = '';
    $dateInvested = '';
    $DateToEnd = '';

    $amount = sanitize_input($_POST['silver_amount']);
    $package = sanitize_input($_POST['silver_package']);
    $selectDays = sanitize_input($_POST['silver_selectDays']);
    $accumulative = sanitize_input($_POST['silver_accumulative']);

    if ($AccountBalance >= $amount) {
        $currentDateTime = date('Y-m-d H:i:s');
        $endDate = date('Y-m-d H:i:s', strtotime($currentDateTime . ' + ' . $selectDays . ' days'));
        $Total_Amount_To_Earn = intval($amount + $accumulative);


        // Get the current date and time
        // Calculate the end date by adding the selected number of days to the start date


        // Insert the investment details into the database
         $invested = "INSERT INTO invested_amount(Email_Address,Phone_No,Amount,Date_invested) VALUES(?,?,?,?);";
        
        $stmt88 = $mysqli->prepare($invested);
        $stmt88->bind_param('siis', $email, $phone, $amount, $currentDateTime);
        $stmt88->execute();
        
        $insertsilverInvestment = "INSERT INTO investments(Email_Address,User_Name,Phone_No,Amount,Days,Accumulative_Amount,Total_Amount_To_Earn,Package,End_Date,Status) VALUES(?,?,?,?,?,?,?,?,?,?);";

        $stmt = $mysqli->prepare($insertsilverInvestment);
        $stmt->bind_param('ssiiiiisss', $email, $userName, $phone, $amount, $selectDays, $accumulative, $Total_Amount_To_Earn, $package, $endDate,$statusinvest);

        $stmt->execute();
        echo "Congratulations! Silver Investment Success.";
    } else {
        echo "Insufficient Funds in your Wallet!";
    }
}


if (isset($_POST['investBronze'])) {
    $status = '';
    $dateInvested = '';
    $DateToEnd = '';

    $amount = sanitize_input($_POST['bronze_amount']);
    $package = sanitize_input($_POST['bronze_package']);
    $selectDays = sanitize_input($_POST['bronze_selectDays']);
    $accumulative = sanitize_input($_POST['bronze_accumulative']);

    if ($AccountBalance >= $amount) {
        $currentDateTime = date('Y-m-d H:i:s');
        $endDate = date('Y-m-d H:i:s', strtotime($currentDateTime . ' + ' . $selectDays . ' days'));
        $Total_Amount_To_Earn = intval($amount + $accumulative);

        // Get the current date and time
        // Calculate the end date by adding the selected number of days to the start date


        // Insert the investment details into the database
         $invested = "INSERT INTO invested_amount(Email_Address,Phone_No,Amount,Date_invested) VALUES(?,?,?,?);";
        
        $stmt88 = $mysqli->prepare($invested);
        $stmt88->bind_param('siis', $email, $phone, $amount, $currentDateTime);
        $stmt88->execute();
        
        $insertBronzeInvestment = "INSERT INTO investments(Email_Address,User_Name,Phone_No,Amount,Days,Accumulative_Amount,Total_Amount_To_Earn,Package,End_Date,Status) VALUES(?,?,?,?,?,?,?,?,?,?);";

        $stmt = $mysqli->prepare($insertBronzeInvestment);
        $stmt->bind_param('ssiiiiisss', $email, $userName, $phone, $amount, $selectDays, $accumulative, $Total_Amount_To_Earn, $package, $endDate,$statusinvest);

        $stmt->execute();
        echo "Congratulations! Bronze Investment Success.";
    } else {
        echo "Insufficient Funds in Your Wallet!";
    }
}
