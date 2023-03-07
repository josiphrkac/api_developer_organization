<?php
require_once __DIR__ .'/../vendor/autoload.php';

class Crud
{
    private $conn;
    public $emp_id;
    public $emp_name;
    public $emp_role;
    public $emp_salary;
    public $request_id;
    public $project_type;
    public $project_budget;
    public $project_description;
    public $project_deadline;
    public $proj_manager_id;
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

    public function projectList()
    {

        $sql = 'SELECT e.emp_name as project_lead, p.project_type, p.project_description
      FROM ' . $this->projectTable . ' p
      LEFT JOIN ' . $this->employeeTable . ' e ON p.proj_manager_id=e.emp_id';

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
        $sql = 'SELECT emp_id, emp_name, emp_role, emp_salary 
            FROM ' . $this->employeeTable . ' 
            WHERE emp_id = :emp_id';
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
            return [
                'status' => self::NOT_FOUND_STATUS,
                'message' => self::NOT_FOUND_MESSAGE,
            ];
        }
    }

    public function addProject()
    {
        $sql = 'INSERT INTO ' . $this->projectTable . ' SET 
        project_type = :project_type, project_budget = :project_budget,
        project_description = :project_description, project_deadline = :project_deadline, proj_manager_id = :proj_manager_id';

        $stmt = $this->conn->prepare($sql);

        $this->project_type = htmlspecialchars(strip_tags($this->project_type));
        $this->project_budget = htmlspecialchars(strip_tags($this->project_budget));
        $this->project_description = htmlspecialchars(strip_tags($this->project_description));


        if (!isset($this->project_deadline)) {
            $this->project_deadline = null;
        } else {
            $this->project_deadline = htmlspecialchars(strip_tags($this->project_deadline));
        }
        if (!isset($this->proj_manager_id)) {
            $this->proj_manager_id = null;
        } else {
            $this->proj_manager_id = htmlspecialchars(strip_tags($this->proj_manager_id));
        }

        $stmt->bindParam(':project_type', $this->project_type);
        $stmt->bindParam(':project_budget', $this->project_budget);
        $stmt->bindParam(':project_description', $this->project_description);
        $stmt->bindParam(':project_deadline', $this->project_deadline);
        $stmt->bindParam(':proj_manager_id', $this->proj_manager_id);


        if ($stmt->execute()) {
            return true;
        } else {


            printf("Error: %s.\n", $stmt->error);

            return false;
        }
    }

    public function editEmployeeTable()
    {
        $sql = 'UPDATE '. $this->employeeTable .'
        SET emp_name = :emp_name, emp_role= :emp_role, emp_salary = :emp_salary
        WHERE emp_id = :emp_id ';

        $stmt = $this->conn->prepare($sql);

        $this->emp_name = htmlspecialchars(strip_tags($this->emp_name));
        $this->emp_role = htmlspecialchars(strip_tags($this->emp_role));
        $this->emp_salary = htmlspecialchars(strip_tags($this->emp_salary));
        $this->emp_id = htmlspecialchars(strip_tags($this->emp_id));


        $stmt->bindParam(':emp_name', $this->emp_name);
        $stmt->bindParam(':emp_role', $this->emp_role);
        $stmt->bindParam(':emp_salary', $this->emp_salary);
        $stmt->bindParam(':emp_id', $this->emp_id);


        if ($stmt->execute()) {
            return true;
        } else {


            printf("Error: %s.\n", $stmt->error);

            return false;
        }

    }
    public function deleteRow() {
        $sql = 'DELETE FROM ' . $this->projectTable . ' WHERE request_id = :request_id';

        $stmt = $this->conn->prepare($sql);
        $this->request_id = htmlspecialchars(strip_tags($this->request_id));
        $stmt->bindParam(':request_id', $this->request_id);

        if ($stmt->execute()) {
            return true;
        } else {

            printf("Error: %s.\n", $stmt->error);

            return false;
        }


    }
}