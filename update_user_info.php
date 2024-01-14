<?php
require('./db_conn.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    if (isset($_POST['userEmail'], $_POST['username'])) {
          
function sanitize_input($data)
{
    // Sanitize the data to prevent XSS attacks
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8'); // Use ENT_QUOTES to handle both single and double quotes
    return $data;
}
        // Extract data from POST
        $userEmail = sanitize_input($_POST['userEmail']);
        $username = sanitize_input($_POST['username']);

        $userBasicInfo = "SELECT * FROM profitedge_users WHERE Email_Address = ?  AND User_Name = ?";
        $userBasicInfo_stmt = $mysqli->prepare($userBasicInfo);
        $userBasicInfo_stmt->bind_param('ss', $userEmail, $username);
        $userBasicInfo_stmt->execute();
        $userBasicInfo_stmt_res = $userBasicInfo_stmt->get_result();

        if ($userBasicInfo_stmt_res->num_rows == 1) {
            $userBasicInfo_stmt_res_row = $userBasicInfo_stmt_res->fetch_assoc();
            $USERNAME = $userBasicInfo_stmt_res_row['User_Name'];
            $USERPHONENUMBER = $userBasicInfo_stmt_res_row['Phone_No'];
            $USERACCOUNTSTATUS = $userBasicInfo_stmt_res_row['Status'];
            $USERACCOUNTTYPE = $userBasicInfo_stmt_res_row['Joiner_Account_Type'];

            //lets fetch the one for acccount balance
            $accountQuery = "SELECT * FROM balance_account_users_profitedge WHERE Email_Address = ? AND User_Name = ?";
            $accountQuery_stmt = $mysqli->prepare($accountQuery);
            $accountQuery_stmt->bind_param('ss', $userEmail, $username);
            $accountQuery_stmt->execute();
            $accountQuery_stmt_res = $accountQuery_stmt->get_result()->fetch_assoc();
            $USERACCOUNTBALANCE = $accountQuery_stmt_res['Balance_Available'];

            //lets fetch the one for user plan
            $packageQuery = "SELECT * FROM set_plan WHERE Email_Address = ? AND User_Name = ?";
            $packageQuery_stmt = $mysqli->prepare($packageQuery);
            $packageQuery_stmt->bind_param('ss', $userEmail, $username);
            $packageQuery_stmt->execute();
            $packageQuery_stmt_res = $packageQuery_stmt->get_result()->fetch_assoc();
            $USERPACKAGE = $packageQuery_stmt_res['Package'];

            //lets fetch the one for requested withdrawals
            $withdrawQuery = "SELECT * FROM requestedwithdrawals WHERE Email_Address = ? AND User_Name = ?";
            $withdrawQuery_stmt = $mysqli->prepare($withdrawQuery);
            $withdrawQuery_stmt->bind_param('ss', $userEmail, $username);
            $withdrawQuery_stmt->execute();
            $withdrawQuery_stmt_r = $withdrawQuery_stmt->get_result();
            if ($withdrawQuery_stmt_r->num_rows > 0) {

                $withdrawQuery_stmt_res = $withdrawQuery_stmt_r->fetch_assoc();
                $USERWITHDRAWAMOUNT = $withdrawQuery_stmt_res['Amount'];
                $USERRECIEVEFROM = $withdrawQuery_stmt_res['Recieve_From'];
                $USERWITHDRAWMPESAID = $withdrawQuery_stmt_res['TransactionID'];
                $USERWITHDRAWDATE = $withdrawQuery_stmt_res['Date'];
            } else {
                $USERWITHDRAWAMOUNT = 0;
                $USERRECIEVEFROM = 0;
                $USERWITHDRAWMPESAID = "none";
                $USERWITHDRAWDATE = 'none';
            }



            //lets fetch the one for requested deposits
            $DEPOSITQuery = "SELECT * FROM transactionsupdate WHERE Email_Address = ? AND User_Name = ?";
            $DEPOSITQuery_stmt = $mysqli->prepare($DEPOSITQuery);
            $DEPOSITQuery_stmt->bind_param('ss', $userEmail, $username);
            $DEPOSITQuery_stmt->execute();
            $DEPOSITQuery_stmt_r = $DEPOSITQuery_stmt->get_result();
            if ($DEPOSITQuery_stmt_r->num_rows > 0) {

                $DEPOSITQuery_stmt_res = $DEPOSITQuery_stmt_r->fetch_assoc();
                $USERDEPOSITAMOUNT = $DEPOSITQuery_stmt_res['Amount'];
                $USERPAYTO = $DEPOSITQuery_stmt_res['PayTo'];
                $USERDEPOSITMPESAID = $DEPOSITQuery_stmt_res['TransactionID'];
                $USERTRANSACTOR = $DEPOSITQuery_stmt_res['Transactor'];
                $USERPHONESENDINGACC = $DEPOSITQuery_stmt_res['Phone_No'];
                //where i recieve money
            } else {
                $USERDEPOSITAMOUNT = 0;
                $USERPAYTO = 0;
                $USERPHONESENDINGACC = 0;
                $USERDEPOSITMPESAID = "none";
                $USERTRANSACTOR = 'none';
            }





            $responseData = array(
                'success' => true,
                'updatedEmailValue' => $userEmail,
                'updatedPhoneValue' => $USERPHONENUMBER,
                'updatedStatusValue' => $USERACCOUNTSTATUS,
                'updatedAccountValue' => $USERACCOUNTTYPE,
                'updatedUserNameValue' => $USERNAME,
                'updatedUserAccountBalanceValue' => $USERACCOUNTBALANCE,
                'updatedUserPackageValue' => $USERPACKAGE,

                'updatedUserWithdrawamountValue' => $USERWITHDRAWAMOUNT,
                'updateUserRecievefromValue' => $USERRECIEVEFROM,
                'updateUserWithdrawIdValue' => $USERWITHDRAWMPESAID,
                'updateUserWithdrawdateValue' => $USERWITHDRAWDATE,

                'updateUserToPayTo' => $USERPAYTO,
                'updatedUserdepositAmount' => $USERDEPOSITAMOUNT,
                'updateUserSendingAcc' => $USERPHONESENDINGACC,
                'updateUserwithdrawMpesaid' => $USERDEPOSITMPESAID,
                'updateUserTransactor' => $USERTRANSACTOR



            );
        } else {
            $response = array('success' => false, 'message' => 'User not found or other error.');
            echo json_encode($response);
        }

        // Set the response header to indicate JSON content
        header('Content-Type: application/json');

        // Echo the JSON-encoded response
        echo json_encode($responseData);
    } else {
        $response = array('success' => false, 'message' => 'Missing or invalid data.');
        echo json_encode($response);
    }
} else {
    $response = array('success' => false, 'message' => 'Invalid request.');
    echo json_encode($response);
}
