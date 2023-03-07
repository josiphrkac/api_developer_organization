<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../config/Database.php';
include_once '../model/Crud.php';

$database = new Database();
$db = $database->connect();

$crud = new Crud($db);


$data = json_decode(file_get_contents('php://input'), true);


if (empty($data['request_id'])){
http_response_code(400);
echo json_encode(array('message' => 'Missing required data'));
exit();
}

$crud->request_id = $data['request_id'];


if ($crud->deleteRow()) {
http_response_code(200);
echo json_encode(array('message' => 'Project deleted'));
} else {
    http_response_code(500);
    echo json_encode(array('message' => 'Project not deleted'));
}