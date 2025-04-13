<?php
require 'vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

class Database
{
    private string $server;
    private string $user;
    private string $password;
    private string $db;
    private int $port;
    private mysqli $connection;

    public function __construct()
    {
        $this->server   = $_ENV['DB_SERVER'] ?? 'localhost';
        $this->user     = $_ENV['DB_USER'] ?? 'root';
        $this->password = $_ENV['DB_PASSWORD'] ?? '';
        $this->db       = $_ENV['DB_NAME'] ?? 'crud';
        $this->port     = (int)($_ENV['DB_PORT'] ?? 3306);

        $this->connect();
    }

    private function connect(): void
    {
        $this->connection = new mysqli($this->server, $this->user, $this->password, $this->db, $this->port);

        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public function getConnection(): mysqli
    {
        return $this->connection;
    }

    public function close(): void
    {
        $this->connection->close();
    }
}
