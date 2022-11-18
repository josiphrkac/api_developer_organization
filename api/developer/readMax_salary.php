<?php
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');

include_once "../../config/Database.php";
include_once "../../model/Developer.php";

$database = new Database;
$db = $database->connect();

$developer = new Developer($db);
$developer->readMax_salary();

$salary = array(
    'id' => $developer->dev_id,
    'dev_name' => $developer->dev_name,
    'max_salary' => $developer->max_sal

);

print_r(json_encode($salary));
