<?php
header('Content-Type: application/json');
require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phone           = trim($_POST['phone'] ?? '');
    $password        = trim($_POST['password'] ?? '');
    $invitationCode  = trim($_POST['invitationCode'] ?? '');

    if (empty($phone) || empty($password)) {
        echo json_encode(['status' => 'error', 'message' => 'Phone number aur password zaroori hain.']);
        exit;
    }

    // Check if Phone already exists
    $checkUser = $conn->prepare("SELECT id FROM users WHERE phone = ?");
    $checkUser->bind_param("s", $phone);
    $checkUser->execute();
    $result = $checkUser->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Ye phone number pehle se registered hai!']);
        $checkUser->close();
        exit;
    }
    $checkUser->close();

    // Password Secure Hashing
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Database me Save Karein
    $stmt = $conn->prepare("INSERT INTO users (phone, password, invitation_code) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $phone, $hashedPassword, $invitationCode);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Registration Successful! Ab login karein.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Registration nahi ho paya. Dobara try karein.']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid Request Method']);
}
?>
