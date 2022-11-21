<?php

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');

include_once "../../config/Database.php";
include_once "../model/Developer.php";

$database = new Database;
$db = $database->connect();

$developer = new Employee($db);
$result = $developer->readBackend_dev();
$num_back = $result->rowCount();

if ($num_back > 0) {



    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $back_values = array(
            'backdevs_name' => $emp_name
        );
        echo json_encode($back_values);
    }
} else {
    echo json_encode(array('message' => 'Backend developer does not exists in company'));
}
