<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: GET');
header('Access-Control-Allow-Header, Content-Type, Access-Control-Allow-Headers, Authorization, X_Request-With');

include_once '../config/Database.php';
include_once '../model/Crud.php';


$database = new Database();
$db_conn = $database->connect();

$crud = new Crud($db_conn);

if (isset($_GET['emp_id'])) {
    $crud->emp_id = $_GET['emp_id'];
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Missing employee ID"));
    exit();
}

if ($data = $crud->singleDev()) {
    http_response_code(200);

    echo json_encode($data);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "Employee not found"));
}