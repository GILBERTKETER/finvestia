<?php
require('./db_conn.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    function sanitize_input($data)
    {
        // Sanitize the data to prevent XSS attacks
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8'); // Use ENT_QUOTES to handle both single and double quotes
        return $data;
    }
    if (isset($_POST['phone4'], $_POST['userEmail4'], $_POST['username4'])) {
        $response = '';
        $phone = sanitize_input($_POST['phone4']);
        $userEmail = sanitize_input($_POST['userEmail4']);
        $username = sanitize_input($_POST['username4']);
        $payto = 0;

        //lets check the payto if it is already assigned
        $checkpayto = "SELECT * FROM transactionsupdate WHERE Email_Address = ? AND User_Name = ? AND PayTo <> ?";
        $checkpayto_stmt = $mysqli->prepare($checkpayto);
        $checkpayto_stmt->bind_param('ssi', $userEmail, $username, $payto);
        $checkpayto_stmt->execute();
        $checkpayto_stmt_res = $checkpayto_stmt->get_result();
        if ($checkpayto_stmt_res->num_rows > 0) {
            $response = "Sorry!The Number has been issued to this User!";
        } else {
            if (!(empty($phone))) {
                //we will update the transactionupdates table
                $updateTransaction1 = "UPDATE transactionsupdate SET PayTo = ? WHERE Email_Address = ? AND User_Name = ?";
                $updateTransaction_stmt = $mysqli->prepare($updateTransaction1);
                $updateTransaction_stmt->bind_param('iss', $phone, $userEmail, $username);
                $updatedTransac = $updateTransaction_stmt->execute();
                if ($updatedTransac) {
                    $response = "Great!Phone Number Issued,Wait for payments.From $userEmail";
                } else {
                    $response = "Sorry!We are unable to issue the Phone Number";
                }
            } else {
                $response = "You Entered Nothing!";
            }
        }

        // Do something with the data (e.g., insert into database)

        $responseData = array('message' => $response);
        echo json_encode($responseData);
    } else {
        $response = array('success' => false, 'message' => 'Missing or invalid data.');
        echo json_encode($response);
    }
} else {
    $response = array('success' => false, 'message' => 'Invalid request.');
    echo json_encode($response);
}
