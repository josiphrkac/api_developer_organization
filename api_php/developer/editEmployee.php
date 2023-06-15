<?php

header('Content-Type: application/json');

include_once '../config/Database.php';
include_once '../model/Crud.php';

$database = new Database();
$db_conn = $database->connect();

$crud = new Crud($db_conn);

$json_input = file_get_contents("php://input");

$data = json_decode($json_input);

$crud->emp_name = $data->emp_name;
$crud->emp_role = $data->emp_role;
$crud->emp_salary = $data->emp_salary;
$crud->emp_id = $data->emp_id;


if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $result = $crud->updateEmployeeList();
    echo $result;
} else {
    echo json_encode(array('message' => 'Editing Employee Table Failed'));
}
