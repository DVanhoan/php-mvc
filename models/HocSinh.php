<?php

require_once 'Lop.php';

class HocSinh implements JsonSerializable
{
    private int $id;
    private string $ten;
    private string $ngaysinh;
    private string $gioitinh;
    private string $diachi;
    private Lop $lop;

    public function __construct(int $id, string $ten, string $ngaysinh, string $gioitinh, string $diachi, Lop $lop)
    {
        $this->id = $id;
        $this->ten = $ten;
        $this->ngaysinh = $ngaysinh;
        $this->gioitinh = $gioitinh;
        $this->diachi = $diachi;
        $this->lop = $lop;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getTen(): string
    {
        return $this->ten;
    }

    public function setTen(string $ten): void
    {
        $this->ten = $ten;
    }

    public function getNgaysinh(): string
    {
        return $this->ngaysinh;
    }

    public function setNgaysinh(string $ngaysinh): void
    {
        $this->ngaysinh = $ngaysinh;
    }

    public function getGioitinh(): string
    {
        return $this->gioitinh;
    }

    public function setGioitinh(string $gioitinh): void
    {
        $this->gioitinh = $gioitinh;
    }

    public function getDiachi(): string
    {
        return $this->diachi;
    }

    public function setDiachi(string $diachi): void
    {
        $this->diachi = $diachi;
    }

    public function getLop(): Lop
    {
        return $this->lop;
    }

    public function setLop(Lop $lop): void
    {
        $this->lop = $lop;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'ten' => $this->ten,
            'ngaysinh' => $this->ngaysinh,
            'gioitinh' => $this->gioitinh,
            'diachi' => $this->diachi,
            'lop' => $this->lop->getId(),
        ];
    }
}
