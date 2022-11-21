<?php
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');

include_once "../config/Database.php";
include_once "../model/Developer.php";

$database = new Database;
$db = $database->connect();

$developer = new Employee($db);
$developer->emp_id = isset($_GET['emp_id']) ? $_GET['emp_id'] : die();
$developer->read_single_dev();

$emp_spec = array(
    'employe_name' => $developer->emp_name,
    'employe_role' => $developer->emp_role,
    'employee_salary' => $developer->emp_salary
);

echo json_encode(array($emp_spec));
