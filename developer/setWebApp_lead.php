<?php

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Access-Control-Allow-Methods, Content-type, Authentication, X-Requested-With');

include_once "../../config/Database.php";
include_once "../../model/Developer.php";


$database = new Database;
$db = $database->connect();

$developer = new Developer($db);

$json = file_get_contents('php://input');
$data = json_decode($json);

$developer->project_id = $data->project_id;
$developer->lead_id = $data->lead_id;

if ($developer->setProject_lead()) {
    echo json_encode(array('message' => 'Project Lead is set'));
} else {
    echo json_encode(array('message' => 'Project Lead is not set'));
}
