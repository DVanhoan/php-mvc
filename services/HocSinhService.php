<?php

namespace services;

use HocSinh;
use Lop;
use mysqli;
use Database;

class HocSinhService implements DAOInterface
{
    private mysqli $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function insert(object $t): int
    {
        if (!$t instanceof HocSinh) return 0;

        $stmt = $this->conn->prepare("INSERT INTO hocsinh (ten, ngaysinh, gioitinh, diachi, lop) VALUES (?, ?, ?, ?, ?)");
        $ten     = $t->getTen();
        $ngaysinh = $t->getNgaysinh();
        $gioitinh = $t->getGioitinh();
        $diachi  = $t->getDiachi();
        $lopId   = $t->getLop()->getId();

        $stmt->bind_param("ssssi", $ten, $ngaysinh, $gioitinh, $diachi, $lopId);
        $stmt->execute();

        return $stmt->insert_id;
    }

    public function update(object $t): int
    {
        if (!$t instanceof HocSinh) return 0;

        $stmt = $this->conn->prepare("UPDATE hocsinh SET ten=?, ngaysinh=?, gioitinh=?, diachi=?, lop=? WHERE id=?");
        $ten      = $t->getTen();
        $ngaysinh = $t->getNgaysinh();
        $gioitinh = $t->getGioitinh();
        $diachi   = $t->getDiachi();
        $lopId    = $t->getLop()->getId();
        $id       = $t->getId();

        $stmt->bind_param("ssissi", $ten, $ngaysinh, $gioitinh, $diachi, $lopId, $id);
        $stmt->execute();

        return $stmt->affected_rows;
    }

    public function delete(object $t): int
    {
        if (!$t instanceof HocSinh) return 0;

        $stmt = $this->conn->prepare("DELETE FROM hocsinh WHERE id=?");
        $id = $t->getId();
        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->affected_rows;
    }

    public function selectAll(): array
    {
        $result = $this->conn->query("SELECT * FROM hocsinh");
        $list = [];

        while ($row = $result->fetch_assoc()) {
            $lop = new Lop((int)$row['lop'], "");
            $list[] = new HocSinh((int)$row['id'], $row['ten'], $row['ngaysinh'], $row['gioitinh'], $row['diachi'], $lop);
        }

        return $list;
    }

    public function selectById(int $id): ?object
    {
        $stmt = $this->conn->prepare("SELECT * FROM hocsinh WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $lop = new Lop((int)$row['lop'], "");
            return new HocSinh((int)$row['id'], $row['ten'], $row['ngaysinh'], $row['gioitinh'], $row['diachi'], $lop);
        }

        return null;
    }

    public function search(string $key): array
    {
        $stmt = $this->conn->prepare("SELECT * FROM hocsinh WHERE ten LIKE ?");
        $like = "%$key%";
        $stmt->bind_param("s", $like);
        $stmt->execute();

        $result = $stmt->get_result();
        $list = [];

        while ($row = $result->fetch_assoc()) {
            $lop = new Lop((int)$row['lop'], "");
            $list[] = new HocSinh((int)$row['id'], $row['ten'], $row['ngaysinh'], $row['gioitinh'], $row['diachi'], $lop);
        }

        return $list;
    }

    public function selectAllHocSinhByLopId(int $lopId): array
    {
        $stmt = $this->conn->prepare("SELECT * FROM hocsinh WHERE lop=?");
        $stmt->bind_param("i", $lopId);
        $stmt->execute();

        $result = $stmt->get_result();
        $list = [];

        while ($row = $result->fetch_assoc()) {
            $lop = new Lop((int)$row['lop'], "");
            $list[] = new HocSinh((int)$row['id'], $row['ten'], $row['ngaysinh'], $row['gioitinh'], $row['diachi'], $lop);
        }

        return $list;
    }
}