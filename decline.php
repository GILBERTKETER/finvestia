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
    if (isset($_POST['phone'], $_POST['userEmail'], $_POST['username'], $_POST['userphone'], $_POST['userwithdrawamount'])) {
        $response = '';
        $phone = sanitize_input($_POST['phone']);
        $userEmail = sanitize_input($_POST['userEmail']);
        $username = sanitize_input($_POST['username']);
        $userPhone = sanitize_input($_POST['userphone']);
        $userwithdrawamount = sanitize_input($_POST['userwithdrawamount']);



        $deletewithdrawal = "DELETE FROM requestedwithdrawals WHERE Email_Address = ? AND User_Name = ?";
        $deletewithdrawal_stmt = $mysqli->prepare($deletewithdrawal);
        $deletewithdrawal_stmt->bind_param('ss', $userEmail, $username);
        $deleted = $deletewithdrawal_stmt->execute();
        if ($deleted) {
            $response = "The withdrawal is successfully Declined!";
        } else {
            $response = "Sorry!There was an error!";
        }




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
