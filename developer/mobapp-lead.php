<?php

header('Access-Control-Allow-Oriign: *');
header('Content-type: application/json');
header('Acces-Control-Allow-Methods: PUT');
header('Access-Conrol-Allow-Headers:Access-Conrol-Allow-Headers,Access-Conrol-Allow-Methods, Content-type, Authentication,X-Requested-With');

include_once "../config/Database.php";
include_once "../model/Developer.php";

$database = new Database;
$db = $database->connect();

$developer = new Employee($db);

$json = file_get_contents('php://input');
$data = json_decode($json);

$developer->lead_id = $data->lead_id;
$developer->project_id =  $data->project_id;

if ($developer->setProject_lead()) {
    echo json_encode(array('message' => 'Project lead is set'));
} else {
    echo json_encode(array('message' => 'Project lead is set'));
}
