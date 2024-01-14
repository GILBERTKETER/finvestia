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

        //WE CHECK THE AVAILABILITY OF ANY NUMBER IN THE RECIEVE FROM FIELD IN THE TABLE
        $query = "SELECT * FROM requestedwithdrawals WHERE Email_Address = ? AND User_Name = ? AND Phone_No = ? AND Amount = ?";
        $query_stmt = $mysqli->prepare($query);
        $query_stmt->bind_param('ssii', $userEmail, $username, $userPhone, $userwithdrawamount);
        $query_stmt->execute();
        $query_stmt_res = $query_stmt->get_result();
        if (!(empty($phone))) {

            if ($query_stmt_res->num_rows > 0) {
                //we fetch the value of the recieving account
                $Alldetatils = $query_stmt_res->fetch_assoc();
                $RecieveFrom = $Alldetatils['Recieve_From'];
                if ($RecieveFrom == 0 ||  $RecieveFrom == '' || $RecieveFrom == null) {
                    //we update the table by adding the recieving account;
                    $updateRequests = "UPDATE requestedwithdrawals SET Recieve_From = ? WHERE Email_Address = ? AND User_Name = ? AND Phone_No = ? AND Amount = ?";
                    $updateRequests_stmt = $mysqli->prepare($updateRequests);
                    $updateRequests_stmt->bind_param('issii', $phone, $userEmail, $username, $userPhone, $userwithdrawamount);
                    $updatedRequests = $updateRequests_stmt->execute();
                    if ($updatedRequests) {
                        $response = "Thanks.Now please send the Money to the customer!";
                    } else {
                        $response = "Sorry!We were unable to add a sending account";
                    }
                } else {
                    $response = "The customer has already been assigned a sending account!";
                }
            } else {
                $response = "Sorry! The user Has No withdraw Requests!";
            }
        } else {
            $response = "You Entered Nothing!";
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
