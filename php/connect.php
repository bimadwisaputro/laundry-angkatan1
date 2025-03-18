<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "angkatan1_laundry";

$conn = mysqli_connect($host, $user, $password, $db);
// Check connection
if (!$conn) {
    die("Connection failed: ");
    exit();
}
