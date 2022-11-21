<?php


class Employee
{
    public $conn;
    private $project_table = 'project';
    private $emp_table = 'employee';

    public $emp_id;
    public $emp__name;
    public $emp_role;
    public $emp_salary;
    public $lead_id;
    public $project_id;
    public $project_name;
    public $back_dev;
    public $max_sal;



    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function setProject_lead()
    {
        $query = 'UPDATE ' . $this->project_table . '  
         SET 
         lead_id = :lead_id 
         WHERE
         project_id = :project_id';

        $stmt = $this->conn->prepare($query);

        $this->lead_id = htmlspecialchars(strip_tags($this->lead_id));
        $this->project_id = htmlspecialchars(strip_tags($this->project_id));

        $stmt->bindParam(':lead_id', $this->lead_id);
        $stmt->bindParam(':project_id', $this->project_id);

        if ($stmt->execute()) {

            return true;
        } else {
            printf("Error %s \n", $stmt->error);
            return false;
        }
    }

    public function readProject_leaders()
    {

        $query = 'SELECT p.project_name, e.emp_name
        FROM ' . $this->project_table . ' p
        INNER JOIN ' . $this->emp_table . ' e 
        ON p.lead_id = e.emp_id';

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }


    public function readMax_salary()
    {
        $query = 'SELECT e.emp_id, e.emp_name, e.emp_salary
        FROM ' . $this->emp_table . ' e
        ORDER BY emp_salary DESC
        LIMIT 1';

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);


        $this->emp_id = $row['emp_id'];
        $this->emp_name = $row['emp_name'];
        $this->max_sal = $row['emp_salary'];
    }

    public function readFront_dev()
    {
        $query = "SELECT e.emp_name
        FROM ' . $this->emp_table . ' e
        WHERE e.emp_role 
        LIKE 'front%'";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    public function readBackend_dev()
    {
        $query = "SELECT e.emp_name
        FROM ' . $this->emp_table . ' e
        WHERE e.emp_role 
        LIKE 'back%'";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
