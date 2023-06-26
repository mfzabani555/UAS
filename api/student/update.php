<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/database.php';
include_once '../../models/student.php';

$database = new Database();
$db = $database->getConnection();

$item = new Student($db);

$data = json_decode(file_get_contents("php://input"));

$item->id = $data->id;

// student values
$item->nama = $data->nama;
$item->nim = $data->nim;
$item->jabatan = $data->jabatan;
$item->nama_himpunan = $data->nama_himpunan;
$item->usia = $data->usia;
$item->created = date('Y-m-d H:i:s');

if ($item->updateStudent()) {
    echo json_encode(['message' => 'Student updated successfully.']);
} else {
    echo json_encode(['message' => 'Student could not be updated.']);
}
?>