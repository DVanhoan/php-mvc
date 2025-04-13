<?php

class Lop implements \JsonSerializable
{
    private int $id;
    private string $tenlop;
    private array $danhSachHocSinh = [];

    public function __construct(int $id, string $tenlop)
    {
        $this->id = $id;
        $this->tenlop = $tenlop;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTenlop(): string
    {
        return $this->tenlop;
    }

    public function getDanhSachHocSinh(): array
    {
        return $this->danhSachHocSinh;
    }

    public function themHocSinh(HocSinh $hs): void
    {
        $this->danhSachHocSinh[] = $hs;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'tenlop' => $this->tenlop,
            'danhSachHocSinh' => $this->danhSachHocSinh,
        ];
    }
}