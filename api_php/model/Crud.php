<?php
require_once __DIR__ . '/../vendor/autoload.php';

class Crud
{
    private $conn;
    public $emp_id;
    public $emp_name;
    public $emp_role;
    public $emp_salary;
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
        $sql = 'SELECT id, emp_name, emp_role, emp_salary FROM ' . $this->employeeTable . ' ';

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

    public function projectList()
    {

        $sql = 'SELECT e.emp_name, p.project_name, p.project_description
                FROM ' . $this->projectTable . ' p
                LEFT JOIN ' . $this->employeeTable . ' e ON p.lead_id=e.id';

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

    public function singleDev()
    {
        $sql = 'SELECT id, emp_name, emp_role, emp_salary 
               FROM ' . $this->employeeTable . ' 
               WHERE id = :emp_id';

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':emp_id', $this->emp_id);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $employee = $stmt->fetch();
            return [
                'status' => self::SUCCESS_STATUS,
                'message' => self::SUCCESS_MESSAGE,
                'Employee' => $employee
            ];
        } else {
            $data = [
                'status' => self::NOT_FOUND_STATUS,
                'message' => self::NOT_FOUND_MESSAGE
            ];
            header("HTTP/1.0" . self::NOT_FOUND_STATUS . " " . self::NOT_FOUND_MESSAGE);
            return json_encode($data);
        }
    }

    public function addEmployee()
    {
        $sql = 'INSERT INTO ' . $this->employeeTable . ' (emp_name, emp_role, emp_salary) VALUES (?, ?, ?)';

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $this->emp_name);
        $stmt->bindParam(2, $this->emp_role);
        $stmt->bindParam(3, $this->emp_salary);

        if ($stmt->execute()) {
            $sql2 = 'SELECT * FROM ' . $this->employeeTable . ' ORDER BY ID DESC LIMIT 1';
            $stmt2 = $this->conn->prepare($sql2);
            $stmt2->execute();
            $newEmployee = $stmt2->fetch();
            $data = [
                'status' => self::SUCCESS_STATUS,
                'message' => self::SUCCESS_MESSAGE,
                'New Employee' => $newEmployee
            ];
            header("HTTP/1.0" . self::SUCCESS_STATUS . " " . self::SUCCESS_MESSAGE);
            return json_encode($data);
        } else {

            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }
    public function updateEmployeeList()
    {
        $sql = 'UPDATE ' . $this->employeeTable . ' SET emp_name = :emp_name, emp_role = :emp_role, emp_salary = :emp_salary
        WHERE id = :id';

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':emp_name', $this->emp_name);
        $stmt->bindParam(':emp_role', $this->emp_role);
        $stmt->bindParam(':emp_salary', $this->emp_salary);
        $stmt->bindParam(':id', $this->emp_id);

        if ($stmt->execute()) {
            $sql2 = 'SELECT * FROM ' . $this->employeeTable . ' WHERE id = :id';
            $stmt2 = $this->conn->prepare($sql2);
            $stmt2->bindParam(':id', $this->emp_id);
            $stmt2->execute();
            $updatedEmployee = $stmt2->fetch();
            $data = [
                'status' => self::SUCCESS_STATUS,
                'message' => self::SUCCESS_MESSAGE,
                'Updated Employee' => $updatedEmployee

            ];

            header("HTTP/1.0" . self::SUCCESS_STATUS . " " . self::SUCCESS_MESSAGE);
            return json_encode($data);
        } else {

            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }
}
