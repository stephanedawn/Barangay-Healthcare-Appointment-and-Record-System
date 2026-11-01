<?php
include 'db_connection.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

$name = $data['name'];
$age = $data['age'];
$address = $data['address'];
$contact = $data['contact'];
$gender = $data['gender'];
$heent = json_encode($data['heent']);
$familyHistory = json_encode($data['familyHistory']);
$obstetricalHistory = json_encode($data['obstetricalHistory']);
$vitalSigns = json_encode($data['vitalSigns']);
$date = $data['date'];
$diagnosis = $data['diagnosis'];
$status = $data['status'];
$recordType = $data['recordType'];

$sql = "INSERT INTO prenatal_records (
    name, age, address, contact, gender, heent, familyHistory, obstetricalHistory, 
    vitalSigns, date, diagnosis, status, recordType
) VALUES (
    '$name', '$age', '$address', '$contact', '$gender', '$heent', '$familyHistory', 
    '$obstetricalHistory', '$vitalSigns', '$date', '$diagnosis', '$status', '$recordType'
)";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $conn->error]);
}

$conn->close();
?>