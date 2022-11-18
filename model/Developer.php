<?php


class Developer
{
    public $conn;
    private $project_table = 'project';
    private $dev_table = 'developer';

    public $dev_id;
    public $dev__name;
    public $dev_role;
    public $dev_salary;
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

        $query = 'SELECT p.project_name, d.dev_name
        FROM ' . $this->project_table . ' p
        INNER JOIN developer d
        ON p.lead_id = d.dev_id';

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readBackend_dev()
    {
        $query = "SELECT d.dev_name
        FROM " . $this->dev_table . " d 
        WHERE d.dev_role 
        LIKE 'back%'";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    public function readMax_salary()
    {
        $query = 'SELECT d.dev_id, d.dev_name, d.dev_salary
        FROM ' . $this->dev_table . ' d 
        ORDER BY dev_salary DESC
        LIMIT 1';

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);


        $this->dev_id = $row['dev_id'];
        $this->dev_name = $row['dev_name'];
        $this->max_sal = $row['dev_salary'];
    }

    public function readFront_dev()
    {
        $query = "SELECT d.dev_name
        FROM " . $this->dev_table . " d 
        WHERE d.dev_role 
        LIKE 'front%'";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
