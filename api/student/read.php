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
if (isset($_GET['id'])) {
    $item = new Student($db);
    $item->id = isset($_GET['id']) ? $_GET['id'] : die();

    $item->getSingleStudent();
    if ($item->nama != null) {
        // create array
        $std_arr = array(
            "id" => $item->id,
            "nama" => $item->nama,
            "nim" => $item->nim,
            "jabatan" => $item->jabatan,
            "nama_himpunan" => $item->nama_himpunan,
            "usia" => $item->usia,
            "created" => $item->created
        );

        http_response_code(200);
        echo json_encode($std_arr);
    } else {
        http_response_code(404);
        echo json_encode("Student not found.");
    }
} else {
    $items = new Student($db);
    $stmt = $items->getStudent();
    $itemCount = $stmt->rowCount();

    // echo json_encode($itemCount);
    if ($itemCount > 0) {

        $studentArr = array();
        $studentArr["body"] = array();
        $studentArr["itemCount"] = $itemCount;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $e = array(
                "id" => $id,
                "nama" => $nama,
                "nim" => $nim,
                "jabatan" => $jabatan,
                "nama_himpunan" => $nama_himpunan,
                "usia" => $usia,
                "created" => $created
            );
            array_push($studentArr["body"], $e);
        }
        echo json_encode($studentArr);
    } else {
        http_response_code(404);
        echo json_encode(
            array("message" => "No record found.")
        );
    }
}

?>