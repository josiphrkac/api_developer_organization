<?php
header('Access-Control-Allow-Origin: *');
header('Content-type: applicatioj/json');

require_once "../config/Database.php";
require_once "../model/project_managment.php";

$database = new Database;
$db  = $database->connect();

$newproject = new Request($db);
$result = $newproject->readAll_projects();
$num = $result->rowCount();

if ($num > 0) {

    $projects_data['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $project_items = array(
            'request_id' => $request_id,
            'project_type' => $project_type,
            'project_budget' => $project_budget,
            'project_description' => $project_description,
            'project_deadline' => $project_deadline,
            'project_manager' => $project_manager
        );
        array_push($projects_data['data'], $project_items);
    }
    echo json_encode($projects_data['data']);
} else {
    echo json_encode(array('message' => 'New project does not exists'));
}
