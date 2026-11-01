<?php
include 'db_connection.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

$name = $data['name'];
$dob = $data['dob'];
$contact = $data['contact'];
$address = $data['address'];
$spouse = $data['spouse'];
$children = $data['children'];
$clientType = $data['clientType'];
$fpReason = $data['fpReason'];
$methodUsed = $data['methodUsed'];
$medicalHistory = json_encode($data['medicalHistory']);
$vawRisks = json_encode($data['vawRisks']);
$physicalExam = json_encode($data['physicalExam']);
$acknowledgementNotes = $data['acknowledgementNotes'];
$guardianSignature = $data['guardianSignature'];
$acknowledgementDate = $data['acknowledgementDate'];
$date = $data['date'];
$status = $data['status'];
$recordType = $data['recordType'];

$sql = "INSERT INTO fp_records (
    name, dob, contact, address, spouse, children, clientType, fpReason, methodUsed, 
    medicalHistory, vawRisks, physicalExam, acknowledgementNotes, guardianSignature, 
    acknowledgementDate, date, status, recordType
) VALUES (
    '$name', '$dob', '$contact', '$address', '$spouse', '$children', '$clientType', '$fpReason', '$methodUsed',
    '$medicalHistory', '$vawRisks', '$physicalExam', '$acknowledgementNotes', '$guardianSignature',
    '$acknowledgementDate', '$date', '$status', '$recordType'
)";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $conn->error]);
}

$conn->close();
?>