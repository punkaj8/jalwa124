<?php
$host = "localhost";
$username = "root";       // Hosting me apna MySQL Username daalein
$password = "";           // Hosting me apna MySQL Password daalein
$dbname   = "jalwabet_db"; // Apne Database ka Naam

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}
?>
