<?php
session_start();
header('Content-Type: application/json');
require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($username) || empty($password)) {
        echo json_encode(['status' => 'error', 'message' => 'Username/Phone aur Password zaroori hain.']);
        exit;
    }

    // Database me user check karein
    $stmt = $conn->prepare("SELECT id, phone, password FROM users WHERE phone = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Password Match verify karein
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['phone'] = $user['phone'];

            echo json_encode(['status' => 'success', 'message' => 'Login Successful!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Galat password! Dobara try karein.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'User nahi mila! Pehle register karein.']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid Request']);
}
?>
