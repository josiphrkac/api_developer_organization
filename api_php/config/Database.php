<?php

require_once __DIR__ . '/../vendor/autoload.php';

class Database
{
    private $host;

    private $user;
    private $pass;
    private $db_name;
    private $port;

    public function __construct()
    {

        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();

        $this->host = $_ENV['DB_HOST'];
        $this->user = $_ENV['DB_USER'];
        $this->pass = $_ENV['DB_PASS'];
        $this->db_name = $_ENV['DB_NAME'];
        $this->port = $_ENV['DB_PORT'];
    }

    public function connect()
    {
        $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->db_name}";

        $options = [

            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC

        ];
        try {

            $pdo = new PDO($dsn, $this->user, $this->pass, $options);
            return $pdo;
        } catch (PDOException $e) {

            throw new PDOException($e - getMessage(), (int) $e->getCode());
        }

    }

}