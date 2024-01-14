<?php
require('./db_conn.php');
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
    if (isset($_POST['suspendUser'])) {
        $email = sanitize_input($_POST['email']);
        $username = sanitize_input($_POST['username']);
        $password = sanitize_input($_POST['pass']);
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
            $status = 'Suspended';

            $checkTheUserEmail = "SELECT * FROM profitedge_users WHERE Email_Address = ? AND User_Name = ?";
            $email_stmt = $mysqli->prepare($checkTheUserEmail);
            $email_stmt->bind_param('ss', $email, $username);
            $email_stmt->execute();
            $email_result = $email_stmt->get_result();

            if ($email_result->num_rows == 1  && password_verify($password, $adminPass)) {
                // Let's suspend the user
                $suspendQuery = "UPDATE profitedge_users SET Status = ? WHERE Email_Address = ? AND User_Name = ?";
                $suspend_stmt = $mysqli->prepare($suspendQuery);
                $suspend_stmt->bind_param('sss', $status, $email, $username);
                $suspended = $suspend_stmt->execute();

                if ($suspended) {
                    $response = "The User '$username' has been suspended";
                } else {
                    $response = "There was an error or user is already suspended";
                }
            } else {
                $response = "Please check Your Credentials!";
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
