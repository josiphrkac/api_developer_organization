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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = $crud->addEmployee();
    echo $result;
} else {
    echo json_encode(array('message' => 'Adding New Employee Failed'));
}
