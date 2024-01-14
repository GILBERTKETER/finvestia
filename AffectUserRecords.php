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

    if (isset($_POST['updateBasics'])) {
        $response = '';
        if (isset($_POST['UserStatus']) && isset($_POST['UserAccType'])) {
            $userstatus = sanitize_input($_POST['UserStatus']);
            $userType = sanitize_input($_POST['UserAccType']);
            $useremail = sanitize_input($_POST['useremail']);
            $username = sanitize_input($_POST['username']);

            //we check the records in the db first
            $check = "SELECT * FROM profitedge_users WHERE Email_Address = ?  AND User_Name = ?";
            $check_stmt = $mysqli->prepare($check);
            $check_stmt->bind_param('ss', $useremail, $username);
            $check_stmt->execute();
            $check_stmt_res = $check_stmt->get_result();
            if ($check_stmt_res->num_rows == 1) {
                $check_stmt_result = $check_stmt_res->fetch_assoc();
                $currentUserType = $check_stmt_result['Joiner_Account_Type'];
                $currentUserstatus = $check_stmt_result['Status'];

                if ($currentUserstatus != $userstatus && $currentUserType == $userType || $currentUserstatus == $userstatus && $currentUserType != $userType || $currentUserstatus != $userstatus && $currentUserType != $userType) {
                    //we update  the respective table
                    $updateProfitedge = "UPDATE profitedge_users SET Joiner_Account_Type = ?, Status = ? WHERE Email_Address = ? AND User_Name = ?";
                    $updateProfitedge_stmt = $mysqli->prepare($updateProfitedge);
                    $updateProfitedge_stmt->bind_param('ssss', $userType, $userstatus, $useremail, $username);
                    $updatedProfitedge = $updateProfitedge_stmt->execute();
                    if ($updatedProfitedge) {
                        $response = "Success!The record is Updated";
                    } else {
                        $response = "Appologies!We can't update the record at the moment!";
                    }
                } else {
                    $response = "Hey!You did not make any change!";
                }
            } else {
                $response = "Sorry!Make sure the field Exists!";
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
