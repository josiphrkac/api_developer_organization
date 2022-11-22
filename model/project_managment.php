<?php

class Request
{
    private $conn;
    private $proj_table = 'project_managment';
    private $empl_table = 'employee';

    public $id;
    public $project_type;
    public $project_budget;
    public $project_deadline;
    public $project_description;
    public $project_manager;



    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function readAll_projects()
    {
        $query = 'SELECT e.emp_role as project_manager, p.request_id, p.project_type, p.project_budget, project_deadline, project_description
        FROM ' . $this->proj_table . ' p
        LEFT JOIN ' . $this->empl_table . ' e
        ON p.proj_manager_id=e.emp_id
        ORDER BY project_deadline ASC';

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
