<?php
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');

include_once "../../config/Database.php";
include_once "../../model/Developer.php";

$database = new Database;
$db = $database->connect();

$developer = new Developer($db);
$result = $developer->readProject_leaders();
$devs_num = $result->rowCount();



if ($devs_num > 0) {

    $devs = array();
    $devs['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $devs_items = array(

            'project_name' => $project_name,
            'project_lead' => $dev_name

        );
        array_push($devs['data'], $devs_items);
    }
    echo json_encode($devs);
} else {
    echo json_encode(array('message' => 'Leaders does not exists'));
}
