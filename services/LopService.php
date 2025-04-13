<?php

namespace services;

require_once("DAOInterface.php");

use Lop;
use mysqli;
use Database;


class LopService implements DAOInterface
{
    private mysqli $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function insert(object $t): int
    {
        if (!$t instanceof Lop) return 0;

        $stmt = $this->conn->prepare("INSERT INTO lop (tenlop) VALUES (?)");
        $tenlop = $t->getTenlop();
        $stmt->bind_param("s", $tenlop);
        $stmt->execute();

        return $stmt->insert_id;
    }

    public function update(object $t): int
    {
        if (!$t instanceof Lop) return 0;

        $stmt = $this->conn->prepare("UPDATE lop SET tenlop=? WHERE id=?");
        $id = $t->getId();
        $tenlop = $t->getTenlop();
        $stmt->bind_param("si", $tenlop, $id);
        $stmt->execute();

        return $stmt->affected_rows;
    }

    public function delete(object $t): int
    {
        if (!$t instanceof Lop) return 0;

        $stmt = $this->conn->prepare("DELETE FROM lop WHERE id=?");
        $id = $t->getId();
        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->affected_rows;
    }

    public function selectAll(): array
    {
        $result = $this->conn->query("SELECT * FROM lop");
        $list = [];

        while ($row = $result->fetch_assoc()) {
            $list[] = new Lop((int)$row['id'], $row['tenlop']);
        }

        return $list;
    }

    public function selectById(int $id): ?object
    {
        $stmt = $this->conn->prepare("SELECT * FROM lop WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            return new Lop((int)$row['id'], $row['tenlop']);
        }
        return null;
    }

    public function search(string $key): array
    {
        $stmt = $this->conn->prepare("SELECT * FROM lop WHERE tenlop LIKE ?");
        $like = "%$key%";
        $stmt->bind_param("s", $like);
        $stmt->execute();

        $result = $stmt->get_result();
        $list = [];

        while ($row = $result->fetch_assoc()) {
            $list[] = new Lop((int)$row['id'], $row['tenlop']);
        }

        return $list;
    }
}