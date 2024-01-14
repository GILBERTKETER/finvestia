<?php
session_start();
require('./db_conn.php');
$email = $_SESSION['LOGGED_IN_EMAIL'];
//lets check availability in the set_plan table
$checkPlan = "SELECT Package FROM set_plan WHERE Email_Address = ?";
$checkPlan_stmt = $mysqli->prepare($checkPlan);
$checkPlan_stmt->bind_param('s', $email);
$checkPlan_stmt->execute();
$resultingPlan = $checkPlan_stmt->get_result();
function sanitize_input($data)
{
    // Sanitize the data to prevent XSS attacks
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8'); // Use ENT_QUOTES to handle both single and double quotes
    return $data;
}
if ($resultingPlan->num_rows === 1) {

    if (isset($_POST['GoldButton'])) {
        $packageName = sanitize_input($_POST['GoldpackageName']);
        //lets update the db
        $updateSet_PlanTable = "UPDATE set_plan SET Package = ? WHERE Email_Address = ?";
        $update_stmt = $mysqli->prepare($updateSet_PlanTable);
        $update_stmt->bind_param('ss', $packageName, $email);
        $update_stmt->execute();
        echo "Successfully Changed to Gold";
    }
    if (isset($_POST['SilverButton'])) {
        $packageName = sanitize_input($_POST['SilverpackageName']);
        //lets update the db
        $updateSet_PlanTable = "UPDATE set_plan SET Package = ? WHERE Email_Address = ?";
        $update_stmt = $mysqli->prepare($updateSet_PlanTable);
        $update_stmt->bind_param('ss', $packageName, $email);
        $update_stmt->execute();
        echo "Successfully Changed to Silver";
    }
    if (isset($_POST['BronzeButton'])) {
        $packageName = sanitize_input($_POST['BronzepackageName']);
        //lets update the db
        $updateSet_PlanTable = "UPDATE set_plan SET Package = ? WHERE Email_Address = ?";
        $update_stmt = $mysqli->prepare($updateSet_PlanTable);
        $update_stmt->bind_param('ss', $packageName, $email);
        $update_stmt->execute();
        echo "Successfully Changed to Bronze";
    }
} else {
    echo "sorry!You cant set a plan!";
}
