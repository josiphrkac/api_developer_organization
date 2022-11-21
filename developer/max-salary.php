<?php
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');

include_once "../../config/Database.php";
include_once "../model/Developer.php";

$database = new Database;
$db = $database->connect();

$developer = new Employee($db);
$developer->readMax_salary();

$salary = array(
    'id' => $developer->emp_id,
    'dev_name' => $developer->emp_name,
    'max_salary' => $developer->max_sal

);

print_r(json_encode($salary));
