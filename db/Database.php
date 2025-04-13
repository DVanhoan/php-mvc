<?php
class Database
{
    private string $server = "localhost";
    private string $user = "root";
    private string $password = "";
    private string $db = "crud";
    private mysqli $connection;

    public function __construct()
    {
        $this->connect();
    }

    private function connect(): void
    {
        $this->connection = new mysqli($this->server, $this->user, $this->password, $this->db);

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
