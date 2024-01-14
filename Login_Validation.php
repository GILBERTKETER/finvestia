<?php
session_start();
// require the database connection file
require('./db_conn.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the form data and sanitize inputs
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['pass'];

    $usernameLoggedIn = '';
    $emailLoggedIn = '';
    $phoneNoLoggedIn = '';
    $accounttype = '';
    // Perform your login validation here, check credentials against the database
    $sql = "SELECT * FROM profitedge_users WHERE Email_Address = ?";
    $user_sql = "SELECT User_Name FROM profitedge_users WHERE Email_Address = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Fetch the hashed password from the database
        $row = $result->fetch_assoc();
        $hashed_password = $row['Password'];
        $userStatus = $row['Status'];


        // Verify the password using password_verify()
        if (password_verify($password, $hashed_password) && $userStatus == 'Active') {

            // Login successful
            $allInfo = "SELECT * FROM profitedge_users WHERE Email_Address = ?";
            $stmt3 = $mysqli->prepare($allInfo);
            $stmt3->bind_param("s", $email);
            $stmt3->execute();
            $result2 = $stmt3->get_result();
            if ($result2->num_rows === 1) {
                $rowAllInfo = $result2->fetch_assoc();

                $usernameLoggedIn = $rowAllInfo['User_Name'];
                $emailLoggedIn = $rowAllInfo['Email_Address'];
                $phoneNoLoggedIn = $rowAllInfo['Phone_No'];
                $accounttype = $rowAllInfo['Joiner_Account_Type'];
                $verification = $rowAllInfo['Verified'];
            }
            $_SESSION['LOGGED_IN_EMAIL'] = $emailLoggedIn;
            $_SESSION['LOGGED_IN_USERNAME'] = $usernameLoggedIn;
            $_SESSION['LOGGED_IN_PHONE'] = $phoneNoLoggedIn;
            $_SESSION['LOGGED_IN_ACCTYPE'] = $accounttype;
            $veri = 1;
            $unvery = 0;

            if ($accounttype == 'user_account_type_joiner' && $verification == $veri) {
                header("Location:./home.php");
            } else if ($accounttype == 'finVestAdminLoggedInAccept') {
                header("Location:./admin.php");
            } elseif ($verification == $unvery) {
                header("Location:./verifyAccount.php");
            } else {
                header("Location:./login.php");
            }
        } else {
            // Login failed
            header("Location:./login.php");
            // $response = ['error' => 'Invalid email or password'];
        }
    } else {
        // Login failed
        header("Location:./login.php");

        // $response = ['error' => 'Invalid email or password'];
    }

    // Send the JSON response back to the JavaScript
    echo json_encode($response);
}
