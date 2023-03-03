<?php
require_once __DIR__ .'/../vendor/autoload.php';

class Crud
{
    private $conn;
    private $employeeTable;
    private $projectTable;
    const SUCCESS_STATUS = 200;
    const NOT_FOUND_STATUS = 404;
    const ERROR_STATUS = 500;
    const SUCCESS_MESSAGE = '200 Success OK';
    const NOT_FOUND_MESSAGE = 'Not Found';
    const ERROR_MESSAGE = 'Internal Server Error';

    public function __construct($db_conn)
    {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();

        $this->conn = $db_conn;
        $this->employeeTable = $_ENV['DB_EMPLOYEE_TABLE'];
        $this->projectTable = $_ENV['DB_PROJECT_TABLE'];
    }

    public function employeeList()
    {
        $sql = 'SELECT emp_id, emp_name, emp_role, emp_salary FROM ' . $this->employeeTable . ' ';
        $stmt = $this->conn->prepare($sql);

        if ($stmt->execute()) {

            $num_rows = $stmt->rowCount();
            if (!empty($num_rows)) {

                $data = [
                    'status' => self::SUCCESS_STATUS,
                    'message' => self::SUCCESS_MESSAGE,
                    'All Employees' => $stmt->fetchAll()
                ];
                header("HTTP/1.0" . self::SUCCESS_STATUS . " " . self::SUCCESS_MESSAGE);
                return json_encode($data);

            } else
                $data = [
                    'status' => self::NOT_FOUND_STATUS,
                    'message' => self::NOT_FOUND_MESSAGE
                ];
            header("HTTP/1.0" . self::NOT_FOUND_STATUS . " " . self::NOT_FOUND_MESSAGE);
            return json_encode($data);
        } else {
            $data = [
                'status' => self::ERROR_STATUS,
                'message' => self::ERROR_MESSAGE
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    }

}