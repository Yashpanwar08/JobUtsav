<?php
$servername = "localhost"; // Hostinger MySQL server (use 'localhost' for shared hosting)
$username   = "u293157276_job_utsav123"; // your MySQL username
$password   = "2025#Human"; // your MySQL password
$dbname     = "u293157276_job_utsavfinal"; // your MySQL database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>