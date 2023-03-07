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


if (
    empty($data['emp_name']) ||
    empty($data['emp_role']) ||
    empty($data['emp_salary']) ||
    empty($data['emp_id'])

) {
    http_response_code(400);
    echo json_encode(array('message' => 'Missing required data'));
    exit();
}

$crud->emp_name = $data['emp_name'];
$crud->emp_role = $data['emp_role'];
$crud->emp_salary = $data['emp_salary'];
$crud->emp_id = $data['emp_id'];


if ($crud->editEmployeeTable()) {
    http_response_code(200);
    echo json_encode(array('message' => 'Employee updated'));
} else {
    http_response_code(500);
    echo json_encode(array('message' => 'employee not updated'));
}