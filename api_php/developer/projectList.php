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

if($_SERVER['REQUEST_METHOD'] === 'GET'){
    $result = $crud->projectList();
    echo $result;

} else {
    $data =[
        'status'=>405,
        'message'=>'Only GET Method Allowed'
    ];
    header("HTTP/1.0 405 Only GET Method Allowed");
    echo json_encode($data);
}