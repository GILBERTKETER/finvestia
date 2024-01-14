<?php
$HOST = "localhost";
$USERNAME = "root";
$PASSWORD = "WEB DESIGNER";
$DATABASE = "profitedge";

$mysqli = new mysqli($HOST, $USERNAME, $PASSWORD, $DATABASE);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
$mysqli->set_charset("utf8mb4");
