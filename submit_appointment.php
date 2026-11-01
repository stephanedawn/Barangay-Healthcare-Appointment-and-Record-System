<?php
include 'db_connection.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

$name = $data['name'];
$age = $data['age'];
$contact = $data['contact'];
$location = $data['location'];
$gender = $data['gender'];
$type = $data['type'];
$date = $data['date'];
$time = $data['time'];
$details = $data['details'];
$status = $data['status'];
$username = $data['username'];

$sql = "INSERT INTO appointments (name, age, contact, location, gender, type, date, time, details, status, username, submittedAt)
VALUES ('$name', '$age', '$contact', '$location', '$gender', '$type', '$date', '$time', '$details', '$status', '$username', CURDATE())";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $conn->error]);
}

$conn->close();
?>
