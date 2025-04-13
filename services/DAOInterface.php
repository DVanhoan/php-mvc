<?php

namespace services;

interface DAOInterface
{
    public function insert(object $t): int;

    public function update(object $t): int;

    public function delete(object $t): int;

    public function selectAll(): array;

    public function selectById(int $id): ?object;

    public function search(string $key): array;
}
