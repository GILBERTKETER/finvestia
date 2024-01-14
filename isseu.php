<?php
// isseu.php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    
function sanitize_input($data)
{
    // Sanitize the data to prevent XSS attacks
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8'); // Use ENT_QUOTES to handle both single and double quotes
    return $data;
}
    if (isset($_POST['issue'])) {
        $email = sanitize_input($_POST['userEmail']);
        $user = sanitize_input($_POST['username']);
        echo "recieved";
        echo '<br>';
        echo $email;
        echo '<br>';
        echo $user;
    } else {
        echo "sorry";
    }
} else {
    $response = array('success' => false, 'message' => 'Invalid request.');
    echo json_encode($response);
}
