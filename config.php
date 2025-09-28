<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "nema-music";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    error_log("Database connection failed: " . $conn->connect_error);
    die("Database connection error. Please try again later.");
}