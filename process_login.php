<?php
session_start();
header('Content-Type: application/json');

$admin_user = "admin";
$admin_pass = "123456"; // Yahan apna password rakhein

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'] ?? '';
    $pass = $_POST['password'] ?? '';

    if ($user === $admin_user && $pass === $admin_pass) {
        echo json_encode(['status' => 'success', 'message' => 'Admin Login Successful!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Galat Username ya Password!']);
    }
}
?>
