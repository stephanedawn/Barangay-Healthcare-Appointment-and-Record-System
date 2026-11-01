<?php
// Include db config
require_once 'db_config.php';

// Set header to return JSON
header('Content-Type: application/json');

// Response structure
$response = ['success' => false, 'message' => '', 'role' => ''];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? '';

    if (empty($username) || empty($password) || empty($role)) {
        $response['message'] = 'Please fill all the fields.';
    } else {
        // Prepare a select statement
        $sql = "SELECT username, password, role FROM users WHERE username = ? AND role = ?";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ss", $param_username, $param_role);
            
            $param_username = $username;
            $param_role = $role;

            if ($stmt->execute()) {
                $stmt->store_result();

                if ($stmt->num_rows == 1) {
                    $stmt->bind_result($db_username, $db_password, $db_role);
                    if ($stmt->fetch()) {
                        // IMPORTANT: In a real application, you should use password_verify() with hashed passwords.
                        if ($password === $db_password) {
                            $response['success'] = true;
                            $response['message'] = 'Login successful!';
                            $response['role'] = $db_role;
                        } else {
                            $response['message'] = 'Incorrect password.';
                        }
                    }
                } else {
                    $response['message'] = 'User not found with that role.';
                }
            } else {
                $response['message'] = 'Oops! Something went wrong. Please try again later.';
            }
            $stmt->close();
        }
    }
    $conn->close();
}

echo json_encode($response);
?>