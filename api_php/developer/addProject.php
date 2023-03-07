<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../config/Database.php';
include_once '../model/Crud.php';

$database = new Database();
$db = $database->connect();

$crud = new Crud($db);

// Get data from the request body
$data = json_decode(file_get_contents('php://input'), true);

// Validate required data
if (
    empty($data['project_type']) ||
    empty($data['project_budget']) ||
    empty($data['project_description']) ||
    empty($data['project_deadline']) ||
    empty($data['proj_manager_id'])
) {
    http_response_code(400);
    echo json_encode(array('message' => 'Missing required data'));
    exit();
}

// Set properties
$crud->project_type = $data['project_type'];
$crud->project_budget = $data['project_budget'];
$crud->project_description = $data['project_description'];
$crud->project_deadline = $data['project_deadline'];
$crud->proj_manager_id = $data['proj_manager_id'];

// Create project
if ($crud->addProject()) {
    http_response_code(200);
    echo json_encode(array('message' => 'Project Added'));
} else {
    http_response_code(500);
    echo json_encode(array('message' => 'Project not added'));
}