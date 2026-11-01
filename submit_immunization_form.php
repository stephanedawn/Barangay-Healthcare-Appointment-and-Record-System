<?php
include 'db_connection.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

$healthCenter = $data['healthCenter'];
$barangay = $data['barangay'];
$purok = $data['purok'];
$familyNo = $data['familyNo'];
$child = $data['child'];
$dob = $data['dob'];
$pob = $data['pob'];
$address = $data['address'];
$mother = $data['mother'];
$father = $data['father'];
$birthHeight = $data['birthHeight'];
$sex = $data['sex'];
$vaccinationRecord = json_encode($data['vaccinationRecord']);
$date = $data['date'];
$status = $data['status'];

$sql = "INSERT INTO immunization_records (
    healthCenter, barangay, purok, familyNo, child, dob, pob, address, mother, father, 
    birthHeight, sex, vaccinationRecord, date, status
) VALUES (
    '$healthCenter', '$barangay', '$purok', '$familyNo', '$child', '$dob', '$pob', '$address', '$mother', '$father',
    '$birthHeight', '$sex', '$vaccinationRecord', '$date', '$status'
)";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $conn->error]);
}

$conn->close();
?>