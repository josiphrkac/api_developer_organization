<?php


class Database
{
    private $host = 'localhost';
    private $db_name = 'it_company';
    private $user = 'pma';
    private $pass = '';

    public $conn;

    public function connect()
    {
        $this->conn = null;
        try {
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->user, $this->pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection failed' . $e->getMessage();
        }
        return $this->conn;
    }
}
